<?php

namespace App\Http\Controllers\Seller;

use App\Http\Controllers\Controller;
use App\Models\Language;
use App\Models\Option;
use Illuminate\Http\Request;
use Auth;
class LanguageController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        abort_if(!getpermission('website_settings'),401);
        $languages=Option::where('key','languages')->first();
        $languages = json_decode($languages->value ?? '');
        return view('seller.language.index',compact('languages'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        abort_if(!getpermission('website_settings'),401);
        $lang_json_file = file_get_contents(resource_path('lang/languages.json'));
        $languages = json_decode($lang_json_file); 
       
        return view('seller.language.create',compact('languages'));
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
        $language = Language::where('name',$request->language)->first();

        if($language)
        {
            $errors['errors']['error']='Language Already Exists!';
            return response()->json($errors,401);
        }

        $lang_json_file = file_get_contents(resource_path('lang/languages.json'));
        $languages = json_decode($lang_json_file);

        foreach ($languages as $key => $value) {
            if($key == $request->language)
            {
                $language_name = $value;
            }
        }

        $data = [
            'name' => $language_name,
            'code' => $request->language
        ];

       

        $language=Option::where('key','languages')->first();
        if (!empty($language)) {
            $languages = json_decode($language->value ?? '');
            
        }
        else{
            $languages=[];
            $language=new Option;
            $language->key='languages';
        }
        $is_key_exists=false;
        foreach ($languages ?? [] as $key => $value) {
            if ($value->code == $request->language) {
                $is_key_exists=true;
            }
        }

        if ($is_key_exists == false) {
            array_push($languages,$data);
        }
        
 
        
        $language->value = json_encode($languages);
        $language->autoload = 1;
        $language->save();

        TenantCacheClear('languages');

        return response()->json('Language Created');

    }

    

    

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function delete(Request $request)
    {
        abort_if(!getpermission('website_settings'),401);
        foreach ($request->id as $key => $value) {
            if($request->status == 'delete')
            {
                $language = Language::find($value);
                
                $language->delete();
            }
        }

        return response()->json('Language Deleted.');
    }

    public function destroy($id)
    {
        $languages=Option::where('key','languages')->first();
        $languages_data = json_decode($languages->value ?? '');
        

        foreach ($languages_data ?? [] as $key => $value) {
            if ($value->code != $id) {
                $data[]=$value;
            }
           
        }
        $languages->value=json_encode($data ?? []);
        $languages->save();
        return back();

    }
}
