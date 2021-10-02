<h1>Задание №2</h1>
<img src="https://user-images.githubusercontent.com/74649362/135726654-a7f052f9-d50c-4466-a170-0d05d82bcf7d.png" >
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
