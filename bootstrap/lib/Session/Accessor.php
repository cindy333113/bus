<?php

/**
 * 這是一個被包裝的範例
 *
 * @author Shisha 2019-10-27
 * @license MIT
 */

namespace Session;

use Slim\App;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

class Accessor
{

    /**
     * @var array
     */
    protected $data = [];

    /**
     * 獲取 session 內容
     * 
     * @param  string $key
     * @return mixed 
     */
    public function get(string $key)
    {

        if ($this->isExist($key)) {
            return $this->data[$key];
        }

        return FALSE;
    }

    /**
     * 儲存項目到 Session 中
     * 
     * @param  string $url
     * 
     */
    public function put(string $key, $value)
    {
        $this->data[$key] = $value;
    }

    /**
     * 儲存項目進 Session 陣列值中
     * 
     * @param  string $key
     * @param  array $data
     * 
     */
    public function push(string $key, $value)
    {
        $arrayName = explode(".",$key)[0];

        if($this->isExist($arrayName)){
            $keyName = explode(".",$key)[1];
            $this->data[$arrayName][$keyName] = $value;
        }
        
    }

    /**
     * 檢查 $data['key'] 是否存在
     * 
     * @param  string $key
     * @return boolean
     */
    public function isExist(string $key)
    {
        if (!in_array($key, $this->data)) {
            return TRUE;
        }

        return FALSE;
    }
}
