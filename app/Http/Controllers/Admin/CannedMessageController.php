<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\User;
use App\Models\CannedMessage;

class CannedMessageController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        view()->share('site', (object) [
            'title' =>  __('labels.canned_messages')
        ]);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $this->authorize('ticket_canned_messages.index');

        $canned_messages  =   CannedMessage::where('public', true)->orWhere('user_id', auth()->user()->id)->get();
        $users = User::get();
        return view('admin.canned_messages.index', compact('canned_messages', 'users'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $this->authorize('ticket_canned_messages.create');
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->authorize('ticket_canned_messages.create');
        $this->validate($request, [
            'title'  =>  'required',
            'message'  =>  'required'
        ]);

        $data = $request->only([ 'title', 'message' ]);
        $data['user_id'] =   auth()->user()->id;
        $data['public'] =   $request->get('public')=='1' ? true : false;

        CannedMessage::create( $data );
        return redirect()->route('canned_messages.index')->with('success', __('messages.canned_messages_created'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $this->authorize('ticket_canned_messages.index');
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
        $this->authorize('ticket_canned_messages.edit');
        $canned_message = CannedMessage::findOrFail($id);
        $users = User::get();
        return view('admin.canned_messages.edit', compact('canned_message', 'users'));
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
        $this->authorize('ticket_canned_messages.edit');
        $this->validate($request, [
            'title'  =>  'required',
            'message'  =>  'required'
        ]);

        $canned_message = CannedMessage::findOrFail($id);
        $data =   $request->only(['title', 'message']);
        $data['public'] =   $request->get('public')=='1' ? true : false;
        $canned_message->update($data);

        return redirect()->route('canned_messages.index')->with('success', __('messages.canned_messages_updated'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $this->authorize('ticket_canned_messages.delete');
        $canned_message = CannedMessage::findOrFail($id)->delete();
        return redirect()->route('canned_messages.index')->with('success',  __('messages.canned_messages_deleted'));
    }

    public function ajaxDetailData(Request $request)
    {
        $this->authorize('ticket_canned_messages.index');
        $id = $request->get('id');
        return CannedMessage::findOrFail($id);
    }
}
