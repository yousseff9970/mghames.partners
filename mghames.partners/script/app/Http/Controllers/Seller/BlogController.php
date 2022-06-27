<?php

namespace App\Http\Controllers\Seller;

use App\Http\Controllers\Controller;
use App\Models\Term;
use App\Models\Termmeta;
use Illuminate\Http\Request;
use Illuminate\Support\str;
use Storage;
use DB;
use Auth;
class BlogController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
     
        abort_if(!getpermission('website_settings'),401);
        $posts = Term::with('preview')->where('type', 'blog')->paginate(20);
        return view('seller.blog.index', compact('posts'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
         abort_if(!getpermission('website_settings'),401);
        return view('seller.blog.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if (postlimitcheck() == false) {
            $errors['errors']['error']='Maximum post limit exceeded';
            return response()->json($errors,401);
        }
        // Validate
        $request->validate([
            'title'        => 'required|max:50',
            'short_description'     => 'required|max:300',
            'content' => 'required|max:1000',
            'preview'  => 'required',
        ]);
       

        DB::beginTransaction();
        try { 
       
        $post           = new Term();
        $post->title    = $request->title;
        $post->slug     = Str::slug($request->title, '-');
        $post->type     = 'blog';
        $post->status   = $request->status;
        $post->save();

        $post->meta()->create([
            'key'=>'excerpt',
            'value'=> $request->short_description
        ]);

        $post->meta()->create([
            'key'=>'preview',
            'value'=> $request->preview ?? ''
        ]);

        $post->meta()->create([
            'key'=>'description',
            'value'=> $request->content
        ]);

           DB::commit();
        } catch (\Throwable $th) {
            DB::rollback();
            
            $errors['errors']['error']='Opps something wrong';
            return response()->json($errors,401);
        }  

        

        return response()->json('Blog Added Successfully');
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
        $info = Term::with('preview','excerpt','description')->findOrFail($id);
        return view('seller.blog.edit', compact('info'));
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
         // Validate
         $request->validate([
            'title'        => 'required|max:50',
            'short_description'     => 'required|max:300',
            'content' => 'required|max:1000',
            'preview'  => 'required',
            
        ]);

        // Term Data Update
        $blog           = Term::findOrFail($id);
        $blog->title    = $request->title;
        $blog->slug     = str::slug($request->title);
        $blog->type     = 'blog';
        $blog->status   = $request->status;
        $blog->save();

        // Term Meta For excerpt
        $excerpt          = Termmeta::where('term_id', $id)->where('key', 'excerpt')->first();
        $excerpt->value   = $request->short_description;
        $excerpt->save();

        // Term Meta For Description
        $description          = Termmeta::where('term_id', $id)->where('key', 'description')->first();
        $description->value   = $request->content;
        $description->save();

        // Term Meta For Image
        $preview          = Termmeta::where('term_id', $id)->where('key', 'preview')->first();
        $preview->value   = $request->preview;
        $preview->save();
        
        return response()->json('Blog Updated Successfully');
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
        $blog_destory = Term::findOrFail($id);
        $blog_destory->delete();
        return redirect()->back()->with('success', 'Successfully Deleted'); 
    }
}
