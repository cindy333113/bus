<?php
/**
 * 這是一個實做單例模式的 Facade
 *
 * @author Shisha 2019-10-27
 * @license MIT
 */

use Session\Accessor;

class Session
{
    
    /**
     * 這是一個實做單例模式的本體 (static)
     * 
     * @var \Database\Accessor;
     */
    private static $instance;
    
    /**
     * 將建構子設為 private，避免被一般的 new 方式建構物件。
     */
    private function __construct()
    {
        // ...
    }
    
    /**
     * 取得實例(instance)
     * 
     * @return \DB
     */
    public static function getInstance()
    {
        $classname = static::getStaticName();
        if (! static::$instance instanceof $classname) {
            return static::$instance = new $classname;
        }
        
        return static::$instance;
    }
    
    /**
     * 取得要包裝的類別名稱
     * 
     * @return string
     */
    public static function getStaticName()
    {
        return Accessor::class;
    }
    
    /**
     * 處理動態的靜態方法 (static method) 呼叫。
     *
     * @param  string  $method
     * @param  array  $parameters
     * @return mixed
     */
    public static function __callStatic($method, $parameters)
    {
        return static::getInstance()->$method(...$parameters);
    }
}