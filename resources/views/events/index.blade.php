<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('События') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
              @auth
              @if (auth()->user()->role == 'admin')
              <div class="pull-right">
                  <a class="btn btn-success" href="{{ route('events.create') }}"> Добавить новое событие</a>
              </div>
              @endif
              @endauth
    <br>
@auth
  @if ($message = Session::get('success'))
      <div class="alert alert-success">
          <p>{{ $message }}</p>
      </div>
  @endif
@endauth
  <table class="table table-bordered">
      <tr>
          <th>No</th>
          <th>Name</th>
          <th>Deta Event</th>
          <th width="280px">Action</th>
      </tr>
      @foreach ($data as $key => $value)
      <tr>
          <td>{{ ++$i }}</td>
          <td>{{ $value->name }}</td>
          <td>{{ \Str::limit($value->event_date, 100) }}</td>
          <td>
              <form action="{{ route('events.destroy',$value->id) }}" method="POST">
                  <a class="btn btn-info" href="{{ route('events.show',$value->id) }}">Show</a>
                  @auth
                  @if (auth()->user()->role == 'admin')
                  <a class="btn btn-primary" href="{{ route('events.edit',$value->id) }}">Edit</a>
                  @csrf
                  @method('DELETE')
                  <button type="submit" class="btn btn-danger">Delete</button>
                  @endif
                  @endauth
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
