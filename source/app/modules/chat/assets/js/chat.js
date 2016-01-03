$(document).ready(function () {
    var connectivity_status;
    setInterval(function () {
        chat.sync_users();
    }, 10000);
});

chat = {
    sync_users: function() {
//        $.get(site_url + 'management/chat', function (status) {
//                $('#chat .chat-group').html(status);
//            }
//        );
    },
    draw: function(user_id) {
        if(user_id == undefined)
            user_id = '';
//        $.get(site_url + 'management/chat/footer_sticked_chat/' + user_id, function (status) {
//                $('.footer-sticked-chat').html(status);
//            }
//        );
    },
    formHandler: function(conversation_id) {
        //$chat_win.find("form").on('submit', function (ev) {

            //ev.preventDefault();
            alert('Yeahhh');
            return false;
        //});
    },
    toggleChatWindow:function($chat_win) {
        $chat_win.toggleClass('open');

        if ($chat_win.hasClass('open')) {
            var $messages = $chat_win.find('.ps-scrollbar');

            if ($.isFunction($.fn.perfectScrollbar)) {
                $messages.perfectScrollbar('destroy');

                setTimeout(function () {
                    $messages.perfectScrollbar();
                    $chat_win.find('.form-control').focus();
                }, 300);
            }
        }


    },
    closeChatWindow: function(user_id){
        $('.conversation_window_').remove();
    },
    sync_messages: function(conversation_id) {
//        $.get(site_url + 'management/chat/chat_conversation/' + conversation_id, function (status) {
//                $('.conversation_window_' + conversation_id + ' .conversation-messages').html(status);
//            }
//        );
    }

};



