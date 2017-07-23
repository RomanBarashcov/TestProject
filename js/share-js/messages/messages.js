
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
    var newMessage = $("#msg").val();
    var authorId = $("#currentUserId").val();

    $.ajax({
        type: "POST",
        url: "/messages/create",
        data: {
            'new_msg': newMessage,
            'author_id': authorId
        },
        success: function(){
            location.reload();
        }
    });
}

function createCommentMessage(idElement){
    var id = idElement;
    var messagesId = $("#hiddenMsgId" + id).val();

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

    $.ajax({
        type: "POST",
        url: "/messages/create_comment",
        data: {
            'comment': comment,
            'parent_id': parentId,
            'msg_id': messageId,
            'author_id': authorId
        },
        success: function(){
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
        success: function(){
            location.reload();
        }
    });

}

function removeMessage(idElement) {
    var id = idElement;
    var messageId = $("#hiddenMsgId" + id).val();
    $.ajax({
        type: "POST",
        url: "/messages/remove_msg",
        data: {
            'rem_msg_id' : messageId
        },
        success: function(){
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

    $.ajax({
        type: "POST",
        url: "/messages/create_comment",
        data: {
            'comment': comment,
            'parent_id': parentId,
            'msg_id': messageId,
            'author_id': authorId
        },
        success: function(){
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
        success: function(){
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
        success: function(){
            location.reload();
        }
    });
}

function cencelComment(idElement){
    var id = idElement;
    $("#commentTextBoxArea"+ id).empty();
}