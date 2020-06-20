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
     * @var array
     */
    protected $config = [
        'authTable' => 'passenger',
        'idField' => 'passenger_id',
        'accountField' => 'passenger_account',
        'passwordField' => 'passenger_password',
    ];

    /**
     * @param  array  $config
     */
    public function config(array $config)
    {
        $this->config = array_merge($this->config, $config);
    }

    /**
     * @param string $identity
     */
    public function configByIdentify(string $identity)
    {
        $table = $identity;
        $this->config([
            'authTable' => $table,
            'idField' => "{$table}_id",
            'accountField' => "{$table}_account",
            'passwordField' => "{$table}_password",
        ]);
    }

    /**
     * 認證使用者身份別
     * 
     * @param array $auth
     * @param string $authIdentity
     * 
     */
    public function authenticate(array $auth, string $authIdentity)
    {
        $authenticate = FALSE;

        //驗證是否有 $auth 資訊
        if ($auth && $auth['identity'] === $authIdentity) {
            $id = $auth['id'];
            $identity = $auth['identity'];

            $this->configByIdentify($identity);
            $table = $this->config['authTable'];
            $user = DB::find($table, $id);

            //確認 $auth 資訊
            if ($user) return $user;

        }

        return $authenticate;

    }

    /**
     * 使用者登入
     * 
     * @param string $account
     * @param string $password
     */
    public function login(string $account, string $password, string $identity)
    {
        $this->configByIdentify($identity);

        $table = $this->config['authTable'];
        $idField = $this->config['idField'];
        $accountField = $this->config['accountField'];
        $passwordField = $this->config['passwordField'];

        $user = DB::find($table, $account, $accountField);

        if ($user && $user[$passwordField] === $password) {
            return $user[$idField];
        }

        return FALSE;

    }

}
