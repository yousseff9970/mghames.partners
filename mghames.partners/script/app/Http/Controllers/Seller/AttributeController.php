<?php

namespace App\Http\Controllers\seller;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;
use App\Models\Category;
use Auth;
class AttributeController extends Controller
{
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
      abort_if(!getpermission('products'),401);
        $posts=Category::where('type','parent_attribute')->with('categories');
        if ($request->src) {
            $posts=$posts->where('name','LIKE','%'.$request->src.'%');
        }

        $posts=$posts->latest()->paginate(30);
        return view("seller.attribute.index",compact('posts','request'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
       abort_if(!getpermission('products'),401);
        return view("seller.attribute.create");
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
         'parent_name' => 'required|max:100',
        ]);

        DB::beginTransaction();
        try { 
        $parent=new Category;
        $parent->name=$request->parent_name;
        $parent->slug=$request->select_type;
        $parent->type="parent_attribute";
        $parent->featured=$request->featured;
        $parent->save();

        if ($request->child) {
            $childs=[];
            foreach ($request->child as $key => $row) {
                if (!empty($row)) {
                    $arr['name']=$row;
                    $arr['slug']=$row;
                    $arr['type']='child_attribute';
                    $arr['category_id']=$parent->id;
                    array_push($childs, $arr);
                }
               
            }
          
            Category::insert($childs);
        }
        
        DB::commit();
        } catch (\Throwable $th) {
            DB::rollback();
            return $th;
            $errors['errors']['error']='Opps something wrong';
            return response()->json($errors,401);
        }   

        return response()->json('Attribute Created Successfully...!!!');

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
        return view("seller.attribute.show");
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
        $info=Category::where('type','parent_attribute')->with('categories')->findorFail($id);
        return view("seller.attribute.edit",compact('info'));
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
         'parent_name' => 'required|max:100',
        ]);

        DB::beginTransaction();
        try { 
        $parent= Category::with('categories')->findorFail($id);
        $parent->name=$request->parent_name;
        $parent->slug=$request->select_type;
        $parent->featured=$request->featured;
        $parent->save();
       
        $oldchilids=[];
        
        foreach ($request->oldchild ?? [] as $key => $row) {
            $oldchild= Category::findorFail($key);
            $oldchild->name=$row;
            $oldchild->save();
            array_push($oldchilids, $oldchild->id);
        }


        if ($request->newchild) {
            $childs=[];
            foreach ($request->newchild ?? [] as $key => $row) {
                if (!empty($row)) {
                    $arr['name']=$row;
                    $arr['slug']=$row;
                    $arr['type']='child_attribute';
                    $arr['category_id']=$parent->id;
                    array_push($childs, $arr);
                }
               
            }
          
            Category::insert($childs);
        }

        foreach ($parent->categories ?? [] as $key => $value) {
            if (!in_array($value->id, $oldchilids)) {
                Category::destroy($value->id);
            }
        }

        
        
        DB::commit();
        } catch (\Throwable $th) {
            DB::rollback();
            return $th;
            $errors['errors']['error']='Opps something wrong';
            return response()->json($errors,401);
        }   

        return response()->json('Attribute Updated Successfully...!!!');
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
