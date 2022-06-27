<?php

namespace App\Http\Controllers\Seller;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;
use Str;
use DB;
use Auth;
class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        abort_if(!getpermission('products'),401);
        $posts=Category::where('type','category')->with('preview','icon');

        if (isset($request->src)) {
          $posts=  $posts->where('name','LIKE','%'.$request->src.'%');
        }
        $posts=$posts->latest()->paginate(20);
        return view("seller.category.index",compact('posts','request'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        abort_if(!getpermission('products'),401);
        return  view("seller.category.create");
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
        $validated = $request->validate([
         'name' => 'required|max:100',
         'description'=>'max:250'
        ]);

        DB::beginTransaction();
        try { 
            $category=new Category;
            if (isset($request->slug)) {
                $slug= $request->slug;
            }
            else{
                 $slug= $category->makeSlug($request->name,$request->type);
            }
           

            $category->name=$request->name;
            $category->type=$request->type;
            $category->slug=$slug;
            $category->featured=$request->featured ?? 0;
            $category->menu_status=$request->menu_status ?? 0;
            if (isset($request->category_id)) {
               $category->category_id=$request->category_id;
            }
            $category->save();

            if ($request->description) {
               $category->meta()->create(['type'=>'description','content'=>$request->description]);
            }

            if ($request->preview) {
               $category->meta()->create(['type'=>'preview','content'=>$request->preview]);
            }

            if ($request->icon) {
               $category->meta()->create(['type'=>'icon','content'=>$request->icon]);
            }

            
            DB::commit();
        } catch (\Throwable $th) {
            DB::rollback();
            
            $errors['errors']['error']='Opps something wrong';
            return response()->json($errors,401);
        }      

        $type=ucfirst(str_replace('_',' ',$request->type));

        return response()->json($type.' Created Successfully...!!!');
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
       
        return view("seller.category.show");
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
        $info=Category::with('description','preview','icon')->findorFail($id);
        return view("seller.category.edit",compact('info'));
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
        $validated = $request->validate([
         'name' => 'required|max:100',
         'description'=>'max:250'
        ]);
       
        DB::beginTransaction();
        try { 
            $category=Category::findorFail($id);
            $slug=$request->slug;

            $category->name=$request->name;
            $category->slug=$slug;
            $category->category_id=$request->category_id ?? null;
            $category->featured=$request->featured ?? 0;
            $category->menu_status=$request->menu_status ?? 0;
            $category->save();

            if ($request->description) {
                if (empty($category->description)) {
                     $category->description()->create(['type'=>'description','content'=>$request->description]);
                }
                else{
                    $category->description()->update(['content'=>$request->description]);
                }
             
            }
            else{
               if (!empty($category->description)) {
                $category->description()->delete();
               } 
            }


            if ($request->preview) {
                if (empty($category->preview)) {
                     $category->preview()->create(['type'=>'preview','content'=>$request->preview]);
                }
                else{
                    $category->preview()->update(['content'=>$request->preview]);
                }
             
            }
            else{
               if (!empty($category->preview)) {
                $category->preview()->delete();
               } 
            }

            if ($request->icon) {
                if (empty($category->icon)) {
                     $category->icon()->create(['type'=>'icon','content'=>$request->icon]);
                }
                else{
                    $category->icon()->update(['content'=>$request->icon]);
                }
             
            }
            else{
               if (!empty($category->preview)) {
                $category->icon()->delete();
               } 
            }
           

           

            
            DB::commit();
        } catch (\Throwable $th) {
            DB::rollback();

            $errors['errors']['error']='Opps something wrong';
            return response()->json($errors,401);
        }      

        $type=ucfirst(str_replace('_',' ',$request->type));

        return response()->json($type.' Updated...!!!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $ignore_status=[1,2,3];
        if(!in_array($id,$ignore_status)){
         $category=Category::destroy($id);
        
        }
         return back();

    }

   
}
