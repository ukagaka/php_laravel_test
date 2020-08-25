<?php

require_once 'gameInstall.php';

spl_autoload('userServer');//这里因为没有使用composer自动加载类，所以，这里需要使用该方法进行实例化。因为，走递归调用的时候，还会实例化他，所以，使用该方法。

class ddz implements gameInstall
{
    protected  $userServer = [];

    public function __construct(userServer $userServer)
    {
        $this->userServer = $userServer;
    }

    public function join($roomId, $userId)
    {
        $userInfo = $this->userServer->getUserInfo();
        $userInfo['room_id'] = $roomId;
        return $userInfo;
    }

    public function master()
    {

    }
}