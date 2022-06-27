<?php

namespace App\Http\Controllers\Seller;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;
use DB;
use Auth;
class SpecialmenuController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
         abort_if(!getpermission('website_settings'),401);
        $posts=Category::where('type','special_menu')->with('preview')->orderBy('featured','ASC')->get();

        return view('seller.specialmenu.index',compact('posts'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
          abort_if(!getpermission('website_settings'),401);
         return view('seller.specialmenu.create');
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
             'days'=>'max:20',
             'time' => 'required|max:30',
             'link' => 'required|max:100',
             'short' => 'required|max:10',
        ]);

        $count=Category::where('type','special_menu')->count();
        if ($count >= 7) {
            $errors['errors']['error']='Max Day limit 7';
            return response()->json($errors,401);
        }

        DB::beginTransaction();
        try { 
            $category=new Category;
            
           

            $category->name=$request->name;
            $category->type='special_menu';
            $category->slug=json_encode(array(
                'days'=>$request->days ?? '',
                'time'=>$request->time ?? '',
                'link'=>$request->link ?? '',

            ));
            $category->featured=$request->short ?? 0;
           
            $category->save();

            

            if ($request->preview) {
               $category->meta()->create(['type'=>'preview','content'=>$request->preview]);
            }

            

            
            DB::commit();
        } catch (\Throwable $th) {
            DB::rollback();
          
            $errors['errors']['error']='Opps something wrong';
            return response()->json($errors,401);
        }      

       
        return response()->json('Created Successfully...!!!');
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
        $info=Category::where('type','special_menu')->with('preview')->findorFail($id);
        $data=json_decode($info->slug ?? '');
        return view('seller.specialmenu.edit',compact('info','data'));
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
             'days'=>'max:20',
             'time' => 'required|max:30',
             'link' => 'required|max:100',
             'short' => 'required|max:10',
        ]);

        DB::beginTransaction();
        try { 
            $category= Category::where('type','special_menu')->findorFail($id);
            
           

            $category->name=$request->name;
            $category->slug=json_encode(array(
                'days'=>$request->days ?? '',
                'time'=>$request->time ?? '',
                'link'=>$request->link ?? '',

            ));
            $category->featured=$request->short ?? 0;
            $category->save();

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

       
        return response()->json('Updated Successfully...!!!');
    }

    
}
