Тестовое задание на вакансию «Программист»

Напишите, пожалуйста, модуль  для передачи файлов по FTP/SFTP. Пример использования 

программы:

<?php

include 'file_transfer_lib.php';

use FileTransfer as FT;

$factory = new FT\Factory();

try

{

$conn = $factory->getConnection('ssh', 'user', 'pass', 'hostname.com', 2222);

$conn->cd('/var/www')

->download('dump.tar.gz')

->close();

}

catch(Exception $e)

{

echo $e->getMessage();

}

try

{

$conn = $factory->getConnection('ftp', 'user', 'pass', 'hostname.com');

echo $conn->pwd() . "\n";

$conn->upload('archive.zip');

print_r($conn->exec('ls -al'));

}

catch (Exception $e)

{

echo $e->getMessage();

}
