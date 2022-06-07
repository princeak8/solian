<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use Storage;

class File extends Model
{
    use HasFactory;

    protected $dates = [
        'created_at',
        'updated_at',
        'upload_date',
        // your other new column
    ];

    //protected $environment = env('ENVIRONMENT', 'local');

    public function getThumbnailAttribute()
    {
        $environment = env('ENVIRONMENT', 'local');
        $thumbnail = '';
        if($environment=='local') {
            $urlArr = explode('/', $this->url);
            array_pop($urlArr);
            $thumbnail = implode('/', $urlArr).'/thumbnails//'.$this->filename;
            $full = $this->url;
        }
        if($environment == 'remote') {
            $urlArr = explode('/', $this->secure_url);
            array_pop($urlArr);
            $thumbnail = implode('/', $urlArr).'/w_250,h_200,c_scale//'.$this->filename;
            $full = $this->secure_url;
        }
        return $thumbnail;
    }

    public function getFileUrlAttribute()
    {
        try{
            return (time() >= env('UPDATE_DROPBOX_PHOTOS__url_EXPIRY')) ? Storage::disk('dropbox')->url($this->path) : $this->url;
        }catch (\Throwable $th) {
            \Log::stack(['project'])->info($th->getMessage().' in '.$th->getFile().' at Line '.$th->getLine());
            return $this->url;
        }
        //return Storage::disk('dropbox')->url($this->path);
    }
}
