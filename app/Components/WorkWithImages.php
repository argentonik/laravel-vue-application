<?php

namespace App\Components;

class WorkWithImages
{
    public static function upload($file)
    {
        $newImageName = uniqid() . '.' . $file->extension(); 
        $res = $file->storeAs(self::pathToImages(), $newImageName);
        return $res ? $newImageName : null;
    }

    public static function delete($file) {
        
        if ($file === null) {
            return;
        }
        $path = storage_path('app/' . self::pathToImages() . '/' .$file);
        if(file_exists($path)) {
            unlink($path);
        }
    }

    public static function pathToImages()
    {
        return 'public/images';
    }
}
