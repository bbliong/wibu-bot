<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class waifuController extends Controller
{
    public function index(){
    	return view('waifu/homepage');
    }

    public function get(){
    	
    }
}
