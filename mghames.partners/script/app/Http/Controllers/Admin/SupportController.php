<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Support;
use App\Models\Supportmeta;
use Illuminate\Support\Facades\Session;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SupportController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        abort_if(!Auth()->user()->can('support'), 401);
        $supports = Support::with(['meta'])->latest()->paginate(5);
        return view('admin.support.index', compact('supports'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function getSupportData(Request $request){
        abort_if(!Auth()->user()->can('support'), 401);
        $support = Support::with('user')->with('meta')->where('id', $request->id)->first();
        $data = [];
        $data['user']['title'] = $support->title;
        $data['user']['status'] = $support->status;
        foreach ($support->meta as $k => $meta) {
            // $data[$k]['title'] = $support->title ?? '';
            $data['sub'][$k]['name'] = $meta->type == 0 ? Auth::user()->name : $support->user->name;
            $data['sub'][$k]['date'] = $meta->created_at->diffForHumans();
            $data['sub'][$k]['comment'] = $meta->comment;
            $data['sub'][$k]['type'] = $meta->type;
        }
        return json_encode($data);
    }

    public function supportStatus(Request $request){
        abort_if(!Auth()->user()->can('support'), 401);
        $support = Support::findOrFail($request->id);
        $support->status = $request->status;

        $support->save();
        Session::flash('message','Status changed successfully!');
        // return json_encode(1);
    }


    public function create()
    {

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        abort_if(!Auth()->user()->can('support'), 401);
        $support = Support::with(['meta'])->where('id', $id)->get();
        return view('admin.support.edit' , compact('support','id'));
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

        $support = Support::findOrFail($id);
        $support->status = 1;  
        $support->save();
        
        $supportmeta = new Supportmeta();
        $supportmeta->support_id = $id; 
        $supportmeta->comment = $request->comment;
        $supportmeta->type = 0; //for admin
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
        abort_if(!Auth()->user()->can('support'), 401);
        $support = Support::findOrFail($id);
        $supportmeta = Supportmeta::where('support_id',$id);
        $support->delete();
        $supportmeta->delete();
        return redirect()->back()->with('success', 'Successfully Deleted!');   
    }
}
