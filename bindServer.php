<?php

require 'app.php';
require 'game.php';

class bindServer
{

    protected  static $gameInstallName = 'game';

    public static function app($gameName)
    {
        //通过容器先绑定为game方法。用来做统一管理
        self::bind(self::$gameInstallName); //此处在项目时就应该绑定好了，并赋值给了全局变量，其它情况临时绑定的需要在添加给全局变量内
        $server =  self::make(self::$gameInstallName); //这里在获取的时候，直接获取到全局变量里的类事例
        //有了绑定的类以后，可以通过绑定的类，实例化要使用的类，这里是为了开始自动注册依赖，以及加载对应的文件
        $gameClass = $server->build($gameName);
        return $gameClass;
    }

    public static function bind($name)
    {
        //绑定一个实例
        app::bind($name, function(){
            return new game();
        });
    }

    public static function make($name)
    {
        //输出一个绑定的实例
        $class =  app::make($name);
        return $class;
    }

}