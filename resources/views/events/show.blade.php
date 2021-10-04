<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('События') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-3">



                        <div class="pull-right">
                            <a class="btn btn-primary" href="{{ route('events.index') }}"> Назад</a>
                        </div>


                            <div class="row">
                                <div class="col-xs-12 col-sm-12 col-md-12">
                                    <div class="form-group">
                                        <strong>Наименование события:</strong>
                                        {{ $event->name }}

                                    </div>
                                </div>
                                <div class="col-xs-12 col-sm-12 col-md-12">
                                    <div class="form-group">
                                        <strong>Дата события:</strong>
                                        {{ $event->event_date }}
                                    </div>
                                </div>
                              </div>
                                <table class="table">
  <thead class="table-dark">
  <th>Тип билета</th>
  <th>Цена билата</th>
  @auth
  <th>Количество билетов для заказа</th>
@endauth
  </thead>
  <tbody>
    @foreach ($event->event_ticket_price as $ticket)
    <tr>
      <td>{{$ticket->type_ticket->type_ticket}}</td>
      <td>{{$ticket->price_ticket}}</td>
      @auth
     <td><input type="text" name={{$ticket->type_ticket->id}}  id={{$ticket->type_ticket->id}} class="form-control" value="0"></td>
     @endauth
   </tr>
    @endforeach
  </tbody>
</table>
@auth
<button type="button" class="btn btn-success" id="submit">Заказать</button>
@endauth
            </div>
        </div>
    </div>
</x-app-layout>
<script>
document.getElementById("submit").addEventListener('click', function() {
  var event_id = <?php echo json_encode($event->id, JSON_HEX_TAG); ?>;
  var url = <?php echo json_encode(env('Local_URL')."/api/order", JSON_HEX_TAG); ?>;
  var user_id = <?php echo json_encode(auth()->user()->id, JSON_HEX_TAG); ?>;
  let ticket = {};
  var vticket = document.querySelectorAll('input[type="text"]');
  for(let i = 0; i < vticket.length; i++){
    if (vticket[i].value != 0) {
      ticket[vticket[i].id] =  vticket[i].value;
    };
  }
  axios({
method: 'post',
url: url,
data: {
  user_id: user_id,
  event_id: event_id,
  ticket: ticket
}
})
.then(function (response) {

console.log(response.data);
})
})
</script>
