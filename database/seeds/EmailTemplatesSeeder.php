<?php

use Illuminate\Database\Seeder;

class EmailTemplatesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('email_templates')->insert([
            [
                'code' => 'customer_send_ticket_created',
                'title' => 'Send email to customer, when Ticket is Created!',
                'subject' => 'Your Ticket has been received',
                'body' => 'Our Support Team will reply in 1-2 business working days. <br> Title : {{ticket_title}} <br> Thanks for reaching out us',
                'created_at' => now(),
                'updated_at' => now()
            ], [
                'code' => 'forget_password',
                'title' => 'when customer/admin or any user forgets password',
                'subject' => 'Password Reset Email',
                'body' => 'Click the below link to reset your account password. <a href="{{reset_link}}">Reset Password</a>',
                'created_at' => now(),
                'updated_at' => now()
            ], [
                'code' => 'agent_send_ticket_auto_assigned',
                'title' => 'When a ticket is created by customer/admin and auto assigned by system',
                'subject' => 'New Ticket has been auto assigned to you by system',
                'body' => 'Ticket has been auto assigned to you by system. <br> <a href="{{ticket_url}}">View Ticket</a>',
                'created_at' => now(),
                'updated_at' => now()
            ], [
                'code' => 'ticket_replied_agent',
                'title' => 'Send an Email to Customer, when agent replies to a ticket',
                'subject' => 'Your Ticket has been replied',
                'body' => '<p>Hi, Your ticket has been replied by our agent. <a href="{{ticket_customer_url}}">Click Here</a> to view Ticket.</p>',
                'created_at' => now(),
                'updated_at' => now()
            ], [
                'code' => 'ticket_replied_customer',
                'title' => 'Sends an Email to Agent, when customer replies to ticket',
                'subject' => 'Customer reply to a Ticket',
                'body' => '<p>Hi, Customer has replied to a ticket. <a href="{{ticket_agent_url}}">Click Here</a> to view Ticket.</p>',
                'created_at' => now(),
                'updated_at' => now()
            ]
        ]);
    }
}
