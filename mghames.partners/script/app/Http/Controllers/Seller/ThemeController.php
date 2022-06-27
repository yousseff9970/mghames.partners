<?php

namespace App\Http\Controllers\Seller;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;
class ThemeController extends Controller
{
    public function index()
    {
        abort_if(!getpermission('website_settings'),401);
        $file=file_get_contents('theme/themes.json');
        $themes = json_decode($file);

        return view('seller.theme.index',compact('themes'));
    }

    public function install($theme)
    {
        $file=file_get_contents('theme/themes.json');
        $themes = json_decode($file);
        foreach ($themes as $key => $value) {
            if($value->name == $theme)
            {
                $data = $value;
                $tenant = tenant();
                $tenant->theme = $data->view_path;
                $tenant->save();
            }
        }

       

        return back();

    }

}
