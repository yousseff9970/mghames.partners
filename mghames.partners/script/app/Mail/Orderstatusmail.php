<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class Orderstatusmail extends Mailable
{
    use Queueable, SerializesModels;
    public $data;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($data)
    {
        $this->data = $data;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $data=$this->data;

        if ($this->data['type'] == 'tenant_order_notification') {
         $currency=$this->data['currency_info'];
         
         $ordermeta=json_decode($data['data']->ordermeta->value ?? '');
         $invoice_info=$this->data['invoice_data'];

         return $this->from($data['from'])
         ->subject($invoice_info->invoice_subject ?? 'Order Mail')
         ->view('mail.seller.customerorder')->with(['order'=>$data['data'],'currency'=>$currency,'ordermeta'=>$ordermeta,'invoice_info'=>$invoice_info]);
        }
        elseif ($this->data['type'] == 'order_recived'){
            \Config::set('app.name', ucfirst($data['data']['tenantid']));
            return $this->markdown('mail.orderrecived')->from($data['from'])->subject('['.ucfirst($data['data']['tenantid']).'] You have received a new order ('.$data['data']['orderno'].')')->with('data', $data);
        }
        
       
    }
}
