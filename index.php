<?php
/**
 * Created by PhpStorm.
 * User: unreacheble
 * Date: 15.23.5
 * Time: 13:33
 */

//include 'file_transfer_lib.php';            ---------заменил на __autoload()
function __autoload($className) {
    $parts = explode('\\', $className);
    $className = implode('/',$parts);
    if(is_file($className . '.php')){
        include $className . '.php';
    }else{
        throw new Exception("Cant find {$className}");
    }
}
use FileTransfer as FT;
$factory = new FT\Factory();

try{
    $conn = $factory->getConnection('ssh', 'user', 'pass', 'hostname.com', 2222);
    $conn->cd('/var/www')
        ->download('dump.tar.gz')
        ->close();
}catch(Exception $e){
    echo $e->getMessage();
}

try{
    $conn = $factory->getConnection('ftp', 'user', 'pass', 'hostname.com');
//    echo $conn->pwd() . "\n"; // Закомментировал т.к. не совем понятно назначение этого метода. Геттер пароля? Имя текущей папки?
    $conn->upload('archive.zip');
    print_r($conn->exec('ls -al'));
}catch (Exception $e){
    echo $e->getMessage();
}