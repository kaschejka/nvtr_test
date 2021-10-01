<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Типы билетов') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
              <div class="pull-right">
                  <a class="btn btn-success" href="{{ route('type_tickets.create') }}"> Добавить новое событие</a>
              </div>
    <br>

  @if ($message = Session::get('success'))
      <div class="alert alert-success">
          <p>{{ $message }}</p>
      </div>
  @endif

  <table class="table table-bordered">
      <tr>
          <th>No</th>
          <th>Name</th>
          <th width="280px">Action</th>
      </tr>
      @foreach ($data as $key => $value)
      <tr>
          <td>{{ ++$i }}</td>
          <td>{{ $value->type_ticket }}</td>
          <td>
              <form action="{{ route('type_tickets.destroy',$value->id) }}" method="POST">
                  <a class="btn btn-primary" href="{{ route('type_tickets.edit',$value->id) }}">Edit</a>
                  @csrf
                  @method('DELETE')
                  <button type="submit" class="btn btn-danger">Delete</button>
              </form>
          </td>
      </tr>
      @endforeach
  </table>
  {!! $data->links() !!}
            </div>
        </div>
    </div>
</x-app-layout>
