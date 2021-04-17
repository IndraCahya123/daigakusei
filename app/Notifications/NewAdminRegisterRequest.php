<?php

namespace App\Notifications;

use App\Http\Requests\AdminUniversityRegisterRequest;
use App\Models\AdminUniversityRegisterRequest as ModelsAdminUniversityRegisterRequest;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\Hash;

class NewAdminRegisterRequest extends Notification implements ShouldQueue
{
    use Queueable;

    public $newRequest;
    public $requestId;


    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(AdminUniversityRegisterRequest $request, int $id)
    {
        $this->newRequest = $request;
        $this->requestId = $id;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['database'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    // public function toMail($notifiable)
    // {
    //     return (new MailMessage)
    //                 ->line('You Have New Admin University Request.')
    //                 ->action('LOGIN', url('http://127.0.0.1:8000/login'))
    //                 ->line('Thank you for using our application!');
    // }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            'request_id' => $this->requestId,
            'admin_name' => $this->newRequest->admin_name,
            'admin_email' => $this->newRequest->admin_email,
            'university' => $this->newRequest->university,
            'phone' => $this->newRequest->phone,
            'password' => Hash::make($this->newRequest->password),
        ];
    }
}
