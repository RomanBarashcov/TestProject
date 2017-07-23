<?php

class Model_Accounts extends Model
{
    private $connection;

    function __construct()
    {
        $this->connection = new Connection();
    }

    public function get_user_by_data($email, $password)
    {
        $link = $this->connection->get_connection();
        $query = "SELECT * FROM accounts WHERE email='$email' AND password='$password'";
        $result[] = $this->connection->get_result($link, $query);
        if(!isset($result[0]['error'])){
            $result = $this->get_user_data($result);
        }
        return $result;
    }

    public function registration($email, $password)
    {
        $link = $this->connection->get_connection();
        $query = "SELECT * FROM accounts  WHERE email ='$email'";
        $result[] = $this->connection->get_result($link, $query);
        $is_user_creating = $this->is_user_creating($email, $result);
        if($is_user_creating) {
            $result["error_registration"] = "Пользователь с таким Email уже зарегистрирован.";
        }
        else {
            $new_user_result = $this->create_new_user($email, $password, 'registration');
            $result = $this->get_user_data($new_user_result);
        }
        return $result;
    }

    public function facebook_auth($email)
    {
        $link = $this->connection->get_connection();
        $query = "SELECT * FROM accounts  WHERE email ='$email'";
        $result[] = $this->connection->get_result($link, $query);
        $is_user_creating =  $this->is_user_creating($email, $result);
        if($is_user_creating) {
            $result = $this->get_user_data($result);
        }
        else {
            $result = $this->create_new_user($email, null, 'facebook');
            $result = $this->get_user_data($result);
        }
        return $result;
    }

    public function is_user_creating($email, $query_result)
    {
        $result = false;
        foreach ($query_result as $arr) {
            foreach ($arr as $key => $item) {
                if($email == $item['email']){
                    $result = true;
                }
                else{
                    $result = false;
                }
            }
        }
        return $result;
    }

    public function create_new_user($email, $password, $auth_type)
    {
        $link = $this->connection->get_connection();
        $query = "INSERT INTO accounts  (`email`,`password`,`authorization_type`) VALUES('$email','$password', '$auth_type')";
        $result[] = $this->connection->get_result($link, $query);
        return $result;
    }

    public function get_user_data($query_result)
    {
        $result = null;
        foreach ($query_result as $arr) {
            foreach ($arr as $item) {
                if(isset($item['email'])){
                    $result = array(
                        "email" => $item['email'],
                        "current_user_id" => $item['id']
                    );
                }
                else {
                    $result = null;
                }
            }
        }
        return $result;
    }
}