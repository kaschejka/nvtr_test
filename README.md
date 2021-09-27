<h1>Задание №2</h1>
<lable>Таблица order</lable>
<table>
    <thead>
    <tr>
<td>id</td><td>user_id</td><td>event_id</td><td>barcode_order</td><td>created</td>
     </tr>
       </thead> 
        <tbody>
<tr><td>1</td><td>5</td><td>9</td><td>45678979</td><td>2021-01-11 13:22:09</td></tr>
<tr><td>2</td><td>8</td><td>9</td><td>45888979</td><td>2021-01-12 11:22:09</td></tr>
         </tbody>   
</table>
<lable>Таблица ticket</lable>
<table>
    <thead>
    <tr>
<td>order_id</td><td>type_ticket</td><td>barcode_ticket</td><td>price</td>
     </tr>
       </thead> 
        <tbody>
<tr><td>1</td><td>2</td><td>7888878987</td><td>500</td></tr>
<tr><td>1</td><td>1</td><td>7888878944</td><td>1000</td></tr>
<tr><td>2</td><td>4</td><td>7844878944</td><td>300</td></tr>            
         </tbody>   
</table>
<lable>Таблица type_ticket</lable>
<table>
    <thead>
    <tr>
<td>id</td><td>name</td>
     </tr>
       </thead> 
        <tbody>
<tr><td>1</td><td>Взрослый</td></tr>
<tr><td>2</td><td>Детский</td></tr>
<tr><td>3</td><td>Групповой</td></tr>
<tr><td>4</td><td>ЛЬготный</td></tr>            
         </tbody>   
</table>
<lable>Таблица event_ticket_price</lable>
<table>
    <thead>
    <tr>
<td>event_id</td><td>type_ticket</td><td>price</td>
     </tr>
       </thead> 
        <tbody>
<tr><td>9</td><td>1</td><td>1000</td></tr>
<tr><td>9</td><td>2</td><td>500</td></tr>
<tr><td>9</td><td>3</td><td>1500</td></tr>
<tr><td>9</td><td>4</td><td>300</td></tr>            
         </tbody>   
</table>
<br>
Разбиением первоначальной таблицы order на две (таблицу order и ticket), мы решаем сразу несколько проблем:
<br>
- избыточность данных в таблице оrder. Сохранялось количество билетов взрослых, детских, итоговая стоимость. Это лишняя информация, которую можно получить через sql запрос из двух таблиц.
<br>
- невозможность учитывать дополнительные типы билетов. Строго привязка к взрослым и детским билетам
- <br>
- Один баркод на один заказ. Это является некорректным, т.к. часто посетители из одного заказа приходят не одновременно на события. Возникает необходимость проверять их билеты по отдельности. 
<br>
<h1>Задание №3</h1>
---------------------------
<br>
<b><i>addOrder</b></i> - добавляет заказы в таблицу заказов Order
<br>
Function addOrder (integer $event_id, string $event_date, integer $ticket_adult_price, integer $ticket_adult_quantity, integer $ticket_kid_price, integer $ticket_kid_quantity): array
<br>
 - Все входные параметры обязательны.
<br>
 - Возвращает массив. В случае неудачного оформления заказа возращает один из следующих массивов - {error: 'event cancelled'}, {error: 'no tickets'}, {error: 'no seats'}, {error: 'fan removed'}. В случае успеха - {message: 'order successfully aproved'}
 <br>
 ---------------------------
 <br>
 <b><i>createBarcode</b></i> - генерирует уникальный barcode для заказа
 <br>
 function createBarcode(): integer
 <br>
 Вызывается без параметров
 <br>
 - Возвращает уникальный barcode для заказа. Возращаемый тип данные Integer
 <br>
---------------------------
 <br>
<b><i> book </i></b> - проверяет успешность брони заказа.
 <br>
 function book(integer $event_id, string $event_date, integer $ticket_adult_price, integer $ticket_adult_quantity, integer $ticket_kid_price, integer $ticket_kid_quantity, integer $barcode):bool
 <br>
  - Все входные параметры обязательны
 <br>
  - Возращает true в случае успешной брони и false в противном.
