<?php

namespace App\Http\Controllers;

use App\Models\Term;
use Illuminate\Http\Request;

class PageController extends Controller
{
    public function show($slug)
    {
        $page = Term::with('pagecontent')->where('slug',$slug)->first();
        abort_if(empty($page),404);
        return view('page',compact('page'));
    }
}
