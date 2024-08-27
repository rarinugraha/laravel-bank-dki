<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class CustomerApprovedNotification extends Notification implements ShouldQueue
{
    use Queueable;

    protected $customer;
    protected $createdBy;

    public function __construct($customer, $createdBy)
    {
        $this->customer = $customer;
        $this->createdBy = $createdBy;
    }

    public function via($notifiable)
    {
        return ['mail'];
    }

    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->subject('Pendaftaran Nasabah Disetujui')
            ->greeting('Halo ' . $this->createdBy->name . ',')
            ->line('Pendaftaran nasabah atas nama ' . $this->customer->name . ' telah disetujui.');
    }
}
