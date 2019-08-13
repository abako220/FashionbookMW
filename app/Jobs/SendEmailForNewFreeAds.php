<?php

namespace App\Jobs;

use App\Jobs\Job;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Contracts\Mail\Mailer;

class SendEmailForNewFreeAds extends Job implements ShouldQueue
{
    use InteractsWithQueue, SerializesModels;
    protected $details;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($details)
    {
        $this->details = $details;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle(Mailer $mailer)
    {
        $mailer->send('emails.sendEmailForNewFreeAds', ['data'=>$this->details['email']], function ($message) {

            $message->from('abako220@gmail.com', 'FashionBook');

            $message->to('abako220@gmail.com');
            

        });
    }
}
