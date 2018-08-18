<?php

namespace App\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;

class auto_reply extends Model
{
        public static function getRequest($text){
        if(isset($text)){
        	$text = strtolower($text);
                while(1) {
                    $text2 = str_replace("  ", " ", $text);
                    if($text2 == $text) {
                        break;
                    }
                    else {
                        $text = $text2;
                    }
                }
                $text = explode(" ", $text);
                $ind = 0;
                $arrays = [[]];
                while($ind < count($text)){
                    $pola = "/\b".$text[$ind]."\b/im";
                    $query = DB::table("auto_replies")->where('requests', 'like', '%'.$text[$ind].'%')->get();   
                 	foreach($query as $row){
                        $cek = preg_match_all($pola,$row->requests, $matches );
                            if($matches){
                                $arrays[$ind][] = $row->id;
                            }
                        }
                    $ind++;
                }

                $isRepeated = array();
                foreach($arrays as $subArray) {
                    foreach($subArray as $item) {
                        if (!isset($isRepeated[$item])) {
                            $isRepeated[$item] = 1;
                        } else {
                            $isRepeated[$item]++;
                        } 
                    }
                }
                if(!empty($isRepeated)){
                    $fresult = max($isRepeated);
                    $key = array_search($fresult, $isRepeated);
                    $row = DB::table('auto_replies')->where('id', $key)->first();
                    // $row = $connect->query("select * from question where id=".$key."");
                    // echo $row->fetch(PDO::FETCH_OBJ)->respons;
                    return $row->response;
                    // var_dump($arrays);
                    // var_dump($isRepeated);
                } 
                else {
                   return "kan belum diajarin :(";
                }

            }

        }
    public static function show(){
        $show = DB::table('auto_replies')->get();
        return $show;
    }
}
