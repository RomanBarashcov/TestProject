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
        $this->view->generate('accounts_login_view.php', 'template_view.php');
    }

    function action_login($user_email, $user_password)
    {
        $user_data = $this->model->get_user_by_data($user_email, $user_password);
        if(isset($user_data['error'])){
            $data['result'] = $user_data['error'];
            $this->view->generate('accounts_login_view.php', 'template_view.php', $data);
        }
        else{
            session_start();
            $_SESSION['user_data'] = $user_data;
        }
    }

    function action_facebook_auth($email)
    {
        $user_data = $this->model->facebook_auth($email);
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
        $this->view->generate('accounts_login_view.php', 'template_view.php');
    }

    function action_registration()
    {
        $this->view->generate('accounts_registration_view.php', 'template_view.php');
    }

    function action_save_new_user($user_email, $user_password)
    {
       $user_data = $this->model->registration($user_email, $user_password);
        if(isset($user_data["error_registration"])){
            $data['result'] = $user_data["error_registration"];
            $this->view->generate('accounts_registration_view.php', 'template_view.php', $data);
        }
        else{
             $data['result'] = $user_data['success'];
             session_start();
             $_SESSION['user_data'] = $user_data;
             $this->view->generate('accounts_registration_view.php', 'template_view.php', $data);
        }
    }
}