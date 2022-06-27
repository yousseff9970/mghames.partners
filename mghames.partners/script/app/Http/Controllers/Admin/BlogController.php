<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Term;
use App\Models\Termmeta;
use Illuminate\Http\Request;
use Illuminate\Support\str;
use Storage;
use DB;
class BlogController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
     
        abort_if(!Auth()->user()->can('blog.index'), 401);
        $all_blogs = Term::with('excerpt')->where('type', 'blog')->paginate(20);
        return view('admin.blog.index', compact('all_blogs'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        abort_if(!Auth()->user()->can('blog.create'), 401);
        return view('admin.blog.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // Validate
        $request->validate([
            'name'        => 'required',
            'excerpt'     => 'required',
            'description' => 'required',
            'thum_image'  => 'required|image|max:2024',
        ]);
        // Thum Image Check
        if ($request->hasFile('thum_image')) {
          
            $image=$request->file('thum_image');
            $path='uploads/'.strtolower(env('APP_NAME')).date('/y/m/');
            $name = uniqid().date('dmy').time(). "." . strtolower($image->getClientOriginalExtension());

            Storage::disk(env('STORAGE_TYPE'))->put($path.$name, file_get_contents(Request()->file('thum_image')));

            $file_url= Storage::disk(env('STORAGE_TYPE'))->url($path.$name);
            $preview=$file_url;
        }
       
        DB::beginTransaction();
        try { 
        // Term Data Store
        $post           = new Term();
        $post->title    = $request->name;
        $post->slug     = Str::slug($request->name, '-');
        $post->type     = 'blog';
        $post->status   = $request->status;
        $post->featured = 1;
        $post->save();

        $post->meta()->create([
            'key'=>'excerpt',
            'value'=> $request->excerpt
        ]);

        $post->meta()->create([
            'key'=>'preview',
            'value'=> $preview ?? ''
        ]);

        $post->meta()->create([
            'key'=>'description',
            'value'=> $request->description
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
        abort_if(!Auth()->user()->can('blog.edit'), 401);
        $blog_edit = Term::findOrFail($id);
        return view('admin.blog.edit', compact('blog_edit'));
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
            'name'        => 'required',
            'excerpt'     => 'required',
            'description' => 'required',
            'thum_image'  => 'image|max:2024',
        ]);

        // Term Data Update
        $blog_update           = Term::findOrFail($id);
        $blog_update->title    = $request->name;
        $blog_update->slug     = str::slug($request->name);
        $blog_update->type     = 'blog';
        $blog_update->status   = $request->status;
        $blog_update->featured = 1;
        $blog_update->save();

        // Term Meta For excerpt
        $blog_meta_excerpt_update          = Termmeta::where('term_id', $id)->where('key', 'excerpt')->first();
        $blog_meta_excerpt_update->value   = $request->excerpt;
        $blog_meta_excerpt_update->save();


        // Term Meta For Description
        $blog_meta_description_update          = Termmeta::where('term_id', $id)->where('key', 'description')->first();
        $blog_meta_description_update->value   = $request->description;
        $blog_meta_description_update->save();

        // Thum Image Check
        if ($request->hasFile('thum_image')) {
            if (!empty($blog_update->preview)) {
                $file=$blog_update->preview->value;
                $arr=explode('uploads',$file);
                if (count($arr ?? []) != 0) {
                    if (isset($arr[1])) {
                       Storage::disk(env('STORAGE_TYPE'))->delete('uploads'.$arr[1]);
                    }
                }
            }

            $image=$request->file('thum_image');
            $path='uploads/'.strtolower(env('APP_NAME')).date('/y/m/');
            $name = uniqid().date('dmy').time(). "." . strtolower($image->getClientOriginalExtension());

            Storage::disk(env('STORAGE_TYPE'))->put($path.$name, file_get_contents(Request()->file('thum_image')));

            $file_url= Storage::disk(env('STORAGE_TYPE'))->url($path.$name);
            $preview=$file_url;

            // Term Meta For Image
            $blog_meta_thumimg_update          = Termmeta::where('term_id', $id)->where('key', 'preview')->first();
            $blog_meta_thumimg_update->value   = $preview;
            $blog_meta_thumimg_update->save();
        }
        

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
        abort_if(!Auth()->user()->can('blog.delete'), 401);
        $blog_destory = Term::findOrFail($id);
        

        if (!empty($blog_destory->preview)) {
            $file=$blog_destory->preview->value;
            $arr=explode('uploads',$file);
            if (count($arr ?? []) != 0) {
                if (isset($arr[1])) {
                 Storage::disk(env('STORAGE_TYPE'))->delete('uploads'.$arr[1]);
              }
            }
        }

        $blog_destory->delete();
        return redirect()->back()->with('success', 'Successfully Deleted'); 
    }
}
