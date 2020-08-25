<?php

require 'bindServer.php';

class server
{
    const GAME_NAME = 'ddz';
    //想法：添加新游戏的时候，直接添加游戏文件，并且这些新加的游戏文件实现固定的一些方法。相当于一个游戏一个类。
    //使用方法：自动加载、依赖注入、容器绑定

    public function joinRoom($roomId, $userId)
    {
        $server = bindServer::app(self::GAME_NAME);
        $data = $server->join($roomId, $userId);
        var_dump($data);

    }
}

$server = new server();
$server->joinRoom(123, 321);