<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Mail\Orderstatusmail;
use Mail;
class Sellermailjob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
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
    public function handle()
    {
        $to  = $this->details['to'];
        $from = $this->details['from'];
        $type = $this->details['type'];

      

        switch ($type) {
            case 'sent_invoice_to_customer':
                // $data = new Orderstatusmail($this->details);
                // Mail::to($to)->send($data);
                break;
                
            default:
                // $data = new OrderMail($this->details);
                // Mail::to($email)->send($data);
                break;
        }
    }
}
