<?php

class Model_Accounts extends Model
{
    private $connection;
    private $client_id;
    private $client_secret;

    function __construct()
    {
        $this->connection = new Connection();
        $this->client_id = 1902941346633894;
        $this->client_secret = "ee596b339edc552dfefed7fe99de5659";
    }

    public function get_user_by_data($email, $password)
    {
        $link = $this->connection->get_connection();
        $query = "SELECT * FROM accounts WHERE email='$email' AND password='$password'";
        $result[] = $this->connection->get_result($link, $query);
        return $result;
    }

    public function logout()
    {

    }

    public function create_new_user($email, $password)
    {
        $link = $this->connection->get_connection();
        $query = "INSERT INTO accounts (`email`,`password`) VALUES('$email', '$password')";
        $result[] = $this->connection->get_result($link, $query);
        return $result;
    }

    public function faceboock_auth($email)
    {
        $link = $this->connection->get_connection();
        $query = "SELECT * FROM accounts  WHERE email ='$email'";
        $result[] = $this->connection->get_result($link, $query);
        $is_user_creating =  $this->is_user_creating($email, $result);
        if($is_user_creating) {
            $result = $this->get_user_data($result);
        }
        else {
            $result = $this->create_new_user_auth($email);
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

    public function create_new_user_auth($email)
    {
        $link = $this->connection->get_connection();
        $query = "INSERT INTO accounts  (`email`,`authorization_type`) VALUES('$email', 'facebook')";
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