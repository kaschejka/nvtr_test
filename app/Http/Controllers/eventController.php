<?php

namespace App\Http\Controllers;

use App\Models\event;
use App\Models\event_ticket;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class eventController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
      $data = event::latest()->paginate(5);

      return view('events\index',compact('data'))
          ->with('i', (request()->input('page', 1) - 1) * 5);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('events\create');
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
          'name' => 'required',
          'event_date' => 'required',
      ]);

      event::create($request->all());

      return redirect()->route('events.index')
                      ->with('success','Event created successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\event  $event
     * @return \Illuminate\Http\Response
     */
    public function show(event $event)
    {
//       $po = event_ticket::with('type_ticket')->get();
// echo dd($po);
       return view('events\show',compact('event'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\event  $event
     * @return \Illuminate\Http\Response
     */
    public function edit(event $event)
    {
        return view('events\edit',compact('event'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\event  $event
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, event $event)
    {
      $request->validate([
        'name' => 'required',
        'event_date' => 'required',
    ]);

    $event->update($request->all());

    return redirect()->route('events.index')
                    ->with('success','Event updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\event  $event
     * @return \Illuminate\Http\Response
     */
    public function destroy(event $event)
    {
      $event->delete();

        return redirect()->route('events.index')
                        ->with('success','Event deleted successfully');
    }
}
