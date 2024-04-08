<?php
namespace App\Utils;

class Utils
{
    /**
     * @param $file
     * @param string $folder
     * @return string
     */
    public static function fileUpload($file, $folder = 'uploads')
    {
        $extension = $file->getClientOriginalExtension();
        $filename = uniqid() . '.' . $extension;
        $path = self::getBasePath() . $folder . "/" . $filename;

        $file->move($folder, $filename);

        return $path;
    }

    /**
     * @param $file
     * @param string $folder
     * @return string
     */
    public static function fileDelete($file, $folder = "uploads")
    {
        $path = self::getBasePath() . $folder . "/" . $file;
        if (file_exists($path)) {
            unlink($path);
            return true;
        }
        return false;
    }

    private static function getBasePath()
    {
        return "uploads/";
    }
}