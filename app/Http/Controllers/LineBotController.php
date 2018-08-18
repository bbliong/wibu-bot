<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use LINE\LINEBot;
use LINE\LINEBot\HTTPClient\CurlHTTPClient;
use LINE\LINEBot\MessageBuilder\MultiMessageBuilder;
use LINE\LINEBot\MessageBuilder\TextMessageBuilder;
use LINE\LINEBot\MessageBuilder\StickerMessageBuilder;
use LINE\LINEBot\MessageBuilder\TemplateMessageBuilder;
use LINE\LINEBot\MessageBuilder\TemplateBuilder\ButtonTemplateBuilder;
use LINE\LINEBot\TemplateActionBuilder\MessageTemplateActionBuilder;
use LINE\LINEBot\TemplateActionBuilder\PostbackTemplateActionBuilder;
use LINE\LINEBot\TemplateActionBuilder\UriTemplateActionBuilder;
use App\Model\user_bot as user_bot;
use App\Model\event_log as event;
use App\Model\auto_reply as auto_reply;


class LineBotController extends Controller
{

	private $bot;
  	private $events;
  	private $signature;
  	private $user;
  	private $beforeFilter;

	public function __construct(){
		 // create bot object
    $httpClient = new CurlHTTPClient(env('CHANNEL_ACCESS_TOKEN'));
    $this->bot  = new LINEBot($httpClient, ['channelSecret' => env('CHANNEL_SECRET')]);
	}

    public function index(){
    	if($_SERVER['REQUEST_METHOD'] !== "POST"){
    		echo "berhasil Terkoneksi";
    		header('HTTP/1.1 400 Only POST method allowed');
    		exit;
    	}
    	// get request
	    $body = file_get_contents('php://input');
	    $this->signature = isset($_SERVER['HTTP_X_LINE_SIGNATURE']) ? $_SERVER['HTTP_X_LINE_SIGNATURE'] : "-";
	    $this->events = json_decode($body, true);

	    //log every event requests
	    event::log($this->signature, $body);

	    if(is_array($this->events["events"])){
	    	foreach ($this->events["events"] as $event) {
			    		// skip group and room event
		        if(! isset($event['source']['userId'])) continue;

		        // get user data from database
		        $this->user = user_bot::getUser($event['source']['userId']);
		        // return $this->user;
		        if(!isset($this->user))  $this->followCallback($event);
	 			else {
		          // respond event
			          if($event['type'] == 'message'){
			            if(method_exists($this, $event['message']['type'].'Message')){
			              $this->{$event['message']['type'].'Message'}($event);
			            }
			          } 
			          else {
			            if(method_exists($this, $event['type'].'Callback')){
			              $this->{$event['type'].'Callback'}($event);
			            }
		          	}
	    		}
	   		 }
    	}
    }

      private function followCallback($event)
	  {
	    $res = $this->bot->getProfile($event['source']['userId']);
	    if ($res->isSucceeded()){
	      $profile = $res->getJSONDecodedBody();
	      // create welcome message
				$message2 = "kore wa mau di namain pake nani ?";
				$image = 'https://res.cloudinary.com/jejepangan/image/upload/v1502517192/IJBS-K-a_drocyv.jpg';
	      		  $options = [
		                        // new PostbackTemplateActionBuilder('Kun', 'post=back'),
		                        new MessageTemplateActionBuilder('San', 'San'),
		                        new MessageTemplateActionBuilder('Kun', 'Kun'),
		                        new MessageTemplateActionBuilder('Chan', 'Chan'),
		                        // new UriTemplateActionBuilder('Chan', 'https://example.com'),
		                    ];
	      		  $button  =  new ButtonTemplateBuilder('DOmo', $message2 , $image, $options);
	      		  $message =  new LINEBot\MessageBuilder\TemplateMessageBuilder('alt test', $button);
			      $response = $this->bot->replyMessage($event['replyToken'], $message);

		 	  $add = user_bot::saveUser($profile);  
		     if ($response->isSucceeded()) {
			    return 'Succeeded!';
			}
							// Failed
				echo $response->getHTTPStatus() . ' ' . $response->getRawBody();
	    }
	  }

	  	private function textMessage($event){
			$message = $event["message"]["text"];
			$res = $this->bot->getProfile($event['source']['userId']);
			$profile = $res->getJSONDecodedBody();
			$array = ["chan", "kun", "san"];
			if(in_array(strtolower($message), $array )){
				$act = user_bot::updateTitle($event["source"]["userId"], $event["message"]["text"]);
				$greeting = "hai, mulai sekarang kamu dipanggil " . $profile["displayName"]. " - ". $act;
				$response = $this->bot->replyText($event["replyToken"], $greeting);
			}
			else {
				$respon = auto_reply::getRequest($message);
				$response = $this->bot->replyText($event["replyToken"], $respon);
			}

		}

		private function unfollowCallback($event){
			$act  = user_bot::deleteUser($event["source"]["userId"]);
			return $act;
		}
}

