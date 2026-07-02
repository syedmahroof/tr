<?php

namespace App\Console\Commands;

use App\Mail\DailySummaryMail;
use App\Models\Admin;
use App\Models\Appointment;
use App\Models\Delivery;
use App\Models\Vehicle;
use App\Models\Visitor;
use Carbon\Carbon;
use Illuminate\Console\Attributes\Description;
use Illuminate\Console\Attributes\Signature;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;

#[Signature('app:send-daily-summary')]
#[Description('Sends a daily summary of visitors, vehicles, deliveries, and appointments to admins.')]
class SendDailySummary extends Command
{
    /**
     * Execute the console command.
     */
    public function handle()
    {
        $yesterday = Carbon::yesterday();

        $visitorsCount = Visitor::whereDate('created_at', $yesterday)->count();
        $vehiclesCount = Vehicle::whereDate('created_at', $yesterday)->count();
        $deliveriesCount = Delivery::whereDate('created_at', $yesterday)->count();
        $appointmentsCount = Appointment::whereDate('date_time', $yesterday)->count();

        $data = [
            'date' => $yesterday->format('F j, Y'),
            'visitors_count' => $visitorsCount,
            'vehicles_count' => $vehiclesCount,
            'deliveries_count' => $deliveriesCount,
            'appointments_count' => $appointmentsCount,
        ];

        $admins = Admin::all();

        if ($admins->isEmpty()) {
            $this->info('No admins found. Summary email was not sent.');

            return;
        }

        foreach ($admins as $admin) {
            $admin->notify(new \App\Notifications\DailySummaryNotification($data));
        }

        $this->info('Daily summary notification sent successfully to all admins.');
    }
}
