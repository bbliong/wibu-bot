<?php

namespace App\Model;

use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;

class waifu extends Model
{
     public static function saveData($event){
     	$cek = DB::table('waifus')->where('waifu', $event->waifu)->first();
     	// if(!$cek){
	    	$time     = Carbon::now()->toDayDateTimeString();
	    	$waifu = DB::table('waifus')->insert([
	    			'waifu' => $event->waifu , 
	    			'link' => $event->link , 
	    			'birth' => $event->birth , 
	    			'created_at' =>  $time,
	    			'updated_at' =>  $time
	    		]);
	    	return $waifu;
    	// }
    	// return false;
    }
}
