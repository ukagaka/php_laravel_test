<?php

class game
{

    public $gameName = '';

    public function __construct()
    {
    }

    public function build($className)
    {
        $this->autoload($className);

        //此处为了实现自动依赖注入，而实现了自动注入的方法。如果是有namespace的，在获取类的时候，还要识别出对应的namespace
        $reflect = new ReflectionClass($className);
        //事例是否可以实例化
        if (!$reflect->isInstantiable()) {
            throw new Exception('cannot be instantiated!');
        }

        //获取类的构造函数，那么就返回constructor对象，进行后续操作
        $constructor = $reflect->getConstructor();
        if (is_null($constructor)) {
            //如果没有构造函数，说明不需要自动注入类，则直接输出
            return new $className;
        }

        //判断下构造函数是否有需要注入的类
        $params = $constructor->getParameters();
        $dependencies = $this->getDependencies($params);
        //从给出的参数里实例化类
        return $reflect->newInstanceArgs($dependencies);

    }

    private function getDependencies($params)
    {
        $dependenies = [];
        foreach ($params as $param) {
            //获取要自动加载类的名字，因为没有实现composer这种自动加载，所以在引入对应类的时候，需要自动加载下
            $dependency = $param->getClass();
            if (is_null($dependency)) {
                $dependenies[] = $this->resolveNonClass($param);
            } else {
                //递归调用该方法，是为了实例的类里面再有嵌套的类需要实例化
                $dependenies[] = $this->build($dependency->name);
            }
        }
        return $dependenies;
    }

    private function resolveNonClass($param)
    {
        //判断下是否有默认值，如果有默认值，输出默认值。没有，则需要传递值
        if($param->isDefaultValueAvailable()) {
            return $param->getDefaultValue();
        }
        throw new Exception('no deault value');
    }

    private function autoload($class)
    {
        //因为没有实现composer的自动加载，所以这里暂时直接实例化
        spl_autoload($class);
    }



}