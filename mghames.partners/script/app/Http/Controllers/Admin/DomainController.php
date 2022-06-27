<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;
use App\Models\Domain;
class DomainController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        abort_if(!Auth()->user()->can('domain.list'),401);
        
        $active=Domain::where('status',1)->count();
        $pending=Domain::where('status',2)->count();
        $inactive=Domain::where('status',0)->count();
        $all=Domain::count();

        $status=$request->status === 0 ? 0 : $request->status; 
        $domains=Domain::latest();
        if ($status != '') {
          $domains=$domains->where('status',$status);  
        }
        if ($request->type != null) {
            $domains=$domains->where($request->type,$request->src);
        }


        $domains=$domains->paginate(30);
        return view('admin.domain.domain_list',compact('domains','active','pending','inactive','all','status','request'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        abort_if(!Auth()->user()->can('domain.create'),401);

        return view('admin.domain.create_domain');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
       if ($request->subdomain) {
           $validatedData = $request->validate([
            'subdomain' => 'required|string|max:50',
           ]);

           $domain=strtolower($request->subdomain).'.'.env('APP_PROTOCOLESS_URL');
           $check= Domain::where('domain',$domain)->first();
            if (!empty($check)) {
                    $error['errors']['domain']='Oops domain name already taken....!!';
                    return response()->json($error,422);
            }

            $subdomain= new Domain;
            $subdomain->domain= $domain;
            $subdomain->tenant_id= $request->tenant_id;
            $subdomain->status=env('AUTO_SUBDOMAIN_APPROVE') == true ? 1 : 2;
            $subdomain->type=2;
            $subdomain->save();

            return response()->json('Domain Created Successfully...!!');
       }

        if ($request->domain) {
            $validatedData = $request->validate([
            'domain' => 'required|string|max:50|',
            ]);
           
            $urlParts = parse_url($request->domain);

            $filter_url = preg_replace('/^www\./', '', $urlParts['host'] ?? $urlParts['path']);

            $check=Domain::where('domain',$filter_url)->first();

            if (!empty($check)) {
                $error['errors']['domain']='Oops domain name already taken....!!';
                return response()->json($error,422);
            }

            $domain= new Domain;
            $domain->domain= $filter_url;
            $domain->tenant_id= $request->tenant_id;
            $domain->status=2;
            $domain->type=3;
            $domain->save();

            return response()->json('Custom Domain Created Successfully...!!');
        }      
       ;
         
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
        abort_if(!Auth()->user()->can('domain.edit'),401);
        $info= Domain::findorFail($id);
        return view('admin.domain.edit_domain',compact('info'));
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
      
        $check= Domain::where('domain',$request->domain)->where('id','!=',$id)->first();
        if (!empty($check)) {
            $error['errors']['domain']='Oops domain name already taken....!!';
            return response()->json($error,422);
        }

         $domain= Domain::findorFail($id);
         $domain->domain= $request->domain;
         $domain->status=$request->status;
         $domain->tenant_id=$request->tenant_id;
         $domain->save();

         return response()->json('Domain Updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
         if ($request->method == 'delete') {
            Domain::whereIn('id',$request->ids)->delete();
         }

         return response()->json('Success');
    }
}
