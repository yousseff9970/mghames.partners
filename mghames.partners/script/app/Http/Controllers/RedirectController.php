<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
class RedirectController extends Controller
{
	public function index()
	{
		if (Auth::User()->role_id == 1) {
			return redirect()->route('admin.dashboard');
		}
		elseif (Auth::User()->role_id == 2) {
			return redirect()->route('author.dashboard');
		}

		return redirect('login');
	}
}
