<?php

class MinecraftAPI
{
    protected $username;
    protected $sessionID;

    public function __construct($username = null,$password = null)
    {
        if($username !== null && $password !== null) $this->login($username,$password);
    }

    public function login($username,$password,$version = 13)
    {
        $user = urlencode($username);
        $pass = urlencode($password);

        $output = file_get_contents("https://login.minecraft.net/?user={$user}&password={$pass}&version={$version}");

        if(strpos($output, 'Bad login') !== false) throw new MinecraftBadLoginException();
        if(strpos($output, 'Account migrated') !== false) throw new MinecraftMigrationException();
        if(strpos($output, 'not premium') !== false) throw new MinecraftBasicException();

        $values = explode(":",$output);

        $this->username = $values[2];
        $this->sessionID = $values[3];

        return true;
    }

    public function __get($var)
    {
        if($var == 'username') return $this->username;
        if($var == 'sessionID') return $this->sessionID;
        return;
    }
}
class MinecraftBadLoginException extends Exception
{
    public function __construct($message = "Bad Login") {
        parent::__construct($message);
    }
}
class MinecraftMigrationException extends Exception
{
    public function __construct($message = "Migrated Account") {
        parent::__construct($message);
    }
}
class MinecraftBasicException extends Exception
{
    public function __construct($message = "User not premium") {
        parent::__construct($message);
    }
}
