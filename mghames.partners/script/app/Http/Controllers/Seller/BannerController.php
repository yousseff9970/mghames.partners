<?php

namespace App\Http\Controllers\Seller;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;
use DB;
use Auth;
class BannerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        abort_if(!getpermission('website_settings'),401);
        $type= $request->type == 'short_banner' ? 'short_banner' : 'large_banner';
        return view('seller.banner.create',compact('type'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
         'name' => 'required|max:100',
         'link' => 'required|max:100',
         'button_text' => 'required|max:20',
         'description'=>'max:250'
        ]);
        if (postlimitcheck() == false) {
            $errors['errors']['error']='Maximum post limit exceeded';
            return response()->json($errors,401);
        }

        DB::beginTransaction();
        try { 
            $category=new Category;
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
     * @param  int  $type
     * @return \Illuminate\Http\Response
     */
    public function show($type)
    {
        abort_if(!getpermission('website_settings'),401);
       $type= $type == 'short-banner' ? 'short_banner' : 'large_banner';
       $posts=Category::where('type',$type)->with('preview')->latest()->get();

       return view('seller.banner.index',compact('posts','type'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request,$id)
    {
         abort_if(!getpermission('website_settings'),401);
        $info=Category::with('preview','description')->findorFail($id);
        if ($info->type == 'short_banner' || $info->type == 'large_banner') {
             $link=json_decode($info->slug ?? '');
             $type=$info->type;
             return view('seller.banner.edit',compact('info','link','type'));
        }

        abort(404);
       
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
         'button_text' => 'required|max:20',
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
