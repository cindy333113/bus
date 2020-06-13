<?php

/**
 * 這是一個被包裝的範例
 *
 * @author Shisha 2019-10-27
 * @license MIT
 */

namespace Authenticate;

use DB;

class Accessor
{
    /**
     * @var boolean
     */
    private $authenticate;

    /**
     * @var array
     */
    protected $config = [
        'authTable' => 'PASSENGER',
        'idField' => 'PASSENGER_ID',
        'accountField' => 'PASSENGER_ACCOUNT',
        'passwordField' => 'PASSENGER_PASSWORD',
    ];

    /**
     * @param  array  $config
     */
    public function config(array $config)
    {
        $this->config = array_merge($this->config, $config);
    }

    /**
     * 認證使用者
     * 
     * @param string $account
     * @param string $password
     */
    public function authenticate(string $id)
    {
        $table = $this->config['authTable'];

        $user = DB::find($table, $id);

        if (!$user) {
            return $this->authenticate = FALSE;
        }
        $this->authenticate = TRUE;

        return $user;
    }

    /**
     * 使用者登入
     * 
     * @param string $account
     * @param string $password
     */
    public function login(string $account, string $password)
    {
        $table = $this->config['authTable'];
        $accountField = $this->config['accountField'];
        $passwordField = $this->config['passwordField'];

        $user = DB::find($table, $account, $accountField);

        if ($user && $user[$passwordField] === $password) {
            $idField = $this->config['idField'];
            return $user[$idField];
        }

        return FALSE;
    }


    /**
     * 確認認證
     * 
     * @return Boolean
     * 
     */
    public function check()
    {
        return $this->authenticate;
    }

    /**
     * 重新設定認證
     * 
     */
    public function unset()
    {
        $this->authenticate = NULL;
    }
}
