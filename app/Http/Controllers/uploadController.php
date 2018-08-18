<?php

namespace App\Http\Controllers;


use Illuminate\Http\File;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Facades\Excel;
use App\Model\waifu;



class uploadController extends Controller
{
    public function index( Request $request){
    	$file = $request->file('upload');
   
      //Display File Name
      $Name = $file->getClientOriginalName();
	    $ex   = $file->getClientOriginalExtension();
      $path = $file->getRealPath();
      $size = $file->getSize();
  
      //Move Uploaded File

      //untuk memasukan file ke folder yang sudah di setting sebelumnyd di filesystem, kalau ini disetting ke folder public/(link storage)
      $upload = Storage::putFileAs(
		    'uploads', $file, $Name
			);
      	
      return view('home', ['status' => $upload]);
    }

    public function getFile($name)
    {
        return storage_path("app\public\\"). $name;
    }

    public function show(){
      	$files = Storage::url('uploads');
        $name =   $this->getFile($files[0]);
      	Excel::load($name, function($reader) {

          // // Getting all results
          // $results = $reader->get();

          // ->all() is a wrapper for ->get() and will work the same
          $reader = $reader->get();
                        // Loop through all sheets
              $reader->each(function($sheet) {
                // dump($sheet);
                  $cek = waifu::saveData($sheet);
                  dump($cek);
              });
      });
    }
}
