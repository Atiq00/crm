<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Ticket;
use App\Models\TicketReply;
use App\Models\Department;
use App\Models\Priority;
use App\User;
use App\Models\Customer;
use App\Models\CannedMessage;
use Illuminate\Http\Request;
use App\Http\Requests\TicketRequest;

use Illuminate\Support\Facades\Mail;
use App\Mail\MailMailableSend;

class TicketController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        view()->share('site', (object) [
            'title' =>  __('labels.tickets')
        ]);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {

        $this->authorize('ticket.index');

        $tickets  =   Ticket::where('id', '>', 0);

        if( auth()->user()->can('ticket_assigned_only') && !auth()->user()->hasRole('Super Admin') ){
            $tickets->where('user_id', auth()->user()->id );
        }

        if(!$request->has('sort'))
            $tickets->orderBy( \DB::raw('created_at'), 'desc' );

        if($request->get('sort') =='latest')
            $tickets->orderBy( \DB::raw('created_at'), 'desc' );

        if($request->get('sort') =='oldest')
            $tickets->orderBy( \DB::raw('created_at'), 'asc' );

        if($request->get('status') =='unassigned')
            $tickets->where( 'user_id', null )->orWhere( 'user_id', '<=', 0 );

        if($request->get('status') =='open')
            $tickets->where( 'status', 'open' );

        if($request->get('status') =='closed')
            $tickets->where( 'status', 'closed' );

        $tickets = $tickets->get();
        return view('admin.ticket.index', compact('tickets'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

        $this->authorize('ticket.create');

        $priorities  =   Priority::all();
        $departments  =   Department::all();
        $customers  =   Customer::all();
        return view('admin.ticket.create', compact('priorities', 'departments', 'customers'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(TicketRequest $request)
    {

        $this->authorize('ticket.create');

        $data = $request->except(['send_email_customer']);
        $data['status'] =   'open';
        $data['status_reply'] =   'agent_reply';
        
        $data['user_id']    =   0;
        if(setting('auto_assign_user')=='yes')
            $data['user_id'] =   Department::find( $data['department_id'] )->assigned_user_id ?? setting('ticket_default_assigned_user_id');

        $ticket = Ticket::create($data);
        
        $ticketData = [
            'ticket_title' => $ticket->title,
            'ticket_description' => $ticket->description,
            'ticket_customer_url' => route('customer.tickets_view', $ticket->id),
            'ticket_agent_url' => route('tickets.show', $ticket->id),
        ];

        try{

            if(setting('EMAIL_USER_TICKET_CREATE_CUSTOMER')=='yes' && $request->get('send_email_customer')=="yes") {
                @Mail::to( Customer::find($ticket->customer_id)->email )
                ->send( new MailMailableSend( 'customer_send_ticket_created', $ticketData ) );
            }

            if(setting('EMAIL_USER_TICKET_CREATE_AGENT')=='yes' && setting('auto_assign_user')=='yes') {
                @Mail::to( User::find($ticket->user_id)->email )
                ->send( new MailMailableSend( 'agent_send_ticket_auto_assigned', $ticketData ) );
            }
        
        }catch(\Exception $e){
            // dd($e);
            return redirect()->route('tickets.index')->with('error', __('messages.ticket_created_no_mail'));
        }
        

        return redirect()->route('tickets.index')->with('success', __('messages.ticket_created'));

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Ticket  $ticket
     * @return \Illuminate\Http\Response
     */
    public function show(Ticket $ticket)
    {

        if( (auth()->user()->can('ticket_assigned_only') && $ticket->user_id!=auth()->user()->id) && !auth()->user()->hasRole('Super Admin') ){
            return abort(403);
        }

        $this->authorize('ticket.index');

        $canned_messages = CannedMessage::where('public', true)->orWhere('user_id', auth()->user()->id)->get();
        return view('admin.ticket.show', compact('ticket', 'canned_messages'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Ticket  $ticket
     * @return \Illuminate\Http\Response
     */
    public function edit(Ticket $ticket)
    {

        if( (auth()->user()->can('ticket_assigned_only') && $ticket->user_id!=auth()->user()->id) && !auth()->user()->hasRole('Super Admin') ){
            return abort(403);
        }

        $this->authorize('ticket.edit');

        $priorities  =   Priority::all();
        $departments  =   Department::all();
        $customers  =   Customer::all();
        return view('admin.ticket.edit', compact('ticket', 'priorities', 'departments', 'customers'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Ticket  $ticket
     * @return \Illuminate\Http\Response
     */
    public function update(TicketRequest $request, Ticket $ticket)
    {

        if( (auth()->user()->can('ticket_assigned_only') && $ticket->user_id!=auth()->user()->id) && !auth()->user()->hasRole('Super Admin') ){
            return abort(403);
        }

        $this->authorize('ticket.edit');

        $ticket->update($request->all());
        return redirect()->route('tickets.index')->with('success',  __('messages.ticket_updated'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Ticket  $ticket
     * @return \Illuminate\Http\Response
     */
    public function destroy(Ticket $ticket)
    {        

        if( (auth()->user()->can('ticket_assigned_only') && $ticket->user_id!=auth()->user()->id) && !auth()->user()->hasRole('Super Admin') ){
            return abort(403);
        }

        $this->authorize('ticket.delete');


        foreach ($ticket->replies as $reply) {
            $reply->delete();
        }

        $ticket->delete();
        return redirect()->route('tickets.index')->with('success', __('messages.ticket_deleted'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Ticket  $ticket
     * @return \Illuminate\Http\Response
     */
    public function destroyMultiple(Request $request)
    {

        // if( (auth()->user()->can('ticket_assigned_only') && $ticket->user_id!=auth()->user()->id) && !auth()->user()->hasRole('Super Admin') ){
        //     return abort(403);
        // }

        $this->authorize('ticket.delete');

        $ticket_ids = explode(',', $request->get('ticket_ids'));

        $tickets = Ticket::whereIn('id',  $ticket_ids );

        foreach ($tickets->get() as $ticket) {
            
            if( (auth()->user()->can('ticket_assigned_only') && $ticket->user_id!=auth()->user()->id) && !auth()->user()->hasRole('Super Admin') ){
                continue;
            }

            foreach ($ticket->replies as $reply) {
                $reply->delete();
            }


        }

        $tickets->delete();

        return redirect()->route('tickets.index')->with('success', __('messages.ticket_deleted'));
    }

    /**
     * Create a Reply for ticket
     *
     * @param  \App\Models\Ticket  $ticket
     * @return \Illuminate\Http\Response
     */
    public function addReply(Ticket $ticket, Request $request)
    {

        if( (auth()->user()->can('ticket_assigned_only') && $ticket->user_id!=auth()->user()->id) && !auth()->user()->hasRole('Super Admin') ){
            return abort(403);
        }

        $this->authorize('ticket.reply_ticket');

        $this->validate($request, [
            'reply_description' => 'required',
        ]);

        $ticket_reply = new TicketReply;

        $ticket_reply->ticket_id    =   $ticket->id;
        $ticket_reply->message    =   $request->reply_description;
        $ticket_reply->attachments    =   [];
        $ticket_reply->user_id    =   auth()->user()->id;
        // $ticket_reply->customer_id    =   0;
        $ticket_reply->save();

        if($request->hasFile('reply_attachments'))
        {

            $allowedfileExtension=['pdf','jpg','png','docx'];
            $files = $request->file('reply_attachments');
            $filenames = [];
            foreach($files as $key=> $file){
                $filename = $file->getClientOriginalName();
                $extension = $file->getClientOriginalExtension();
                $filenames[$key] = str_replace('reply_attachments/', '', $file->store('reply_attachments', 'uploads'));
            }

            $ticket_reply->attachments = $filenames ?? [];
            $ticket_reply->update();

        }
        


        $ticket->update(['updated_at' => now(), 'status' => $request->update_status, 'status_reply' => 'agent_reply']);

        
        $ticketData = shortcodes_Ticket($ticket);
        if(setting('EMAIL_TICKET_AGENT_REPLIED')=='yes')
            @Mail::to($ticket->customer->email)
                ->send( new MailMailableSend( 'ticket_replied_agent', $ticketData ) );

        return redirect()->route('tickets.show', $ticket->id)->with('success', __('messages.reply_sent'));
    }

    /**
     * Closes a Ticket
     *
     * @param  \App\Models\Ticket  $ticket
     * @return \Illuminate\Http\Response
     */
    public function closeTicket(Ticket $ticket, Request $request)
    {

        if( (auth()->user()->can('ticket_assigned_only') && $ticket->user_id!=auth()->user()->id) && !auth()->user()->hasRole('Super Admin') ){
            return abort(403);
        }

        $this->authorize('ticket.reply_ticket');

        $ticket->update(['updated_at' => now(), 'status' => 'closed']);

        return redirect()->back()->with('success', __('messages.ticket_closed'));
    }

    /**
     * ReOpen the ticket
     *
     * @param  \App\Models\Ticket  $ticket
     * @return \Illuminate\Http\Response
     */
    public function reOpenTicket(Ticket $ticket, Request $request)
    {

        if( (auth()->user()->can('ticket_assigned_only') && $ticket->user_id!=auth()->user()->id) && !auth()->user()->hasRole('Super Admin') ){
            return abort(403);
        }

        $this->authorize('ticket.reply_ticket');

        $ticket->update(['updated_at' => now(), 'status' => 'open']);

        return redirect()->back()->with('success', __('messages.ticket_reopened'));
    }

    /**
     * Assign the ticket to particular user
     *
     * @param  \App\Models\Ticket  $ticket
     * @return \Illuminate\Http\Response
     */
    public function assignTicket(Request $request)
    {

        $this->authorize('ticket.edit');

        $this->validate($request, [
            'ticket_ids' => 'required',
            'user' => 'required'
        ]);

        $ticket_ids = explode(',', $request->get('ticket_ids'));

        $tickets = Ticket::whereIn('id',  $ticket_ids );

        if( auth()->user()->can('ticket_assigned_only') && !auth()->user()->hasRole('Super Admin') ){
            $tickets->where('user_id', auth()->user()->id);
        }

        $tickets->update(['user_id' => $request->user > 0 ? $request->user : null ]);

        return redirect()->back()->with('success', __('messages.ticket_assigned'));

    }
}
