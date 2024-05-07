<?php
       include_once 'connect.php';
       include_once 'util.php';
      // include_once 'user.php';
       
       //receive data from the gateway 
       $phoneNumber = $_POST['from'];
       $text = $_POST['text']; //name pin; John 1234

       $text = explode(" ", $text);
       $user->setName($text[0]);
       $user->setPin($text[1]);
       //$user->setBalance(Util::$USER_BALANCE);

       $user->register($pdo);

      
?>