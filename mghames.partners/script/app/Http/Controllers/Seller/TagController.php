<?php

namespace App\Http\Controllers\seller;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;
use Str;
use Auth;
class TagController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        abort_if(!getpermission('products'),401);
        $posts=Category::where('type','tag')->latest();
        if (isset($request->src)) {
          $posts=  $posts->where('name','LIKE','%'.$request->src.'%');
        }
        $posts=$posts->paginate(20);
        return view("seller.tag.index",compact('posts','request'));

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
         abort_if(!getpermission('products'),401);
        return view("seller.tag.create");
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
         abort_if(!getpermission('products'),401);
         if (postlimitcheck() == false) {
            $errors['errors']['error']='Maximum post limit exceeded';
            return response()->json($errors,401);
        }
        $validated = $request->validate([
         'tag_name' => 'required|max:100',
        ]);

        $tag=new Category;
        $tag->name=$request->tag_name;
        $tag->slug=$this->makeSlug($request->tag_name,'tag');
        $tag->type='tag';
        $tag->featured=$request->is_featured;
        $tag->save();

        return response()->json('Tag Created Successfully');

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        abort_if(!getpermission('products'),401);
        return view("seller.tag.show");
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        abort_if(!getpermission('products'),401);
        $info=Category::where('type','tag')->findorFail($id);
        return view("seller.tag.edit",compact('info'));
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
         abort_if(!getpermission('products'),401);
        $validated = $request->validate([
         'tag_name' => 'required|max:100',
        ]);

        $tag=Category::where('type','tag')->findorFail($id);
        $tag->name=$request->tag_name;
        $tag->slug=$request->slug;
        $tag->featured=$request->is_featured;
        $tag->save();

        return response()->json('Tag Updated Successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
       abort_if(!getpermission('products'),401);
       $tag=Category::destroy($id);
       return back();
       
    }

    public function makeSlug($title,$type)
    {
       $slug_gen=Str::slug($title); 
       $slug=Category::where('type',$type)->where('slug',$slug_gen)->count();
       if ($slug > 0) {
          $slug_count=$slug+1;
          $slug=$slug_gen.$slug_count;
          return $this->makeSlug($slug,$type);
       }

       return $slug_gen;


    }
}
