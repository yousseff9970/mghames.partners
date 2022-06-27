<?php

namespace App\Http\Controllers\Seller;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;
use DB;
use Auth;
class SliderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
         abort_if(!getpermission('website_settings'),401);
        $posts=Category::where('type','slider')->with('preview')->latest()->get();

        return view('seller.slider.index',compact('posts'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
         abort_if(!getpermission('website_settings'),401);
       return view('seller.slider.create');
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
         'link' => 'required|max:100',
         'button_text' => 'required|max:50',
         'description'=>'max:250'
        ]);

        DB::beginTransaction();
        try { 
            $category=new Category;
            
            $slug= $request->slug;
            
           

            $category->name=$request->name;
            $category->type=$request->type;
            $category->slug=json_encode(array(
                'link'=>$request->link,
                'button_text'=>$request->button_text
            ));
            
            
            $category->save();

            if ($request->description) {
               $category->meta()->create(['type'=>'description','content'=>$request->description]);
            }

            if ($request->preview) {
               $category->meta()->create(['type'=>'preview','content'=>$request->preview]);
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
        abort_if(!getpermission('website_settings'),401);
        $info=Category::where('type','slider')->with('preview','description')->findorFail($id);
        $link=json_decode($info->slug ?? '');
        return view('seller.slider.edit',compact('info','link'));
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
         'link' => 'required|max:100',
         'button_text' => 'required|max:50',
         'description'=>'max:250'
        ]);
       
        DB::beginTransaction();
        try { 
            $category=Category::findorFail($id);
            

            $category->name=$request->name;
            $category->slug=json_encode(array(
                'link'=>$request->link,
                'button_text'=>$request->button_text
            ));
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
        //
    }
}
