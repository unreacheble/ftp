<?php
/**
 * Created by PhpStorm.
 * User: unreacheble
 * Date: 15.23.5
 * Time: 15:10
 */
namespace FileTransfer;

class Ssh extends ProtocolAbstract{

    private $sftp;
    private $_ssh2;
    private $currentDir;


    public function __construct($host,$login = 'anonymous',$pass = '',$port = 22, $passiveMode = true){
        if (!extension_loaded('ssh2')) {
            throw new \Exception("PHP extension \"ssh2\" is not loaded.\n");
        }
        $this->setLogin($login);
        $this->setPassword($pass);
        $this->setHost($host);

        try{
            $this->_ssh2 = ssh2_connect($host,$port);
        }catch (\Exception $e){
            throw $e;
        }

        if(ssh2_auth_password($this->_ssh2,$this->getLogin(),$this->getPassword())){
            echo "Login success.\n";
            $this->sftp = ssh2_sftp($this->_ssh2);
        }else{
            throw new \Exception("Access denied to {$this->getHost()} to user {$this->getUser()}\n");
        }

        if(!$this->sftp){
            throw new Exception("Could not initialize SFTP subsystem.");
        }

        $this->currentDir = "/";
    }

    public function cd($dir)
    {
        if( !is_dir("ssh2.sftp://{$this->sftp}{$dir}") ){
            throw new \Exception("Directory {$dir} not found on server.\n");
        }
        if(substr($dir,(strlen($dir)-1), 1) != '/'){
            $dir .= "/";
        }
        $this->currentDir = $dir;
        return $this;
    }

    public function download($fileName, $localFileName = false)
    {
        if($localFileName === false) {
            $localFileName = $fileName;
        }
        if(!preg_match("/\/[\/\w.]+/", $fileName)){
            $fileName = $this->currentDir . $fileName;
        }
        if( !is_file("ssh2.sftp://{$this->sftp}{$fileName}") ){
            throw new \Exception("Can't find {$fileName} on remote server.\n");
        }
        $stream = fopen("ssh2.sftp://{$this->sftp}{$fileName}", 'r');
        if(is_file($localFileName)){
            file_put_contents($localFileName, '');
        }else{
            file_put_contents($localFileName,'');
        }
        $fileSize = filesize("ssh2.sftp://{$this->sftp}{$fileName}");
        if($fileSize != 0){
            echo "Reciving {$fileSize} bytes of {$fileName}\n";
            $contents = fread($stream, filesize("ssh2.sftp://{$this->sftp}{$fileName}"));
            $received =  file_put_contents ($localFileName, $contents);
            echo "Writed {$received} bytes to {$localFileName}\n";
        }
        fclose($stream);
        return $this;
    }

    public function close()
    {
        ssh2_exec($this->_ssh2, 'exit');
    }

}