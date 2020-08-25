<?php

require 'gameInstall.php';

class xxl implements gameInstall
{
    public function __construct()
    {

    }

    public function join($roomId, $userId)
    {
        return [
            'game_name' => 'xxl',
            'room_id' => $roomId,
        ];
    }

    public function master()
    {


    }
}