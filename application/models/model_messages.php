<?php


class Model_Messages extends Model
{
    private $connection;

    function __construct()
    {
        $this->connection = new Connection();
    }

    public function get_data()
    {
        // conecting to MySql
        $link =  $this->connection->get_connection();
        //creating query
        $query_message = "SELECT * FROM messages";
        $query_comments = "SELECT * FROM comments";
        // Get db query result
        $result_message = $this->connection->get_result($link, $query_message);
        $result_comments = $this->connection->get_result($link, $query_comments);
        //send result data to controller
        return $new_arr = $this->get_tree_array_comments($result_message, $result_comments);
    }

    public function create_message($msg, $author_id)
    {
        $link = $this->connection->get_connection();
        $query = "INSERT INTO messages (`message`, `author`) VALUES('$msg', '$author_id');";
        $result[] = $this->connection->get_result($link, $query);
        return  $result;
    }

    public function update_message($up_msg, $msg_id)
    {
        $link = $this->connection->get_connection();
        $query = "UPDATE messages SET message = '$up_msg', WHERE id = '$msg_id'";
        $result[] = $this->connection->get_result($link, $query);
        return true;
    }

    public function remove_message($rem_msg_id)
    {
        $result = $this->remove_children_comments($rem_msg_id);
        if($result)
        {
            $link = $this->connection->get_connection();
            $query = "DELETE FROM messages WHERE id = '$rem_msg_id'";
            $result[] = $this->connection->get_result($link, $query);
        }
        return $result;
    }

    private function remove_children_comments($rem_msg_id)
    {
        $link = $this->connection->get_connection();
        $query = "DELETE FROM comments WHERE messages_id = '$rem_msg_id'";
        $result[] = $this->connection->get_result($link, $query);
        return $result;
    }

    public function create_comments($new_comment, $parent_id, $msg_id, $author_id)
    {
        $link = $this->connection->get_connection();
        $query = "INSERT INTO comments (`comment`,`parent_id`,`messages_id`, `author`) VALUES('$new_comment', '$parent_id', '$msg_id', '$author_id')";
        $result[] = $this->connection->get_result($link, $query);
        return $result;
    }

    public function update_comment($up_comment, $comment_id, $parent_id)
    {
        $link = $this->connection->get_connection();
        $query = "UPDATE comments SET comment = '$up_comment', parent_id = '$parent_id' WHERE id = '$comment_id'";
        $result[] = $this->connection->get_result($link, $query);
        return $result;
    }

    public function remove_comment($rem_comment_id)
    {
        $link = $this->connection->get_connection();
        $query = "DELETE FROM comments WHERE id = '$rem_comment_id'";
        $result[] = $this->connection->get_result($link, $query);
        return $result;
    }

    function get_tree_array_comments($result_message, $result_comments)
    {
        $parents = array();
        $children = array();
        $new_arr =  array();

        for($p = 0; $p < count($result_message); $p++)
        {
            $parents[] = $result_message[$p];
        }
        for ($c = 0; $c < count($result_comments); $c++)
        {
            $children[] = $result_comments[$c];
        }

        $new_arr = array("parents" => $parents,
            "childrens" => $children);

        return  $new_arr;
    }
}
