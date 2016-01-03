<?php defined('ROOT') OR exit('No direct script access allowed');

/**
 * Permissions Library
 * @package Brightery CMS
 * @author Muhammad El-Saeed <muhammad@el-saeed.info>
 * @version 1.0
 **/
class User
{
    private $db;
    private $userInfo;
    private $verified = false;

    public function __construct()
    {
        $this->db = &Brightery::SuperInstance()->Database;
        $this->input = &Brightery::SuperInstance()->Input;
    }

    public function checkUserCredentials($email = null, $password = null)
    {
        if ($this->verified)
            return $this->verified;
        if ($email == null && $password == null) {
            $email = $this->input->cookie('email');
            $password = $this->input->cookie('password');
        }
        $this->userInfo = $this->db->query("SELECT * FROM users WHERE users.email = '$email' AND users.password = '$password' AND users.status = 'active'")->row();
        if ($this->userInfo)
            return $this->verified = TRUE;
        return FALSE;
    }

    public function getUserInformation()
    {
        if (!$this->verified)
            $this->checkUserCredentials();
        return $this->userInfo;
    }
}