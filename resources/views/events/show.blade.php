<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('События') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">



                        <div class="pull-right">
                            <a class="btn btn-primary" href="{{ route('events.index') }}"> Back</a>
                        </div>


                            <div class="row">
                                <div class="col-xs-12 col-sm-12 col-md-12">
                                    <div class="form-group">
                                        <strong>Title:</strong>
                                        {{ $event->name }}
                                    </div>
                                </div>
                                <div class="col-xs-12 col-sm-12 col-md-12">
                                    <div class="form-group">
                                        <strong>Event date:</strong>
                                        {{ $event->event_date }}
                                    </div>
                                </div>
@foreach ($event->event_ticket_price as $ticket)
<div class="col-xs-12 col-sm-12 col-md-12">
    <div class="form-group">
 {{$ticket->price_ticket}}
 {{$ticket->type_ticket->type_ticket}}
</div>
</div>
@endforeach
                            </div>


            </div>
        </div>
    </div>
</x-app-layout>
