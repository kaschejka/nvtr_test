<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\used_barcode;
use Funct\Strings;

class createOrderController extends Controller
{

  // Функция book бронирует заказ.
  // Входные параметры см. документацию к API booke
  // Ваозращаемое значение: true (в случае успешной брони) или false (в случае ошибки)
   function book($event_id, $event_date, $ticket_adult_price, $ticket_adult_quantity, $ticket_kid_price, $ticket_kid_quantity, $barcode)
  {
    $curl = curl_init();
    curl_setopt_array($curl, array(
      CURLOPT_URL => 'http://localhost/api/book',
      CURLOPT_RETURNTRANSFER => true,
      CURLOPT_ENCODING => '',
      CURLOPT_MAXREDIRS => 10,
      CURLOPT_TIMEOUT => 0,
      CURLOPT_FOLLOWLOCATION => true,
      CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
      CURLOPT_CUSTOMREQUEST => 'POST',
      CURLOPT_POSTFIELDS =>"{
        \"event_id\": $event_id,
        \"event_date\": $event_date,
        \"ticket_adult_price\": $ticket_adult_price,
        \"ticket_adult_quantity\": $ticket_adult_quantity,
        \"ticket_kid_price\": $ticket_kid_price,
        \"ticket_kid_quantity\": $ticket_kid_quantity,
        \"barcode\": $barcode
    }",
      CURLOPT_HTTPHEADER => array(
        'Content-Type: application/json'
      ),
    ));
    $response = curl_exec($curl);
    curl_close($curl);
    if (Strings\contains($response, 'error')) {
      return false;
    } else {
      return true;
    }
  }

// Функция создания barcode
// Входные данные:
// user_id - ID пользователя
// Результат выполнения функции:true или false
  function createBarcode($user_id){
cr:
// Получаем ранее использованные barcode из таблицы used_barcodes
    $usedBarcode = used_barcode::select('barcode')
                ->get();
    $usedBarcode =  $usedBarcode->toArray();

    // Формируем barcode до тех пор, пока он не будет найден в массиве $usedBarcode (использованные barcode)
    do {
    $barcode = rand(100,getrandmax()).rand(100,getrandmax());
} while (in_array($barcode,$usedBarcode,true));

// Созраняем User_id и barcode в таблицу использованных used_barcodes
$createBarcode = new used_barcode;
$createBarcode->barcode = $barcode;
$createBarcode->user_id = $user_id;
$createBarcode->save();

// Исключаем возможность присвоения двум заказам одного barcode
// Если количеств найденных заказов больше 1, то удаляем запись и выполняем функцию заново
$usedBarcode = used_barcode::where('barcode', $barcode)->get();
$usedBarcode =  $usedBarcode->toArray();
$cnt =count($usedBarcode);
if ($cnt > 1) {
  $deletedRows = used_barcode::where(([['barcode','=', $barcode],
    ['user_id','=',$user_id]]))->delete();
    goto cr;
}

return $barcode;
  }



// Функция создания заказа
// Входные переменные:
// user_id - ID пользователя
// event_id - ID события
// event_date - дата события. Переменная типа string.
// ticket_adult_price - цена за взрослый билет
// ticket_adult_quantity - количество взрослых билетов
// ticket_kid_price - цена детского билета
// ticket_kid_quantity - количество детских билетов
// Возвращаемый результат - ответ от сторонней API (функция approve)

    public function addOrder(Request $req){

      //1.Формируем barcode через функцию createBarcode. В функцию пеедаем id пользователя
      //2.Бронируем заказ. Передваемые пераметры описаны в документации по сторонней API (функция book)
      //Переменная $book, после бронирования имеет два состояния true или false.
      //True при удачном бронироании. False при неудачном бронироании заказа.
      //В случае неудачного бронирования повторяем первые два действия
do {
  $barcode = $this->createBarcode($req->user_id);
  $book = $this->book($req->event_id, $req->event_date, $req->ticket_adult_price, $req->ticket_adult_quantity, $req->ticket_kid_price, $req->ticket_kid_quantity, $barcode);
} while ($book == false);

// Отправляем barcode для подтверждения заказа
// См. документацию по сторонней API (функция approve)
$curl = curl_init();
curl_setopt_array($curl, array(
  CURLOPT_URL => 'http://localhost/api/approve',
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => '',
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 0,
  CURLOPT_FOLLOWLOCATION => true,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => 'POST',
  CURLOPT_POSTFIELDS =>"{
    \"barcode\": $barcode
}",
  CURLOPT_HTTPHEADER => array(
    'Content-Type: application/json'
  ),
));

$response = curl_exec($curl);
curl_close($curl);

// Проверяем response подтверждения заказа
// В случае обнаружение строки error в теле ответа, удаляем barcode из таблицы used_barcode
// Возращаем тело ответа
if (Strings\contains($response, 'error')) {
  $deletedRows = used_barcode::where('barcode', $barcode)->delete();
  return $response;
}


// Сохраняем данные в таблице order и возращаем тело ответа (Удачное подтверждение заказа)
      $order = new Order;
      $order->event_id = $req->event_id;
      $order->event_date = $req->event_date;
      $order->ticket_adult_price = $req->ticket_adult_price;
      $order->ticket_adult_quantity = $req->ticket_adult_quantity;
      $order->ticket_kid_price = $req->ticket_kid_price;
      $order->ticket_kid_quantity = $req->ticket_kid_quantity;
      $order->barcode = $barcode;
      $order->user_id = $req->user_id;
      $order->equal_price = $req->ticket_adult_price * $req->ticket_adult_quantity + $req->ticket_kid_price * $req->ticket_kid_quantity;
      $order->save();

      return $response;
    }
}
