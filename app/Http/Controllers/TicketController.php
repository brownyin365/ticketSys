<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Ticket;

class TicketController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $tickets = Ticket::where('user_id', auth()->user()->id)->get();
        
        return view('user.index',compact('tickets'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('user.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {   
        $this->validate($request, [
            'description' => 'required|string|text',
            'title'   => 'required|title|max:80',
            
        ]);

        //dd($request->all());
        $ticket = new Ticket;

        $ticket->description = $request->input('description');
        $ticket->title = $request->input('title');
        

        $ticket->save();


        return redirect('/home')->with('success', 'New support ticket has been created! Wait sometime to get resolved');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $ticket = Ticket::where('user_id', auth()->user()->id)
                        ->where('id', $id)
                        ->first();

        return view('user.edit', compact('ticket', 'id'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {   
        // Validate title and description and update
        $this->validate($request, [
            'description' => 'required|string|text',
            'title'   => 'required|title|max:80',
            
        ]);

        //dd($request->all());
        $ticket = new Ticket;

        // Find ticket by ID /auth user and update 
        $ticket = $this->find($ticket['id']);
        $ticket->user_id = auth()->user()->id;
        $ticket->description = $request->input('description');
        $ticket->title = $request->input('title');
        

        $ticket->save();

        //return home after update the ticket
        return redirect('/home')->with('success', 'New support ticket has been created! Wait sometime to get resolved');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {   
        //Find ticket by ID and delete
        $ticket = Ticket::find($id);
        $ticket->delete();

        return redirect('/home')->with('success', 'Ticket has been deleted!!');
    }
}
