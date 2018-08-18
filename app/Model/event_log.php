<?php

namespace App\Model;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;


class event_log extends Model
{
 
   public static function log($signature, $body){
    	$events = json_decode($body, true);
    	// dd($events["events"][0]["source"]);
    	foreach($events['events'] as $event) {
			isset($event["source"]) ?  $username = $event["source"]["userId"] : $username = "anonim";
	    	if(isset($event["message"])){
	    		if($event["message"]["type"] == "text"){
	    			$request  = $event["message"]["text"];
	    			$time     = Carbon::now()->toDayDateTimeString();
	    		}
	    	}
	    	else {
	    		$request = '';
	    		$time    = Carbon::now()->toDayDateTimeString();
	    	}    	
	    }

    	$log = DB::table('event_logs')->insert([
    		"signature" => $signature,
	    	"event"     => $body,
	    	"username"  => $username,
	    	"request"   => $request,
	    	"created_at"=> $time,
	    	"updated_at"=> $time
   		]);

		return $log;    	
    }

    public static function show(){
    	$show = DB::table('event_logs')->where('visible', true )->get();
    	return $show;
    }

    public static function remove($id){
    	$delete = DB::table('event_logs')->where('id', $id )->delete();
    	return $delete;
    }

    public static function insert($request){
    	$time     = Carbon::now()->toDayDateTimeString();
    	$insert = DB::table('auto_replies')->insert([
    		"requests" => $request,
    		"created_at"=> $time,
	    	"updated_at"=> $time
    		]);
    	$update = DB::table('event_logs')->where('request', $request)->update(['visible' => faLse]);
    	if($insert == true && $update == 1 ){
    		return 1;
    	}
    	else {
    		return 0;
    	}
    }

}
