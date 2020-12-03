<?php

namespace App\Http\Controllers;

class AggregateController extends Controller
{
    function getIp(){

        try {
            if (!isset($_GET['name']) || $_GET['name'] == ''){
                return ['error_msg' => 'Missing "name" argument'];
            }

            $file_name = storage_path() . '/uploads/' . $_GET['name'];
            if (file_exists($file_name) ==  false){
                return ['error_msg' => 'Log with specific name does not exist'];
            }
            $fn = fopen(storage_path() . '/uploads/' . $_GET['name'],"r");
            $array = [];

            while($row = fgets($fn)) {
                list($sIp) = explode( " ", $row );

                $pos1 = strpos($row, '[');
                $pos2 = strpos($row, ']');
                $length = $pos2 - $pos1;
                $sdate = substr($row, $pos1 + 1, $length - 1);

                if(isset($_GET['dt_start']) && strtotime($_GET['dt_start']) > strtotime($sdate)) {
                    continue;
                }
                if(isset($_GET['dt_end']) && strtotime($_GET['dt_end']) < strtotime($sdate)) {
                    continue;
                }

                if (isset($array[$sIp])) {
                    $array[$sIp]['cnt']++;
                } else {
                    $array[$sIp] = [
                        'ip' => $sIp,
                        'cnt' => 1
                    ];
                }
            }
            fclose( $fn );
            return array_values($array);

        } catch (\Exception $exception) {
            return ['error_msg'=> $exception->getMessage()];
        }
    }

    public function getMethod(){
        try {
            if (!isset($_GET['name']) || $_GET['name'] == ''){
                return ['error_msg' => 'Missing "name" argument'];
            }
            $file_name = storage_path() . '/uploads/' . $_GET['name'];
            if (file_exists($file_name) ==  false){
                return ['error_msg' => 'Log with specific name does not exist'];
            }

            $fn = fopen(storage_path() . '/uploads/' . $_GET['name'],"r");

            $array = [];

            while($row = fgets($fn)) {

                $methodPos1 = strpos($row, '"');
                $methodPos2 = strpos($row, ' /');
                $methodLength = $methodPos2 - $methodPos1;
                $methodPos = substr($row, $methodPos1 + 1, $methodLength - 1);

                $pos1 = strpos($row, '[');
                $pos2 = strpos($row, ']');
                $length = $pos2 - $pos1;

                $sdate = substr($row, $pos1 + 1, $length - 1);

                if(isset($_GET['dt_start']) && strtotime($_GET['dt_start']) > strtotime($sdate)) {
                    continue;
                }
                if(isset($_GET['dt_end']) && strtotime($_GET['dt_end']) < strtotime($sdate)) {
                    continue;
                }

                if (isset($array[$methodPos])) {
                    $array[$methodPos]['cnt']++;
                } else {
                    $array[$methodPos] = [
                        'method' => $methodPos,
                        'cnt' => 1
                    ];
                }
            }
            fclose( $fn );
            return array_values($array);

        } catch (\Exception $exception) {
            return ['error_msg'=> $exception->getMessage()];
        }
    }

    public function getUrl(){

        try {
            if (!isset($_GET['name']) || $_GET['name'] == '') {
                return ['error_msg' => 'Missing \"name\" argument'];
            }
            $file_name = storage_path() . '/uploads/' . $_GET['name'];
            if (file_exists($file_name) ==  false){
                return ['error_msg' => 'Log with specific name does not exist'];
            }

            $fn = fopen(storage_path() . '/uploads/' . $_GET['name'], "r");

            $array = [];
            while ($row = fgets($fn)) {

                $urlPos = strpos($row, ' /');
                $urlPos2 = strpos($row, '?');
                if ($urlPos2 === false) {
                    $urlPos2 = strpos($row, ' ', $urlPos);
                }
                $urlLength = $urlPos2 - $urlPos;
                $sUrl = substr($row, $urlPos + 1, $urlLength);

                $pos1 = strpos($row, '[');
                $pos2 = strpos($row, ']');
                $length = $pos2 - $pos1;

                $sdate = substr($row, $pos1 + 1, $length - 1);

                if (isset($_GET['dt_start']) && strtotime($_GET['dt_start']) > strtotime($sdate)) {
                    continue;
                }
                if (isset($_GET['dt_end']) && strtotime($_GET['dt_end']) < strtotime($sdate)) {
                    continue;
                }

                if (isset($array[$sUrl])) {
                    $array[$sUrl]['cnt']++;
                } else {
                    $array[$sUrl] = [
                        'url' => $sUrl,
                        'cnt' => 1
                    ];
                }
            }
            fclose($fn);
            return array_values($array);

        } catch (\Exception $exception) {
            return ['error_msg' => $exception->getMessage()];
        }
    }
}
