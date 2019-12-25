<?php

namespace App\Services;

use WeSender\WeSenderSDK;

class WeSenderService{

    public function make($destines, $message, $specialChars)
    {
        $wesender = new WeSenderSDK(config('wesender.api_key'));

        try {
            $wesender->sendMessage($destines, $message);
        } catch (\Throwable $th) {
            throw $th;
        }

        return $wesender;
    }
}
