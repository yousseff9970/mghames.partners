<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Menu;
use App\Models\Language;
use App\Models\Option;
use App\Category;
use DB;
use Auth;
use Cache;

class MenuController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (!Auth()->user()->can('menu')) {
            abort(401);
        }

        $menus = Menu::latest()->get();
        $langs = get_option('active_languages',true);

        return view('admin.menu.create', compact('menus', 'langs'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if ($request->status == 1) {
            if ($request->position == 'header') {
                DB::table('menu')->where('position', $request->position)->where('lang', $request->lang)->update(['status' => 0]);
            }
        }
        $men = new Menu;
        $men->name = $request->name;
        $men->position = $request->position;
        $men->status = $request->status;
        $men->lang = $request->lang;
        $men->data = "[]";
        $men->save();


        return response()->json(['Menu Created']);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        if (!Auth()->user()->can('menu')) {
            abort(401);
        }
        $info = Menu::findOrFail($id);

        return view('admin.menu.index', compact('info'));
    }
    /*
    update menus json row in  menus table
    */
    public function MenuNodeStore(Request $request)
    {
        $info = Menu::find($request->menu_id);
        $info->data = $request->data;
        $info->save();
        Cache::forget($info->position . $info->lang);
        return response()->json(['Menu Updated']);
    }
    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        if (!Auth()->user()->can('menu')) {
            abort(401);
        }

        $langs = Language::get();
        $info = Menu::find($id);
        return view('admin.menu.edit', compact('info', 'langs'));
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
        if ($request->status == 1) {
            if ($request->position == 'header') {
                DB::table('menu')->where('position', $request->position)->where('lang', $request->lang)->update(['status' => 0]);
            }
        }

        $men = Menu::find($id);
        $men->name = $request->name;
        $men->position = $request->position;
        $men->status = $request->status;
        $men->lang = $request->lang;
        $men->save();
        Cache::forget($request->position . $request->lang);
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
