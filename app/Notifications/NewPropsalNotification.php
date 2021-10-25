<?php

namespace App\Notifications;

use App\Models\Proposal;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\AnonymousNotifiable;
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
        $via = ['database', 'mail'];

        if (!$notifiable instanceof AnonymousNotifiable) {

            if ($notifiable->notify_mail) {
                $via[] = 'mail';
            }
            if ($notifiable->notify_sms) {
                $via[] = 'nexmo';
            }
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
        $body = sprintf(
            '%s applied for a job %s',
            $this->freelancer->name,
            $this->proposal->project->title,
        );

        $message = new MailMessage;
        $message->subject('New Proposal')
                ->from('notifications@localhost', 'E-Lancer Notifications')
                ->greeting('Hello ' . ($notifiable->name ?? ''))
                ->line($body)
                ->action('View to Proposal', route('projects.show', $this->proposal->project_id))
                ->line('Thank you for using our application!');
                // ->view('mails.proposal', [
                //     'proposal' => $this->proposal,
                //     'notifiable' => $notifiable,
                //     'freelancer' => $this->freelancer
                // ]);

        return $message;
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toDatabase($notifiable)
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
            'url' => route('projects.show', $this->proposal->project_id),
        ];
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
    }
}
