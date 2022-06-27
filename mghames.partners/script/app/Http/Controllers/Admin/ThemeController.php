<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use File;
use ZipArchive;
use Auth;
class ThemeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        
        abort_if(!Auth()->user()->can('store.theme'), 401);
        $file=file_get_contents('theme/themes.json');
        $themes = json_decode($file);
        return view('admin.template.index', compact('themes'));
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
       

        $request->validate([
            'file' => 'required|mimes:zip',
        ]);

        ini_set('max_execution_time', '0');

        if ($request->hasFile('file')) {
            $file = $request->file('file')->getClientOriginalName();
            $ext  = $request->file('file')->getClientOriginalExtension();
            $name = basename($file, '.' . $ext);
        }

        $zip = new ZipArchive;
        $res = $zip->open($request->file);
        if ($res === true) {
            $zip->extractTo('uploads/tmp');
            $zip->close();
            $this->extract = true;
        } else {
            $this->extract = false;
        }

        if (file_exists('uploads/tmp/' . $name . '/function.php')) {
            include 'uploads/tmp/' . $name . '/function.php';

            if (function_exists('theme_info')) {
                $info = theme_info();
                if (file_exists('uploads/tmp/' . $name . '/function.php')) {
                    $theme_assets_root = $info['theme_assets_root'];
                    $theme_src_root    = $info['theme_src_root'];
                    $theme_name        = $info['theme_name'];

                    $assets_link_path = $info['assets_link_path'];
                    $theme_view_path  = $info['theme_view_path'];

                    File::copyDirectory('uploads/tmp/' . $name . '/' . $theme_assets_root, 'theme');
                    File::copyDirectory('uploads/tmp/' . $name . '/' . $theme_src_root, base_path('resources/views/theme/'));
                    File::deleteDirectory('uploads/tmp/' . $name);


                    $file=file_get_contents('theme/themes.json');
                    $posts = json_decode($file);
                   
                   
                    $data['name']=$theme_name;
                    $data['view_path']=$theme_view_path;
                    $data['asset_path']=$assets_link_path;

                    array_push($posts,$data);

                    File::put('theme/themes.json',json_encode($posts,JSON_PRETTY_PRINT));

                    return response()->json(['Theme Uploaded Successfully']);
                }
            } else {
                File::deleteDirectory('uploads/tmp/' . $name);
            }
        } else {
            if (file_exists('uploads/tmp/' . $name)) {
                File::deleteDirectory('uploads/tmp/' . $name);
            }
        }
        $msg['errors']['error'] = "Something Missing With This Theme";
        return response()->json($msg, 401);
    }
}
