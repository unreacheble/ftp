<?php
/**
 * Created by PhpStorm.
 * User: unreacheble
 * Date: 15.23.5
 * Time: 15:10
 */
namespace FileTransfer;

class Ftp extends ProtocolAbstract{

    private $conn;

    public function __construct($host,$login = 'anonymous',$pass = '',$port = 21, $passiveMode = true){
        if (!extension_loaded('ftp')) {
            throw new \Exception("PHP extension FTP is not loaded.\n");
        }
        $this->setLogin($login);
        $this->setPassword($pass);
        $this->setHost($host);
        try{
            $this->conn = ftp_connect($host,$port);
        }catch (\Exception $e){
            throw $e;
        }
        if(ftp_login($this->conn,$this->getLogin(),$this->getPassword())){
            echo "Login success.\n";
            ftp_pasv($this->conn, $passiveMode);
        }else{
            throw new \Exception("Access denied to {$this->getHost()} to user {$this->getUser()}\n");
        }
    }

    public function __desctruct()
    {
        ftp_close($this->conn);
    }
    public function upload($localFile, $remoteFile = false)
    {
        if($remoteFile == false){
            $remoteFile = $localFile;
        }
        if(!is_file($localFile)){
            throw new \Exception("Can't find local\n");
        }
        if(ftp_put($this->conn, $remoteFile, $localFile, FTP_BINARY)){
            echo "{$localFile} uploaded\n";
        }else{
            echo "Failed to upload {$localFile}\n";
        }
    }

    public function exec($cmd)
    {
        $siteCommands = ftp_raw($this->conn, 'SITE HELP');
        if(is_array($siteCommands) && in_array(' EXEC',$siteCommands)){
            return ftp_raw($this->conn, "SITE EXEC " . $cmd);
        }else{
            /*
             *  По хорошему тут нужно написать кучу парсингов принимаемой комманды
             *  Парсить принимаемую комманду, и выполнять необходимые действия при помощи ftp_raw()
             *  Но тогда нужно ТЗ по списку необходимых комманд :)
             */
            throw new \Exception("FTP server not support \"EXEC\" command\n");
        }
    }
}