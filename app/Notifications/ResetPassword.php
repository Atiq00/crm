<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class ResetPassword extends Notification
{
    use Queueable;

    public $token, $type;

    public function __construct($token, $type = 'customer')
    {
        $this->token = $token;
        $this->type = $type;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {

        $template = (new \App\Models\EmailTemplate())->where('code', 'forget_password')->first();
        
        $body = $template->body;

        $data = [
            'reset_link'    =>  $this->type=='customer' ? route('customer.password.reset', $this->token) : route('password.reset', $this->token)
        ];

        foreach($data as $key => $value){
            $body = str_replace('{{'.$key.'}}' , $data[$key] , $body);
            $body = str_replace('{{ '.$key.' }}' , $data[$key] , $body);
        }

        return (new MailMessage)
            ->subject( $template->subject )
            ->view('admin.emails.template', [ 'emailBody' => $body ]);
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            //
        ];
    }
}
