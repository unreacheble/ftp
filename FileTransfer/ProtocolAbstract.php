<?php
/**
 * Created by PhpStorm.
 * User: unreacheble
 * Date: 15.24.5
 * Time: 13:45
 */

namespace FileTransfer;


abstract class ProtocolAbstract implements ProtocolInterface{


    private $login;
    private $password;
    private $host;
    private $port;

    /**
     * @param mixed $host
     */
    public function setHost($host)
    {
        $this->host = $host;
    }

    /**
     * @param mixed $login
     */
    public function setLogin($login)
    {
        $this->login = $login;
    }

    /**
     * @param mixed $password
     */
    public function setPassword($password)
    {
        $this->password = $password;
    }

    /**
     * @param mixed $port
     */
    public function setPort($port)
    {
        $this->port = $port;
    }

    /**
     * @return mixed
     */
    public function getHost()
    {
        return $this->host;
    }

    /**
     * @return string
     */
    public function getLogin()
    {
        return $this->login;
    }

    /**
     * @return string
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * @return mixed
     */
    public function getPort()
    {
        return $this->port;
    }

} 