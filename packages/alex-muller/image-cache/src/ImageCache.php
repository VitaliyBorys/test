<?php
/**
 * Created by PhpStorm.
 * User: alex
 * Date: 5/15/18
 * Time: 10:25 AM
 */

namespace AlexMuller\ImageCache;
use Image;


class ImageCache
{
    public static function imageResize($w, $h, $path, $heighten = false)
    {
        $_image = explode('/', $path);
        $imageName = end($_image);
        $cacheDir = 'img/cache/' . $w . '_' . $h . '/';
        $imageCacheUrl = url( $cacheDir . $imageName );
        $fileCachePath = public_path($cacheDir . $imageName);
        $fileOriginalPath = storage_path('app/' . $path);



        if($path && file_exists($fileOriginalPath)){

            if( file_exists( $fileCachePath ) &&  ( filemtime($fileCachePath) > filemtime($fileOriginalPath) ) ){
                return str_replace('\\','/',$imageCacheUrl);
            }

            //создать директорию, если не существует
            if(!is_dir(public_path($cacheDir))){
                mkdir(public_path($cacheDir), 0777, true);
            }

            if($heighten){
                $Image = Image::make($fileOriginalPath)->heighten($h);
            }else{
                $Image = Image::make($fileOriginalPath)->widen($w);
            }

            $Image->save(public_path($cacheDir) . $imageName);

            return  str_replace('\\','/',$imageCacheUrl);
        }

        return false;
    }
}