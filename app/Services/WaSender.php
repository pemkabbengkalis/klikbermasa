<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

 class WaSender
{
    function __construct(protected array $arr)
    {
            if(!is_array($arr)){
            return;
           }
           $phone = isset($this->arr['number']) ? convertToInternational($this->arr['number']) : null;
           $message = isset($this->arr['message']) ? strip_tags($this->$arr['message']) : null;

           if($phone && $message){
                $response = \Illuminate\Support\Facades\Http::get(config('app.api_whatsapp'), [
                    'session' => config('app.whatsapp_session'),
                    'to' => $phone,
                    'text' => $message,
                ]);
                if($response->status()=='200'){
                    return $response->json();
                }
           }
    }
}
