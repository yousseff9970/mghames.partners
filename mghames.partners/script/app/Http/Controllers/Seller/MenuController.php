<?php

namespace App\Http\Controllers\Seller;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Menu;
use Auth;
use DB;
class MenuController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        abort_if(!getpermission('website_settings'),401);
        $menus = Menu::latest()->get();
        $langs = get_option('languages',true);
        $theme=tenant('theme') != null ? tenant('theme') : 'theme.resto';
        $theme=str_replace('.','/',$theme);


        $functions= resource_path('views/'.$theme.'/options.php');
        include($functions);
          
        $positions=$menu_types;
        return view('seller.menu.create', compact('menus', 'langs','positions'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        abort_if(!getpermission('website_settings'),401);
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
         if ($request->status == 1) {
            if ($request->position == 'header') {
                DB::table('menu')->where('position', $request->position)->where('lang', $request->lang)->update(['status' => 0]);
            }
        }
        $men = new Menu;
        $men->name = $request->name;
        $men->position = $request->position;
        $men->status = 1;
        $men->lang = $request->lang ?? 'en';
        $men->data = "[]";
        $men->save();


        return response()->json(['Menu Created']);
    }

    /*
    update menus json row in  menus table
    */
    public function MenuNodeStore(Request $request)
    {
        $info = Menu::findOrFail($request->menu_id);
        $info->data = $request->data;
        $info->save();
        TenantCacheClear($info->position . $info->lang);
        return response()->json(['Menu Updated']);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        abort_if(!getpermission('website_settings'),401);
        $info = Menu::findOrFail($id);

        return view('seller.menu.index', compact('info'));
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
       
        $langs = get_option('languages',true);
        $info = Menu::find($id);

        $theme=tenant('theme') != null ? tenant('theme') : 'theme.resto';
        $theme=str_replace('.','/',$theme);


        $functions= resource_path('views/'.$theme.'/options.php');
        include($functions);
          
        $positions=$menu_types;
        return view('seller.menu.edit', compact('info', 'langs','menu_types','positions'));
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
       

        $men = Menu::find($id);
        $men->name = $request->name;
        $men->position = $request->position;
        
        $men->lang = $request->lang ?? 'en';
        $men->save();
        TenantCacheClear($request->position . $request->lang);
        return response()->json(['Menu Updated']);
    }

  


    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        abort_if(!getpermission('website_settings'),401);
        if ($request->method == 'delete') {
            if ($request->ids) {
                foreach ($request->ids as $id) {
                    Menu::destroy($id);
                }
            }
        }

        return response()->json(['Menu Removed']);
    }
}
