<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\used_barcode;
use Funct\Strings;

class createOrderController extends Controller
{
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

  function createBarcode(){
cr:
    $usedBarcode = used_barcode::select('barcode')
                ->get();
    $usedBarcode =  $usedBarcode->toArray();
    do {
    $barcode = rand(100,getrandmax()).rand(100,getrandmax());
} while (in_array($barcode,$usedBarcode,true));
$createBarcode = new used_barcode;
// $user_id = auth()->id;
$user_id = 1;
$createBarcode->barcode = $barcode;
$createBarcode->user_id = $user_id;
$createBarcode->save();
$usedBarcode = used_barcode::where('barcode', $barcode)->get();
$usedBarcode =  $usedBarcode->toArray();
$cnt =count($usedBarcode);
if ($cnt >= 2) {
  $deletedRows = used_barcode::where(([['barcode','=', $barcode],
    ['user_id','=',$user_id]]))->delete();
    goto cr;
}

return $barcode;
  }

    public function addOrder(Request $req){
      // $user_id = auth()->id;
      $user_id = 1;
do {
  $barcode = $this->createBarcode();
  $book = $this->book($req->event_id, $req->event_date, $req->ticket_adult_price, $req->ticket_adult_quantity, $req->ticket_kid_price, $req->ticket_kid_quantity, $barcode);
} while ($book == false);

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

if (Strings\contains($response, 'error')) {
  $deletedRows = used_barcode::where('barcode', $barcode)->delete();
  return $response;
}

      $order = new Order;
      $order->event_id = $req->event_id;
      $order->event_date = $req->event_date;
      $order->ticket_adult_price = $req->ticket_adult_price;
      $order->ticket_adult_quantity = $req->ticket_adult_quantity;
      $order->ticket_kid_price = $req->ticket_kid_price;
      $order->ticket_kid_quantity = $req->ticket_kid_quantity;
      $order->barcode = $barcode;
      $order->user_id = $user_id;
      $order->equal_price = $req->ticket_adult_price * $req->ticket_adult_quantity + $req->ticket_kid_price * $req->ticket_kid_quantity;
      $order->save();

      return [ "message" => 'order successfully approved'];
    }
}
