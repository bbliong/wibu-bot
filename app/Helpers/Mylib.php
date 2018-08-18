<?php

namespace App\Helpers;

use App\Model\event_log as event;

class Mylib {

	public static function delete($id){
		$delete = event::delete($id);
		return $delete;
	}

}

?>