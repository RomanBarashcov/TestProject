<h1>Сообщения</h1>
<?php  if(isset($data['current_user']['user_id'])){ ?>
         <input id="currentUserId" type="hidden"  value="<?=$data['current_user']['user_id']?>">
<?php } ?>

<div class="message-form">
    <div class="form-group">
        <form id="send-form"  method="post">
            <textarea name="msg" id="msg" class="form-control" rows="5" required="required" placeholder="Новое сообщение"></textarea>
            <br>
            <input onclick="javascript:createMessage()" type="submit" class="btn btn-success" value="Отправить">
        </form>
    </div>
</div>
<div class="login-form">
    <div class="auth-with-social-networks">
        <fb:login-button scope="public_profile,email" autologoutlink="true" onlogin="checkLoginState();"></fb:login-button>
    </div>
    <div class="text-center">
        <p class="message-for-user">“Для добавления и комментирования сообщений выполните <a href="/">вход</a>”</p>
    </div>
</div>

<?php
    for($m = 0, $mes = count($data['parents']); $m < $mes; $m++)
    {
        echo '<div class="comments-block">
                <input type="hidden" id="hiddenMsgId'.$m.'" value="'.$data['parents'][$m]['id'].'">
                <div class="messages-area">
                    Date Created : '.$data['parents'][$m]['date_created'].' '.$data['parents'][$m]['message'].'
                </div>
              <ul>
                <li class="link-area">
                     <a id="createCommentMessage" href="javascript:createCommentMessage('.$m.')" class="link-success basic-function-for-user">Комментировать</a>';
                    if(isset($data['current_user']['user_id']))
                    {
                        if($data['current_user']['user_id'] == $data['parents'][$m]['author'])
                        {
                            echo '<a href="javascript:updateMessage('.$m.')" class="link-warning basic-function-for-user">Редактировать</a>
                           <a href="javascript:removeMessage('.$m.')" class="link-danger basic-function-for-user">Удалить</a>';
                        }
                    }
               echo  '</li>
                 <li id="messageTextBoxArea'.$m.'"></li>';

        for($c = 0, $com = count($data['childrens']); $c < $com; $c++)
        {
            if($data['childrens'][$c]['parent_id'] == 0 && $data['parents'][$m]['id'] == $data['childrens'][$c]['messages_id'])
            {
                echo '<li class="list-group-item">
                            <input type="hidden" id="hiddenCommentId'.$c.'"  value="'.$data['childrens'][$c]['id'].'">
                            <input type="hidden" id="hiddenCommentParentId'.$c.'"  value="'.$data['childrens'][$c]['parent_id'].'">
                            <input type="hidden" id="hiddenMessageKeyId'.$c.'" value="'.$data['childrens'][$c]['messages_id'].'">
                         <div style="margin-left:20px">'.$data['childrens'][$c]['comment'].'
                              <div class="link-area">
                                 <a id="createComment" href="javascript:createComment('.$c.')" class="link-success basic-function-for-user">Комментировать</a>';
                                if(isset($data['current_user']['user_id']))
                                {
                                    if ($data['current_user']['user_id'] == $data['childrens'][$c]['author'])
                                    {
                                        echo '<a href="javascript:updateComment(' . $c . ')" class="link-warning basic-function-for-user">Редактировать</a>
                                                          <a href="javascript:removeComment(' . $c . ')" class="link-danger basic-function-for-user">Удалить</a>';
                                    }
                                }
                            echo '</div>
                         </div>
                      <div id="commentTextBoxArea'.$c.'"></div>
                      </li>';
            }
            if($data['childrens'][$c]['parent_id'] > 0 && $data['parents'][$m]['id'] == $data['childrens'][$c]['messages_id'])
            {
                echo '<li class="list-group-item">
                            <input type="hidden" id="hiddenCommentId'.$c.'"  value="'.$data['childrens'][$c]['id'].'">
                            <input type="hidden" id="hiddenCommentParentId'.$c.'" value="'.$data['childrens'][$c]['parent_id'].'">
                            <input type="hidden" id="hiddenMessageKeyId'.$c.'" value="'.$data['childrens'][$c]['messages_id'].'">
                        <div style="margin-left:60px">'.$data['childrens'][$c]['comment'].'
                           <div class="link-area">
                                 <a id="createComment" href="javascript:createComment('.$c.')" class="link-success basic-function-for-user">Комментировать</a>';
                                if(isset($data['current_user']['user_id']))
                                {
                                    if ($data['current_user']['user_id'] == $data['childrens'][$c]['author'])
                                    {
                                        echo '<a href="javascript:updateComment(' . $c . ')" class="link-warning basic-function-for-user">Редактировать</a>
                                                           <a href="javascript:removeComment(' . $c . ')" class="link-danger basic-function-for-user">Удалить</a>';
                                    }
                                }
                            echo '</div>
                         </div>
                      <div id="commentTextBoxArea'.$c.'"></div>
                      </li>';
            }
        }
?>
            </ul>
        </div>
    <?php
    }
    ?>



