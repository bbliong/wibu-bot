<?php

namespace App\Model;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;

class user_bot extends Model
{
    public static function getUser($user){
    	$users = DB::table('user_bots')->where('user_id', $user)->first();
    	// (!$users) ? $users = $user : $users = false;
    	return $users;
    }

    public static function saveUser($event){
    	$time     = Carbon::now()->toDayDateTimeString();
    	$user = DB::table('user_bots')->insert([
    			'user_id' => $event['userId'] , 
    			'display_name' => $event['displayName'] , 
    			'created_at' =>  $time,
    			'updated_at' =>  $time
    		]);
    	return $user;
    }

    public static function updateTitle($user, $message){
        $update =     DB::table('user_bots')
                        ->where('user_id', $user )
                        ->update(['title' => $message]);
        if ($update) return $message;
    }

     public static function deleteUser($user){
        $delete =     DB::table('user_bots')
                        ->where('user_id', $user )
                        ->delete();
        return $delete;
    }


}
