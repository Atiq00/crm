<?php

namespace App\Http\Controllers\CustomerPanel;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\User;
use App\Models\Customer;
use App\Models\Department;
use App\Models\Priority;
use App\Models\Ticket;
use App\Models\TicketReply;

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
        $this->middleware('auth:customer');
    }

    public function index(Request $request, $status = null)
    {


        $tickets = Ticket::where('customer_id',  auth()->guard('customer')->user()->id );

        if($request->has('query'))
            $tickets->where(function($query) use ($request) {
                $query->orWhere('title', 'like', '%'.strip_tags($request->get('query')).'%')
                        ->orWhere('description', 'like', '%'.strip_tags($request->get('query')).'%')
                        ->orWhere('id', 'like', '%'.strip_tags($request->get('query')).'%');
            });

        $tickets = $tickets->latest();

        $ticketStatus = $status ?? 'all';

        if($ticketStatus=='open')
            $tickets->where('status', 'open');
        else if($ticketStatus=='closed')
            $tickets->where('status', 'closed');

        $tickets = $tickets->paginate(10);
        
        $ticketCount = Ticket::where('customer_id',  auth()->guard('customer')->user()->id )->get();
        $totalAll = $ticketCount->count();
        $totalOpen = $ticketCount->where('status', 'open')->count();
        $totalClosed = $ticketCount->where('status', 'closed')->count();

        return view('customer-panel.tickets.index', compact('tickets', 'totalAll', 'totalOpen', 'totalClosed', 'ticketStatus'));
    }

    public function createTicket()
    {
        $departments    =   Department::all();
        $priorities    =   Priority::all();
        return view('customer-panel.tickets.create', compact('departments', 'priorities'));
    }

    public function submitTicket(Request $request)
    {

        $this->validate($request, [
            'title' => [
                'required', 'min:3',
            ],
        ]);

        $data = $request->only(['title', 'description', 'department_id', 'priority_id']);
        $data['customer_id']    =   auth()->guard('customer')->user()->id;

        $data['user_id']    =   null;
        
        if(setting('auto_assign_user')=='yes')
            $data['user_id']    =   Department::find( $data['department_id'] )->assigned_user_id ?? setting('ticket_default_assigned_user_id');
            
        $data['status'] =   'open';
        $data['status_reply'] =   'client_reply';
        $ticket = Ticket::create($data);


        $ticket_reply = new TicketReply;

        $ticket_reply->ticket_id    =   $ticket->id;
        $ticket_reply->message    =   $request->description;
        $ticket_reply->attachments    =   [];
        $ticket_reply->customer_id    =   auth()->guard('customer')->user()->id;
        // $ticket_reply->customer_id    =   0;

        $ticket_reply->save();

        if($request->hasFile('reply_attachments'))
        {

            $file = $request->file('reply_attachments');
            $filenames = [];

            $filename = $file->getClientOriginalName();
            $extension = $file->getClientOriginalExtension();
            $filenames[0] = str_replace('reply_attachments/', '', $file->store('reply_attachments', 'uploads'));

            $ticket_reply->attachments = $filenames ?? [];
            $ticket_reply->update();

        }



        $ticket->update(['updated_at' => now()]);
        
        $ticketData = shortcodes_Ticket($ticket);

        try{
            
            if(setting('EMAIL_USER_TICKET_CREATE_CUSTOMER')=='yes')
                @Mail::to(auth()->user()->email)
                ->send( new MailMailableSend( 'customer_send_ticket_created', $ticketData ) );

            if(setting('EMAIL_USER_TICKET_CREATE_AGENT')=='yes' && setting('auto_assign_user')=='yes')
                @Mail::to( User::find($ticket->user_id)->email )
                ->send( new MailMailableSend( 'agent_send_ticket_auto_assigned', $ticketData ) );
            
        
        }catch(\Exception $e){
            return redirect()->route('customer.tickets_view', $ticket->id);
        }

        return redirect()->route('customer.tickets_view', $ticket->id);


    }

    public function viewTicket($id)
    {

        
        $ticket = Ticket::findOrFail($id);

        return view('customer-panel.tickets.view', compact('ticket'));
    }

    public function replyTicket(Request $request, $ticket)
    {

        $ticket = Ticket::findOrFail($ticket);

        $this->validate($request, [
            'reply_description' => 'required',
        ]);

        $ticket_reply = new TicketReply;

        $ticket_reply->ticket_id    =   $ticket->id;
        $ticket_reply->message    =   $request->reply_description;
        $ticket_reply->attachments    =   [];
        // $ticket_reply->user_id    =   auth()->user()->id;
        $ticket_reply->customer_id    =   auth()->guard('customer')->user()->id;
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

        $ticket->updated_at = now();
        $ticket->status_reply = 'client_reply';
        $ticket->update();

        
        $ticketData = shortcodes_Ticket($ticket);
        if(setting('EMAIL_TICKET_CUSTOMER_REPLIED')=='yes')
            @Mail::to(User::find($ticket->user_id)->email)
                ->send( new MailMailableSend( 'ticket_replied_customer', $ticketData ) );
        

        return redirect()->route('customer.tickets_view', $ticket->id)->with('success', __('messages.reply_sent'));
    }

    public function updateTicketStatus($id, $status)
    {
        $ticket = Ticket::where('customer_id', auth()->guard('customer')->user()->id)->findOrFail($id);

        if($ticket->status!='open' && $status=='reopen' && setting('USER_REOPEN_ISSUE')=='yes')
            $ticket->status = 'open';

        if($ticket->status=='open' && $status=='closed')
            $ticket->status = 'closed';

        $ticket->update();

        return redirect()->route('customer.tickets_view', $id);
    }

}
