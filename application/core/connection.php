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

        $is_data_not_null = $this->get_data($items);

        if($is_data_not_null){
            $items = $items;
        }
        else{
            $items['error'] = 'bed request, or data not found';
        }
        
        return $items;
    }

    public function get_data($query_result)
    {
        $result = false;
        foreach ($query_result as $arr) {
            foreach ($arr as $item) {
                if(isset($item['num_rows']) && $item['num_rows'] == 0){
                    $result = false;
                }
                else {
                    $result = true;
                }
            }
        }
        return $result;
    }
}
