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
                   <span class="date-created"> Date : '.$data['parents'][$m]['date_created'].'</span><br/>
                   <span>'.$data['parents'][$m]['message'].'</span>
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
                           <div style="margin-left:20px;">
                                <span class="date-created">Date : '.$data['childrens'][$c]['date_created'].'</span><br/>
                                <span class="comment">'.$data['childrens'][$c]['comment'].'</span>
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
                           <div style="margin-left:60px;">
                                <span class="date-created">Date : '.$data['childrens'][$c]['date_created'].'</span><br/>
                                <span class="comment">'.$data['childrens'][$c]['comment'].'</span>
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

<script src="/js/share-js/messages/facebook.js" type="text/javascript"></script>
<script src="/js/share-js/messages/messages.js" type="text/javascript"></script>
