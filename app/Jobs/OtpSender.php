<?php

namespace App\Jobs;

use App\Services\WaSender;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;

class OtpSender implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new job instance.
     */
    public function __construct(protected string $number,protected string $msg)
    {
        //
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        send_whatsapp($this->number,'Kode OTP rahasia anda adalah : '.$this->msg);
    }
}
