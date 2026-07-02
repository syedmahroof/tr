<?php

namespace App\Notifications;

use App\Mail\DailySummaryMail;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class DailySummaryNotification extends Notification
{
    use Queueable;

    public array $summaryData;

    /**
     * Create a new notification instance.
     */
    public function __construct(array $summaryData)
    {
        $this->summaryData = $summaryData;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['mail', 'database'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable)
    {
        return (new DailySummaryMail($this->summaryData))
            ->to($notifiable->email);
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            'type' => 'daily_summary',
            'title' => 'Daily Summary - '.$this->summaryData['date'],
            'message' => 'New activity: '.$this->summaryData['visitors_count'].' visitors, '.$this->summaryData['vehicles_count'].' vehicles, '.$this->summaryData['deliveries_count'].' deliveries, '.$this->summaryData['appointments_count'].' appointments.',
            'date' => $this->summaryData['date'],
            'data' => $this->summaryData,
            'link' => '/admin/dashboard',
        ];
    }
}
