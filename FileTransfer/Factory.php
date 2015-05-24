<?php
/**
 * Created by PhpStorm.
 * User: unreacheble
 * Date: 15.24.5
 * Time: 01:31
 */

namespace FileTransfer;


class Factory {

    private $connection;

    public function getConnection($type, $login, $password, $host, $port = 21)
    {
      /*
       *  Порт по умолчанию ФТП, на самом деле я бы так не сделал, но этот костыль нужен что б подогнать фабрику под Ваш код
       *  Можно конечно выкидывать Exception ели нет порта, но в таком случае, как мне кажется, проще оставить это поле обязательным. Но в этом случае не будет работать Ваш код
       *
       */
        $className = "\\FileTransfer\\" . ucfirst($type);
        if(!class_exists($className)){
            throw new \Exception("Unknown protocol.\n");
        }
        // Код немного напоминает корявенький "недоснглтон")) полезной эта проверка будет если соединение которое пытаемся получить уже открыто.
        if( $this->connection instanceof $className &&
            $this->connection->getLogin() == $login &&
            $this->connection->getPassword() == $password &&
            $this->connection->getHost() == $host &&
            $this->connection->getPort() == $port
        ){
                return $this->connection;
        }else{
            return $this->connection = new $className($host, $login, $password, $port);
        }
    }
} 