<script type="text/javascript">

    function checkLoginState(){
        FB.getLoginStatus(function(response) {
            statusChangeCallback(response);
        });
    }

    function statusChangeCallback(response){
        FB.login(function(response) {
            if (response.authResponse) {
                console.log('Welcome!  Fetching your information.... ');
                FB.api('/me', {fields: "id,name,email"}, function(response) {
                    var email = response.email;
                    $.ajax({
                        type: "POST",
                        url: "/accounts/facebook_auth",
                        data: {
                            'Email' : email
                        },
                        success: function(data){
                            alert(data);
                            location.reload();
                        }
                    });
                });
            } else {
                console.log('User cancelled login or did not fully authorize.');
            }
        },{scope: 'email'});
    }

    $(document).ready(function () {
        if($("#currentUserId").val() == null)
        {
            $(".link-area").hide();
            $(".message-form").hide();
            $(".login-form").show();
        }
        else{
            $(".message-form").show();
            $(".login-form").hide();
        }
    });


    function cencelUpdateMessage(idElement){
        var id = idElement;
        $("#messageTextBoxArea"+ id).empty();
    }

    function cencelCreateCommentMessage(idElement) {
        var id = idElement;
        $("#messageTextBoxArea"+ id).empty();
    }

    function createMessage(){
        alert("hello");
        var newMessage = $("#msg").val();
        var authorId = $("#currentUserId").val();

        $.ajax({
            type: "POST",
            url: "/messages/create",
            data: {
                'new_msg': newMessage,
                'author_id': authorId
            },
            success: function(data){
                location.reload();
            }
        });
    }

    function createCommentMessage(idElement){
        var id = idElement;
        var messagesId = $("#hiddenMsgId" + id).val();

        alert("id: " + id + " messageId " + messagesId);

        $("#messageTextBoxArea" + id).append('<input type="hidden" id="hiddenMessageId'+ id +'" value="' + messagesId + '">' +
                '<textarea id="createNewComment'+ id +'" class="form-control" rows="3" placeholder="Введите новый комментарий"></textarea>' +
                '<a href="javascript:saveCommentMessage('+ id +')" class="btn btn-success basic-function-for-user">Сохранить</a>' +
                '<a href="javascript:cencelCreateCommentMessage('+ id +')" class="btn btn-default basic-function-for-user">Отмена</a>');

    }

    function saveCommentMessage(idElement) {
        var id = idElement;
        var comment = $("#createNewComment" + id).val();
        var parentId = 0;
        var messageId = $("#hiddenMessageId" + id).val();
        var authorId = $("#currentUserId").val();

        alert(" id: " + id + " comment: " + comment + " parent: " +parentId + " messageId: " + messageId + " authorId: " + authorId);

        $.ajax({
            type: "POST",
            url: "/messages/create_comment",
            data: {
                'comment': comment,
                'parent_id': parentId,
                'msg_id': messageId,
                'author_id': authorId
            },
            success: function(data){
                location.reload();
            }
        });
    }

    function updateMessage(idElement) {
        var id = idElement;
        var messageId = $("#hiddenMsgId"+ id).val();
        $("#messageTextBoxArea"+ id).append('<input type="hidden" id="updateMessageId'+ id +'" value="'+  messageId +'">' +
                '<textarea id="updateNewMessage'+ id +'" class="form-control" rows="3" placeholder="Введите новое сообщение"></textarea>' +
                '<a href="javascript:saveUpdateMessage('+ id +')" class="btn btn-success basic-function-for-user">Сохранить</a>' +
                '<a href="javascript:cencelUpdateMessage('+ id +')" class="btn btn-default basic-function-for-user">Отмена</a>');
    }

    
    function saveUpdateMessage(idElement) {
        var id = idElement;
        var newMessage = $("#updateNewMessage" + id).val();
        var messageId = $("#updateMessageId" + id).val();

        $.ajax({
            type: "POST",
            url: "/messages/update_msg",
            data: {
                'new_message' : newMessage,
                'message_id' : messageId
            },
            success: function(data){
                alert( "Прибыли данные: " + data );
                location.reload();
            }
        });

    }

    function removeMessage(idElement) {
        var id = idElement;
        var messageId = $("#hiddenMsgId" + id).val();

        alert("id rem comment" + messageId + " id elem in code: " +id);

        $.ajax({
            type: "POST",
            url: "/messages/remove_msg",
            data: {
                'rem_msg_id' : messageId
            },
            success: function(data){
                alert( "Прибыли данные: " + data );
                location.reload();
            }
        });
    }


    function createComment(idElement){
        var id = idElement;
        var commentId = $("#hiddenCommentId" + id).val();
        var parentId = $("#hiddenCommentParentId" + id).val();
        var messagesId = $("#hiddenMessageKeyId" + id).val();

        if ($("#hiddenCommentParentId" + id).val() > 0) {
            $("#commentTextBoxArea" + id).append('<input type="hidden" id="newParentCommentId'+ id +'" value="' + commentId + '">' +
                '<input type="hidden" id="messageForigenKeyId'+ id +'" value="' + messagesId + '">' +
                '<textarea id="createNewComment'+ id +'" class="form-control" rows="3" placeholder="Введите новый комментарий"></textarea>' +
                '<a href="javascript:saveNewComment('+ id +')" class="btn btn-success basic-function-for-user">Сохранить</a>' +
                '<a href="javascript:cencelComment('+ id +')" class="btn btn-default basic-function-for-user">Отмена</a>');
        }else{
                $("#commentTextBoxArea" + id).append('<input type="hidden" id="newParentCommentId'+ id +'" value="' + commentId + '">' +
                    '<input type="hidden" id="messageForigenKeyId'+ id +'" value="' + messagesId + '">' +
                    '<textarea id="createNewComment'+ id +'" class="form-control" rows="3" placeholder="Введите новый комментарий"></textarea>' +
                    '<a href="javascript:saveNewComment('+ id +')" class="btn btn-success basic-function-for-user">Сохранить</a>' +
                    '<a href="javascript:cencelComment('+ id +')" class="btn btn-default basic-function-for-user">Отмена</a>');
            }
    }


    function saveNewComment(idElement) {
        var id = idElement;
        var comment = $("#createNewComment" + id).val();
        var parentId = $("#newParentCommentId" + id).val();
        var messageId = $("#messageForigenKeyId" + id).val();
        var authorId = $("#currentUserId").val();

        alert(" id: " + id + " comment: " + comment + " parent: " +parentId + " messageId: " + messageId + " authorId: " + authorId);

            $.ajax({
                type: "POST",
                url: "/messages/create_comment",
                data: {
                    'comment': comment,
                    'parent_id': parentId,
                    'msg_id': messageId,
                    'author_id': authorId
                },
                success: function(data){
                    alert( "Прибыли данные: " + data );
                    location.reload();
                }
            });
    }

    function updateComment(idElement){
        var id = idElement;
        var commentId = $("#hiddenCommentId"+ id).val();
        var parentId = $("#hiddenCommentParentId"+ id).val();

        if($("#hiddenCommentParentId").val() > 0){
            $("#commentTextBoxArea" + id).append('<input type="hidden" id="updateCommentId'+ id +'" value="'+  commentId +'">' +
                '<input type="hidden" id="updateCommentParentId'+ id +'" value="'+ parentId +'">' +
                '<textarea id="updateNewComment'+ id +'" class="form-control" rows="3" placeholder="Введите новый комментарий"></textarea>' +
                '<a href="javascript:saveUpdateComment('+ id +')" class="btn btn-success basic-function-for-user">Сохранить</a>' +
                '<a href="javascript:cencelComment('+ id +')" class="btn btn-default basic-function-for-user">Отмена</a>');
        }
        else{
            $("#commentTextBoxArea" + id).append('<input type="hidden" id="updateCommentId'+ id +'" value="'+ commentId +'">' +
                '<input type="hidden" id="updateCommentParentId'+ id +'" value="'+ parentId +'">' +
                '<textarea id="updateNewComment'+ id +'" class="form-control" rows="3" placeholder="Введите новый комментарий"></textarea>' +
                '<a href="javascript:saveUpdateComment('+ id +')" class="btn btn-success basic-function-for-user">Сохранить</a>' +
                '<a href="javascript:cencelComment('+ id +')" class="btn btn-default basic-function-for-user">Отмена</a>');
        }

    }

    function saveUpdateComment(idElement){
        var id = idElement;
        var updateComment = $("#updateNewComment" + id).val();
        var commentId = $("#updateCommentId" + id).val();
        var parentId = $("#updateCommentParentId" + id).val();

        $.ajax({
            type: "POST",
            url: "/messages/update_comment",
            data: {
                'up_comment' : updateComment,
                'comment_id' : commentId,
                'parent_id' : parentId
            },
            success: function(data){
                alert(data);
                location.reload();
            }
        });
    }

    function removeComment(idElement){
        var id = idElement;
        var removeCommentId = $("#hiddenCommentId"+ id).val();

        $.ajax({
            type: "POST",
            url: "/messages/remove_comment",
            data: {
                'rem_comment_id' : removeCommentId
            },
            success: function(data){
                location.reload();
            }
        });
    }

    function cencelComment(idElement){
        var id = idElement;
        $("#commentTextBoxArea"+ id).empty();
    }



</script>
