<?php

class Controller_Accounts extends Controller
{

    function __construct()
    {
        $this->model = new Model_Accounts();
        $this->view = new View();
    }

    function action_index()
    {
        $this->view->generate('accounts_view.php', 'template_view.php');
    }

    function action_login($user_email, $user_password)
    {
        $data = $this->model->get_user_by_data($user_email, $user_password);
        if($data != null){
            $_SESSION['user_email'] = "admin@admin.com";
        }

    }

    function action_facebook_auth($email)
    {
        $user_data = $this->model->faceboock_auth($email);
            if($user_data['email'] == $email){
                session_start();
                $_SESSION['user_data'] = $user_data;
            }
            else{
                session_destroy();
            }
    }

    function action_logout()
    {
        session_start();
        session_destroy();
        $this->view->generate('accounts_view.php', 'template_view.php');
    }

    function action_register($user_email, $user_password)
    {
        $data = $this->model->create_new_user($user_email, $user_password);
    }
}