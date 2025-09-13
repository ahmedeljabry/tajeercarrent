<?php

namespace App\Helpers;

use Illuminate\Support\Str;

class WebpImage
{
    public static function generateUrl($url){
        $url = Str::replace([url(''), '/storage/'], '', $url);
        $data = explode(".", $url);
        if (count($data) == 1){
            $url = $data[0];
            $extension = "jpeg";
        }else{
            $url = $data[0];
            $extension = $data[1];
        }
        $extension = strtolower($extension);
        return $url. '.' . "webp?extension=$extension";
    }
    public static function convert(
        $fullPath,
        $outPutQuality = 50,
        $deleteOriginal=true
     ){
        if(file_exists($fullPath)):

            $ext = pathinfo($fullPath, PATHINFO_EXTENSION);
            $extension = strtolower($ext);
            $newFileFullPath = str_replace('.'.$ext,'.webp',$fullPath);

            $isValidFormat = false;
            $img = null;

            try{
                if($extension == 'png'){
                    $img = imagecreatefrompng($fullPath);
                    $isValidFormat = true;
                }
                else if(in_array($extension, ['jpg', 'jpeg'])) {
                    $img = imagecreatefromjpeg($fullPath);
                    $isValidFormat = true;
                }
                else if($extension == 'gif') {
                    $img = imagecreatefromgif($fullPath);
                    $isValidFormat = true;
                }
            }catch (\Exception $e){
                        $isValidFormat = false;
            }

            if($isValidFormat){
                imagepalettetotruecolor($img);
                imagealphablending($img, true);
                imagesavealpha($img, true);
                imagewebp($img, $newFileFullPath, $outPutQuality);
                imagedestroy($img);

                if($deleteOriginal){
                    unlink($fullPath);
                }

                $newPathInfo = explode('/', $newFileFullPath);
                $finalImage  = $newPathInfo[count($newPathInfo)-1];
            }else{
                $newPathInfo = explode('/', $fullPath);
                $finalImage  = $newPathInfo[count($newPathInfo)-1];
            }


            $result = array(
                "fullPath"=>$newPathInfo,
                "file"=>$finalImage,
                "status"=>1
            );

            return (Object) $result;

        else:
            return (Object) array('error'=>__('site.File does not exist'),'status'=>0);
        endif;

    }
}