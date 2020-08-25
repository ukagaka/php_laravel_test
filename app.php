<?php

class app
{
    protected static $bindings = [];

    public static function bind($name, Callable $resolver)
    {
        static::$bindings[$name] = $resolver;
        return $resolver;
    }

    public static function make($name)
    {
        if (isset(static::$bindings[$name])) {
            $resolver = static::$bindings[$name];
            return $resolver();
        }
        throw new Exception('no ioc');
    }


}