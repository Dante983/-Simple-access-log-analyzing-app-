<?php

namespace App\Http\Controllers;

class DownloadsController extends Controller
{
    public function download($file_name){

        try {
            if ($file_name == false){
                return ['error_msg' => 'Log with specific name does not exist'];
            }
            $file = storage_path() . '/uploads/' . $file_name;
            $type = mime_content_type($file);

            $headers = [
                'Content-Type: ' . $type
            ];

            return response() -> download($file, $file_name, $headers);
        } catch (\Exception $exception){
            return ['error_msg' => $exception->getMessage()];
        }

    }
}
