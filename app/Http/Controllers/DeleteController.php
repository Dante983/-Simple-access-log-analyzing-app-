<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Storage;

class DeleteController extends Controller
{
    public function delete($file_name){
        $file_name = storage_path() . '/uploads/' . $file_name;

        try {
            if (file_exists($file_name) == false){
                return ['error_msg' => 'Log with specific name does not exist'];
            }
        unlink($file_name);
        } catch (\Exception $exception){
            return ['error_msg'=>$exception->getMessage()];
        }

    }
}
