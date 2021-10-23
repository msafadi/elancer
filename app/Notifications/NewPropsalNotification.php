<?php

namespace App\Notifications;

use App\Models\Proposal;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class NewPropsalNotification extends Notification
{
    use Queueable;

    protected $proposal;

    protected $freelancer;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(Proposal $proposal, User $freelancer)
    {
        $this->proposal = $proposal;
        $this->freelancer = $freelancer;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        $via = ['database'];
        if ($notifiable->notify_mail) {
            $via[] = 'mail';
        }
        if ($notifiable->notify_sms) {
            $via[] = 'nexmo';
        }
        
        return $via;
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        return (new MailMessage)
                    ->line('The introduction to the notification.')
                    ->action('Notification Action', url('/'))
                    ->line('Thank you for using our application!');
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        $body = sprintf(
            '%s applied for a job %s',
            $this->freelancer->name,
            $this->proposal->project->title,
        );

        return [
            'title' => 'New Proposal',
            'body' => $body,
            'icon' => 'icon-material-outline-group',
            'url' => route('client.projects.show', $this->proposal->project_id),
        ];
    }
}
