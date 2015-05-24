<?php
/**
 * Created by PhpStorm.
 * User: unreacheble
 * Date: 15.24.5
 * Time: 13:44
 */

namespace FileTransfer;


interface ProtocolInterface {
    public function getHost();
    public function getLogin();
    public function getPassword();
    public function getPort();
}