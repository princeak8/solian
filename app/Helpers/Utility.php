<?php

namespace App\Helpers;

use Intervention\Image\ImageManager;
use File;

use stdClass;

/**
 * Generic Utilty class for app wide functions
 *
 */
class Utility

{
    public static $file_path = "uploads/";

    /**
     * Returns a generic object with attribute and values of the supplied array
     *
     * @param array
     * @return stdClass
     */

    public static function arrayToObject($array)
    {
        $object = new stdClass();
        foreach ($array as $key => $value) {
            $object->$key = $value;
        }
        return $object;
    }

    //https://www.php.net/manual/en/function.com-create-guid.php#119168
    /**
     * Returns a GUIDv4 string
     *
     * Uses the best cryptographically secure method
     * for all supported pltforms with fallback to an older,
     * less secure version.
     *
     * @param bool $trim
     * @return string
     */
    public static function GUIDv4($trim = true)
    {
        // Windows
        if (function_exists('com_create_guid') === true) {
            if ($trim === true)
                return trim(com_create_guid(), '{}');
            else
                return com_create_guid();
        }

        // OSX/Linux
        if (function_exists('openssl_random_pseudo_bytes') === true) {
            $data = openssl_random_pseudo_bytes(16);
            $data[6] = chr(ord($data[6]) & 0x0f | 0x40);    // set version to 0100
            $data[8] = chr(ord($data[8]) & 0x3f | 0x80);    // set bits 6-7 to 10
            return vsprintf('%s%s-%s-%s-%s-%s%s%s', str_split(bin2hex($data), 4));
        }

        // Fallback (PHP 4.2+)
        mt_srand((float)microtime() * 10000);
        $charid = strtolower(md5(uniqid(rand(), true)));
        $hyphen = chr(45);                  // "-"
        $lbrace = $trim ? "" : chr(123);    // "{"
        $rbrace = $trim ? "" : chr(125);    // "}"
        $guidv4 = $lbrace .
            substr($charid,  0,  8) . $hyphen .
            substr($charid,  8,  4) . $hyphen .
            substr($charid, 12,  4) . $hyphen .
            substr($charid, 16,  4) . $hyphen .
            substr($charid, 20, 12) .
            $rbrace;
        return $guidv4;
    }

    public static function getDropdownFriendlyValues($collection)
    {
        $data = [];
        if ($collection->count()) {
            foreach ($collection as $c) $data[$c->id] = $c->name;
        }
        return $data;
    }

    public static function UploadFile($file, $dir='', $user_id, $custom_name = "")
    {
        //dd($file);
        try {
            $f = new stdClass();
            $f->name = $file->getClientOriginalName();
            $f->mimetype = $file->getClientMimeType();
            $f->extension = $file->getClientOriginalExtension();
            $f->user_id = $user_id;
            $filename = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
            if ($custom_name != "") {
                $filename = pathinfo($custom_name, PATHINFO_FILENAME);
                $f->name = $custom_name;
            }

            $temp_name = str_replace(' ', '-', $filename) . '-' . date('YmdHis');
            $temp_name = self::Slug($temp_name);
            $f->url = $temp_name . '.' . $f->extension;



            $upload_success = $file->move(self::$file_path.$dir, $f->url);
            if ($upload_success) {
                $f->file_url = self::$file_path.$dir.'/'.$f->url;
                $Intervention_img = new ImageManager(); //make an instance of the Image manager Class
                //dd(self::$file_path.$dir.'/'.$f->url);
                $img = $Intervention_img->make(self::$file_path.$dir.'/'.$f->url);//re-create the image using the Image manager object
                $img->resize(250, null, function ($constraint){
					$constraint->aspectRatio();
				})->save(self::$file_path.$dir.'//thumbnails/'.$f->url); //resize and save the thumbnail
                //$f->save();
                return $f;
            }
            return null;
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public static function WriteOnFile($data, $name = "")
    {
        if($data != "") {
            try{
                if($name == '') {
                    $name = 'newFile'. '-' . date('YmdHis');
                }
                $file = self::$file_path.$name;
                return file_put_contents($file, $data);
            } catch (\Throwable $th) {
                throw $th;
            }
        }else{
            return false;
        }
    }

    public static function Slug($string)
    {
        return strtolower(trim(preg_replace('~[^0-9a-z]+~i', '-', html_entity_decode(preg_replace('~&([a-z]{1,2})(?:acute|cedil|circ|grave|lig|orn|ring|slash|th|tilde|uml);~i', '$1', htmlentities($string, ENT_QUOTES, 'UTF-8')), ENT_QUOTES, 'UTF-8')), '-'));
    }
}
