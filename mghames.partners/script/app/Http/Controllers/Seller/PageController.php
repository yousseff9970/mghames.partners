<?php

namespace App\Http\Controllers\Seller;

use App\Http\Controllers\Controller;
use App\Models\Term;
use App\Models\Termmeta;
use Illuminate\Http\Request;
use Illuminate\Support\str;
use DB;
use Auth;
class PageController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        abort_if(!getpermission('website_settings'),401);
        $posts = Term::where('type', 'page')->paginate(20);
        return view('seller.page.index', compact('posts'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
       abort_if(!getpermission('website_settings'),401);
        return view('seller.page.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        abort_if(!getpermission('website_settings'),401);
        if (postlimitcheck() == false) {
            $errors['errors']['error']='Maximum post limit exceeded';
            return response()->json($errors,401);
        }
       // Validate
        $request->validate([
            'page_title' => 'required',
            'status'     => 'required',
        ]);

       

        // Data
        $data = [
            'page_excerpt' => $request->page_excerpt,
            'page_content' => $request->page_content,
        ];

        DB::beginTransaction();
        try { 
        // Page Data Store
        $page           = new Term();
        $page->title    = $request->page_title;
        $page->slug     = Str::slug($request->page_title);
        $page->type     = 'page';
        $page->status   = $request->status;
        $page->save();

        $page->meta()->create(['key'=>'meta','value'=>json_encode($data)]);
            DB::commit();
        } catch (\Throwable $th) {
            DB::rollback();
            
            $errors['errors']['error']='Opps something wrong';
            return response()->json($errors,401);
        }  
        

        return response()->json('Page Added Successfully');
    }

    

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
       abort_if(!getpermission('website_settings'),401);
        $info = Term::where('type','page')->with('meta')->findOrFail($id);
        $meta=json_decode($info->meta->value ?? '');
        return view('seller.page.edit', compact('info','meta'));
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
       abort_if(!getpermission('website_settings'),401);
        // Validate
        $request->validate([
            'page_title' => 'required',
            'status'     => 'required',
        ]);

        
        // Data
        $data = [
            'page_excerpt' => $request->page_excerpt,
            'page_content' => $request->page_content,
           
        ];
        $page=Term::findOrFail($id);

        $page->title    = $request->page_title;
        $page->slug     = $request->slug;
        $page->status   = $request->status;
        $page->save();

        $page->meta()->update(['value'=>json_encode($data)]);


        return response()->json('Page Updated Successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        abort_if(!getpermission('website_settings'),401);
        $page_destory = Term::findOrFail($id);
        $page_destory->delete();
        return redirect()->back()->with('success', 'Successfully Deleted'); 
    }
}
