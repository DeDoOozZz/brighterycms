<?php

class Input
{

    public $input;

    public function __construct()
    {
        Log::set('Initialize Input class');
        $this->input = [
            'cookie' => $_COOKIE,
            'get' => $_GET,
            'post' => $_POST,
            'request' => $_REQUEST,
            'files' => $_FILES,
            'server' => $_SERVER,
            'env' => $_ENV
        ];
        if($this->cookie('session_id'))
            session_id($this->cookie('session_id'));

        if (Brightery::SuperInstance()->Config->get('Config.enable_session'))
            $this->activateSession();

        array_walk_recursive($this->input, 'self::InputFilter');
    }

    function activateSession()
    {
        session_start();
        $this->input['session'] = &$_SESSION;
    }

    function get($index = null)
    {
        return $this->getArrayItem('get', $index);
    }

    function post($index = null)
    {
        return $this->getArrayItem('post', $index);
    }

    function session($index, $value = null)
    {
        if ($value === null)
            return $this->getFromFlatArray('session', $index);
        else
            $this->setSession($index, $value);
    }

    function eliteSession()
    {
        $userInfo = Brightery::SuperInstance()->permissions->getUserInformation();
        if ($session_id = $this->cookie('session_id')) {
            if ($row = Brightery::SuperInstance()->Database->query("SELECT * FROM `sessions` WHERE `session_id`='$session_id'")->row()) {
                Brightery::SuperInstance()->Database->where('session_id', $session_id)
                                            ->update("sessions", [
                    'latest_activity' => date('Y-m-d H:i:s'),
                    'user_id' => $userInfo->user_id
                                            ]);
                session_id($session_id);
                return $row;
            }
        } else {
            $session_id = session_id();
            $this->cookie('session_id', $session_id);
            Brightery::SuperInstance()->Database->insert('sessions', [
                'session_id' => $session_id,
                'user_id' => $userInfo->user_id,
                'ip' => $_SERVER['REMOTE_ADDR'],
                'agent' => $_SERVER['HTTP_USER_AGENT'],
                'latest_activity' => date('Y-m-d H:i:s'),
            ]);
            if ($row = Brightery::SuperInstance()->Database->query("SELECT * FROM `sessions` WHERE `session_id`='$session_id' ")->row())
                return $row;
        }
    }

    function files($index)
    {
        // TODO: GET FILES

    }

    function request($index)
    {
        return $this->getArrayItem('request', $index);
    }

    function server($index)
    {
        return $this->getFromFlatArray('server', $index);
    }

    function env($index)
    {
        return $this->getFromFlatArray('env', $index);
    }

    public function cookie($index, $value = null)
    {
        if ($value === null)
            return $this->getFromFlatArray('cookie', $index);
        else
            $this->setCookie($index, $value);
        return $value;
    }

    private function setSession($item, $value = null)
    {
        $this->input['session'][$item] = $value;
        $_SESSION[$item] = $value;
    }

    private function setCookie($item, $value)
    {
        $this->input['cookie'][$item] = $value;
        setcookie($item, $value, time() + (86400 * 30), "/");
    }

    public function deleteCookie($item)
    {
        if (isset($this->input['cookie'][$item]))
            unset($this->input['cookie'][$item]);
        setcookie($item, '', 1, "/");
    }

    private function InputFilter(& $value)
    {
        return htmlspecialchars(stripslashes(trim($value)), ENT_QUOTES, 'UTF-8');
    }

    private function getArrayItem($type, $item = null)
    {
        if ($item == null)
            return $this->input[$type];

        $item = explode('.', $item);
        $res = $this->input[$type];
        for ($i = 0; $i < count($item); $i++) {
            if (!isset($res[$item[$i]]))
                return null;
            $res = $res[$item[$i]];
        }
        return $res;
    }

    private function getFromFlatArray($type, $index)
    {
        if (!isset($this->input[$type][$index]))
            return null;
        return $this->input[$type][$index];
    }
}
