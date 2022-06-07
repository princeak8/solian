<?php

namespace App\Services;

use DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Http;
//use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Auth;

use App\Helpers\Helper;

use App\Models\Message;

class MessageService
{

    public function save($data)
    {
        return Message::create($data);
    }

    public function messages()
    {
        return Message::all();
    }

    public function unreadMessages()
    {
        return Message::where('read', '0')->get();
    }

    public function readMessages()
    {
        return Message::where('read', '1')->get();
    }

    public function markAsRead($message)
    {
        $message->read = 1;
        $message->update();
    }
    
}

?>