<?php

require_once 'DB.php';

class ApiEngine extends DB
{
    private $domain;
    private $login;
    private $password;
    private $repeatPassword;
    private $rememberMe;
    private $userKey;

    public function signIn()
    {
        $this->prepareData();

        if($this->rememberMe) {
            setcookie('rememberMe', $this->userKey, time()+172800);
        }
    }

    public function signUp()
    {
        $data = $this->prepareData();

        if($this->rememberMe) {
            setcookie('rememberMe', $this->userKey, time()+172800);
        }

        $this->connect();
        $this->sendToDB($data);
    }

    protected function prepareData()
    {
        $encryptPassword = $this->encryption($this->password, PASSWORD_DEFAULT);
        $key = $this->encryption($this->domain, PASSWORD_DEFAULT);
        $this->keyUser = $key;
        $data = [
            'domain' => $this->domain,
            'login' => $this->login,
            'password' => $encryptPassword,
            'key_user' => $key
        ];
        return $data;
    }

    public function setData($data)
    {
        $this->domain = $data['domain'];
        $this->login = $data['login'];
        $this->password = $data['password'];
        if (!empty($data['repeatPassword'])) {
            $this->repeatPassword = $data['repeatPassword'];
        }
        $this->rememberMe = $data['rememberMe'];
    }

    private function encryption($str, $method)
    {
        return password_hash($str, $method);
    }

    private function sendToDB($data)
    {
        $this->insert('users', $data);
    }

    public function checkUserByDomain()
    {
        $users = $this->getUsersByDomain();

        if(!empty($users)) {
            if(in_array($this->login, $users)) {
                return false;
            }
            if (array_search($this->login, $users) == 0) {
                return false;
            }
        }

        return true;
    }

    private function getUsersByDomain()
    {
        $this->connect();
        return $this->select('users', "`domain` = '$this->domain'");
    }

    public function checkAuth()
    {
        $users = $this->getUsersByDomain();

        foreach ($users as $user) {
            if (/*password_verify($this->password, $user['password']) &&*/ $user['login'] == $this->login && $user['domain'] == $this->domain) {
                return true;
            }
        }

    }

    public function getUserKey()
    {
        return $this->userKey;
    }

}