<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Campaign;
use App\Models\Client;
use Illuminate\Http\Request;
use App\Http\Requests\ClientRequest;

use App\User;

class ClientController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        view()->share('site', (object) [
            'title' =>  __('labels.clients')
        ]);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {        
        
        $this->authorize('client.index');
        $clients = Client::all();        
        $users = User::get();
        $campaigns = Campaign::get();

        return view('admin.client.index', compact('clients', 'users', 'campaigns'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {        
        $this->authorize('client.create');
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ClientRequest $request)
    {        
        $this->authorize('client.create');
        $client = $request->all();
        
        $client['campaign_id'] =  $client['campaign_id'] > 0 ? $client['campaign_id'] : null ;

        $client = Client::create( $client );
        return redirect()->route('clients.index')->with('success', __('messages.client_created'));
    }


    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Client  $client
     * @return \Illuminate\Http\Response
     */
    public function show(Client $client)
    {        
        $this->authorize('client.index');
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Client  $client
     * @return \Illuminate\Http\Response
     */
    public function edit(Client $client)
    {        
        $this->authorize('client.edit');
        $users = User::get();
        $campaigns = Campaign::get();
        return view('admin.client.edit', compact('client', 'users', 'campaigns'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Client  $client
     * @return \Illuminate\Http\Response
     */
    public function update(ClientRequest $request, Client $client)
    {        
        $this->authorize('client.update');
        
        $client->update($request->all());

        return redirect()->route('clients.index')->with('success',__('messages.client_updated'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Client  $client
     * @return \Illuminate\Http\Response
     */
    public function destroy(Client $client)
    {        
        $this->authorize('client.delete');
        $client->delete();
        return redirect()->route('clients.index')->with('success', __('messages.client_deleted'));
    }
}
