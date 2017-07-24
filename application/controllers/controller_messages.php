<?php

class Controller_Messages extends Controller
{

    function __construct()
    {
        $this->model = new Model_Messages();
        $this->view = new View();
    }

    function action_index()
    {
        $data = $this->model->get_data();
        session_start();
        if(isset($_SESSION['user_data']['current_user_id']))
        {
            $user_id = $_SESSION['user_data']['current_user_id'];
            $data['current_user'] = array("user_id" => $user_id);
        }
        else{
            session_destroy();
        }
        $this->view->generate('messages_view.php', 'template_view.php', $data);
    }
    
    function action_create($msg, $author_id)
    {
        $this->model->create_message($msg, $author_id);
    }

    function action_update_msg($up_msg, $msg_id)
    {
       $this->model->update_message($up_msg, $msg_id);
    }

    function action_remove_msg($rem_msg)
    {
        $this->model->remove_message($rem_msg);
    }

    function action_create_comment($new_comment, $parent_id, $msg_id, $author_id)
    {
        $this->model->create_comments($new_comment, $parent_id, $msg_id , $author_id);
    }

    function action_update_comment($up_comment, $comment_id, $parent_id)
    {
        $this->model->update_comment($up_comment, $comment_id, $parent_id);
    }

    function action_remove_comment($rem_comment_id)
    {
         $this->model->remove_comment($rem_comment_id);
    }
}