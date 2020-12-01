<?php

namespace App\Http\Controllers;

use Exception;
use Illuminate\Http\Request;

class LogController extends Controller
{
    //function to display data
    public function display(){

        $empty = [];
        $files = scandir(storage_path() . '/uploads');

        foreach ($files as $file){

            if ($file != '.' && $file != '..'){
                $name = $file;
                $upload_time = date ("Y-m-d H:i:s",
                    filemtime(storage_path() . '/uploads/' . $file));
                $size = filesize(storage_path() . '/uploads/'.$file);

                $arrays = [
                    'name' => $name,
                    'upload_time' => $upload_time,
                    'size' => $size
                ];

                $empty[] = $arrays;
            }
        }
        return $empty;
    }

    //function to upload data
    public function store(Request $req){

        try {

            if ($req->file('file')->getSize() > (1024*1024) * 100){
                return ['error_msg' => 'File is > 100Mb'];
            }

            if (!isset($_POST['name']) || $_POST['name'] == ''){
                return ['error_msg' => 'Missing "name" POST argument'];
            }

            $mime_type = $req->file('file')->getMimeType();

            if ($mime_type != 'text/plain' && $mime_type != 'application/gzip'){
                return ['error_msg' => 'The file is not gzipped or txt'];
            }

            $req->file('file')->move(storage_path() . '/uploads', $_POST['name']);

            $upload_time = date ("Y-m-d H:i:s",
                filectime(storage_path() . '/uploads/' . $_POST['name']));

            return['name' => $_POST['name'], 'upload_time' => $upload_time];

        } catch (Exception $exception) {
            return ['error_msg'=>$exception->getMessage()];
        }
    }
}
