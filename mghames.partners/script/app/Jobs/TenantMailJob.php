<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;
use App\Mail\Orderstatusmail;
class TenantMailJob implements ShouldQueue
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
        $email = $this->details['to'] ?? $this->details['from'];
        $type = $this->details['type'];

       

        switch ($type) {
            
            case 'tenant_order_notification';
                            
                Mail::to($email)->send(new Orderstatusmail($this->details)); 
            case 'order_recived';
                Mail::to($email)->send(new Orderstatusmail($this->details)); 
            default:
                // $data = new OrderMail($this->details);
                // Mail::to($email)->send($data);
                break;
        }
    }
}
