<?php

namespace App\Http\Controllers\Merchant;

use App\Http\Controllers\Controller;
use App\Jobs\SendEmailJob;
use App\Mail\SupportMail;
use App\Models\Option;
use App\Models\Support;
use App\Models\Supportmeta;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class SupportController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $supports = Support::with('meta')->where('user_id',Auth::id())->latest()->paginate(15);
        return view('merchant.support.index', compact('supports'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('merchant.support.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        
        $request->validate([
            'title'       => 'required|max:100',
            'comment' => 'required|max:250',
        ]);

        $sender = User::where("id", Auth::id())->pluck('email')->first();
        $reciever = User::where('role_id', 1)->pluck('email')->first();
        $support = new Support();
        $support->title = $request->title;
        $support->ticket_no = $this->generateAccNo();
        $support->user_id = Auth::id();
        $support->save();

        $supportmeta = new Supportmeta();
        $supportmeta->support_id = $support->id;
        $supportmeta->comment = $request->comment;
        $supportmeta->save();

        $data = [
            'type' => 'support',
            'email' => $reciever,
            'title' => $support->title,
            'ticket' => $support->ticket_no,
            'message' => $sender . " send a support request of Ticket No:",
            "link" => route('admin.support.index')
        ];
        if (env('QUEUE_MAIL') == 'on') {
            dispatch(new SendEmailJob($data));
        }else{
            Mail::to($reciever)->send(new SupportMail($data)); 
        }

        return response()->json('Message send successfully!'); 
    }



    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $support = Support::with('user')->with('meta')->where('user_id',Auth::id())->findorFail($id);
        return view('merchant.support.view', compact('support'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'comment' => 'required',
        ]);

        $count = Support::where('id', $id)->where('user_id', Auth::id())->count();

        if ($count == 0) {
            return response()->json('Not authorized!'); 
        }
     
        
        $supportmeta = new Supportmeta();
        $supportmeta->support_id = $id; 
        $supportmeta->comment = $request->comment;
        $supportmeta->type = 1; //for admin
        $supportmeta->save();

        return response()->json('Reply send successfully!'); 
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    
    public function generateAccNo(){
        $rend = rand(10000000, 99999999). rand(10000000, 99999999);
        $check = Support::where('ticket_no', $rend)->first();

        if($check == true){
            $rend = $this->generateAccNo();
        }
        return $rend;
    }

}
