<?php

class Connection
{
    private $host = 'localhost';
    private $database = 'TestDb';
    private $user = 'root';
    private $password = '';

   function get_connection()
   {
       $host = $this->host;
       $user = $this->user;
       $password = $this->password;
       $database = $this->database;

       $link = mysqli_connect($host, $user, $password, $database)
       or die("Ошибка " . mysqli_error($link));

       return $link;
   }

    function get_result($link, $query)
    {
       $result = mysqli_query($link, $query) or die("Ошибка " . mysqli_error($link));

        $items = array();
        //Пока есть строки в ресурсе
        while ($data = mysqli_fetch_assoc($result)){
            //Дописываем данные в массив
            $items[] = $data;
        }
        return $items;
    }
}
