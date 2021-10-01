<?php

namespace App\Http\Controllers;

use App\Models\type_ticket;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class type_ticketsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
      $data = type_ticket::latest()->paginate(5);

      return view('type_tickets\index',compact('data'))
          ->with('i', (request()->input('page', 1) - 1) * 5);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('type_tickets\create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
      $request->validate([
          'type_ticket' => 'required',
      ]);

      type_ticket::create($request->all());

      return redirect()->route('type_tickets.index')
                      ->with('success','Event created successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\type_ticket  $type_ticket
     * @return \Illuminate\Http\Response
     */
    public function show(type_ticket $type_ticket)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\type_ticket  $type_ticket
     * @return \Illuminate\Http\Response
     */
    public function edit(type_ticket $type_ticket)
    {
        return view('type_tickets\edit',compact('type_ticket'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\type_ticket  $type_ticket
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, type_ticket $type_ticket)
    {
      $request->validate([
        'type_ticket' => 'required',
    ]);

    $type_ticket->update($request->all());

    return redirect()->route('type_tickets.index')
                    ->with('success','Event updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\type_ticket  $type_ticket
     * @return \Illuminate\Http\Response
     */
    public function destroy(type_ticket $type_ticket)
    {
      $type_ticket->delete();

        return redirect()->route('type_tickets.index')
                        ->with('success','Тип билета успешно удален!');
    }
}
