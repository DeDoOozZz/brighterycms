<?php

defined('ROOT') OR exit('No direct script access allowed');

/**
 * Chat
 *
 * @package Brightery CMS
 * @author Muhammad El-Saeed <m.elsaeed@brightery.com>
 * @version 1.0
 * @interface management
 * @module chat
 * @category general
 * @module_version 1.0
 * @link http://store.brightery.com/module/general/chat
 * @controller ChatController
 * */
class ChatController extends Brightery_Controller {

    protected $layout = 'ajax';

    public function indexAction() {
        $this->permission('index');
        $user = $this->permissions->getUserInformation();
        $chat_list = $this->Database->query("SELECT * FROM `sessions`
        RIGHT JOIN `users` ON `users`.`user_id` = `sessions`.`user_id`
        WHERE `users`.`user_id` != '$user->user_id'
        GROUP BY `users`.`user_id`
        ORDER BY `sessions`.`latest_activity` DESC")->result();
        $users = [];
        $status = [];
        foreach ($chat_list as $user) {
            if (($unixtime = strtotime($user->latest_activity)) > (time() - (60 * 5))) {
                $status['status'] = 'is-online';
                $status['last_seen'] = null;
            } else {
                $status['status'] = 'is-offline';
                if ($user->latest_activity)
                    $status['last_seen'] = $this->lastSeenCalculator($unixtime);
                else
                    $status['last_seen'] = null;
            }
            $users[] = array_merge((array)$user, $status);
        }
        
        return $this->render('chat/chat_list', [
                    'users' => $users
        ]);

        /**
         * stdClass Object
         * (
         * [session_id] => lvotiuge54gbjk9dcp7g19d722
         * [user_id] => 1
         * [ip] => 127.0.0.1
         * [latest_activity] => 2015-09-15 14:49:24
         * [agent] => Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/45.0.2454.85 Safari/537.36
         * [data] =>
         * )
         */
//        print_r($user);
//        echo '<a href="#"><span class="user-status is-online"></span> <em>Catherine J. Watkins</em></a>
//                <a href="#"><span class="user-status is-online"></span> <em>Nicholas R. Walker</em></a>
//                <a href="#"><span class="user-status is-busy"></span> <em>Susan J. Best</em></a>
//                <a href="#"><span class="user-status is-idle"></span> <em>Fernando G. Olson</em></a>
//                <a href="#"><span class="user-status is-offline"></span> <em>Brandon S. Young</em></a>';
    }

    private function lastSeenCalculator($time) {
        $res = (time() - $time) / 60;
        $lable = 'm';
        if ($res > 60) {
            $res /= 60;
            $lable = 'h';
            if ($res > 24) {
                $res /= 24;
                $lable = 'd';
            }
        }
        return floor($res) . $lable;
    }

    public function chat_conversationAction($conversation_id = false) {
        $user = $this->permissions->getUserInformation();

//        if (!$this->Database->query("SELECT chat_conversations.*
//          FROM chat_conversations
//          INNER JOIN chat_conversation_users first_user ON chat_conversations.chat_conversation_id = first_user.chat_conversation_id AND first_user.user_id = '$user->user_id'
//          WHERE first_user.user_id = '$user->user_id' AND chat_conversations.chat_conversation_id = '$conversation_id' ")->row()
//        )
//            return json_encode(['error' => "This user doesn't exists"]);

        $conversation = $this->Database->query("SELECT *
          FROM
            (SELECT chat_conversation_messages.*, users.image
              FROM chat_conversation_messages
              INNER JOIN users ON users.user_id = chat_conversation_messages.user_id
              WHERE chat_conversation_messages.chat_conversation_id = '$conversation_id'
              ORDER BY microtime DESC LIMIT 30) t
          ORDER BY t.microtime ASC")->result();

        return $this->render('chat/chat_messages', [
                    'conversations' => $conversation,
                    'user' => $user
        ]);
    }

    public function footer_sticked_chatAction($user_id = false) {
        $user = $this->permissions->getUserInformation();

        if ($user_id == $user->user_id)
            return json_encode(['error' => 'The same user']);

        if ($user_id && !$this->Database->where('user_id', $user_id)->get('users')->row())
            return json_encode(['error' => 'This user doesn\'t exists']);

        if ($user_id)
            $this->getUserConversation($user_id);

        $opened_conversations = $this->Database->query("SELECT chat_conversations.*, second_user.*, users.fullname, (SELECT COUNT(*)
              FROM chat_conversation_messages
              WHERE chat_conversation_messages.chat_conversation_id = chat_conversations.chat_conversation_id
              AND chat_conversation_messages.status != 'SEEN') AS new_messages
          FROM chat_conversations
          INNER JOIN chat_conversation_users first_user ON chat_conversations.chat_conversation_id = first_user.chat_conversation_id AND first_user.user_id = '$user->user_id'
          INNER JOIN chat_conversation_users second_user ON chat_conversations.chat_conversation_id = second_user.chat_conversation_id AND second_user.user_id != '$user->user_id'
          INNER JOIN users ON users.user_id = second_user.user_id
          WHERE first_user.user_id = '$user->user_id' AND first_user.status = 'OPENED'
          ORDER BY first_user.last_update_time DESC")->result();
//        $users = $this->Database->query("SELECT * FROM chat_conversations WHERE $user->user_id IN (SELECT group_concat(user_id) FROM chat_conversation_users GROUP BY chat_conversation_id )")->result();

        $conversations = array_slice($opened_conversations, 0, 3);
        $otherConversations = array_slice($opened_conversations, 3);
        return $this->render('chat/footer_sticked_chat', [
                    'conversations' => $conversations,
                    'other_conversations' => $otherConversations,
                    'count_other_conversations' => count($otherConversations),
                    'all_conversations' => count($otherConversations) + count($conversations)
        ]);
    }

    private function getUserConversation($user_id) {
        $user = $this->permissions->getUserInformation();

        if ($conversation = $this->Database->query("SELECT chat_conversations.*
          FROM chat_conversations
          INNER JOIN chat_conversation_users first_user ON chat_conversations.chat_conversation_id = first_user.chat_conversation_id AND first_user.user_id = '$user->user_id'
          INNER JOIN chat_conversation_users second_user ON chat_conversations.chat_conversation_id = second_user.chat_conversation_id AND second_user.user_id = '$user_id'")->row()
        ) {
            $this->Database->where('chat_conversation_id', $conversation->chat_conversation_id)
                    ->where('user_id', $user->user_id)
                    ->update('chat_conversation_users', [
                        'status' => 'OPENED',
                        'last_update_time' => microtime(true)
            ]);
            return $conversation->chat_conversation_id;
        } else {
            $this->Database->insert('chat_conversations');
            $conversation_id = $this->Database->insert_id();
            $this->Database->insert('chat_conversation_users', [
                'chat_conversation_id' => $conversation_id,
                'user_id' => $user->user_id,
                'status' => 'OPENED',
                'last_update_time' => microtime(true)
            ]);
            $this->Database->insert('chat_conversation_users', [
                'chat_conversation_id' => $conversation_id,
                'user_id' => $user_id,
                'status' => 'OPENED',
                'last_update_time' => microtime(true)
            ]);
            return $conversation_id;
        }
    }

}
