<?php

namespace App\Http\Controllers;

// use Illuminate\Http\Request;
use Request;
use Illuminate\Support\Facades\DB;
use App\Model\event_log as event;
use App\Model\user_bot as user_bot;
use App\Model\auto_reply as auto_reply;
use Illuminate\Routing\Controller;


class adminController extends Controller
{
    public function index(){
    	return view('admin/index');
    }

    public function posts(){
    	return view('admin/posts');
    }

    public function replies(){
        $show = auto_reply::show();
        return view('admin/replies', ['shows' => $show]);
    }

    public function logs(){
    	$show = event::show();
    	return view('admin/logs', ['shows' => $show]);
    }

    public  function delete($id){
        $delete = event::remove($id);
        return $delete;
    }

    public  function insert(Request $request, $id){
        $request = $request::all();
        // dd($request['request']);
        $insert = event::insert($request['request']);
        return $insert;
    }
}
