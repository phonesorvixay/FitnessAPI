<?php

class UserModel
{
    public $userid;
    public $name;
    public $username;
    public $password;

    public $page;
    public $limit;
    public $keyword;
    public function __construct($object)
    {
        if (!$object) {
            echo '{"message":" data is empty"}';
            die();
        }
        foreach ($object as $property => $value) {
            if (property_exists('UserModel', $property)) {
                $this->$property = $value;
            }
        }
    }
    public function checkId()
    {
        $db = new DatabaseController();
        $sql = "select * from users where userid='$this->userid' ";
        $name = $db->query($sql);

        if ($name == 0) {
            PrintJSON("", " user ID: " . $this->userid . " is not available!", 0);
            die();
        }
    }
    public function checkForeignKey()
    {
        $db = new DatabaseController();
        $sql = "select * from member where userid='$this->userid' ";
        $name = $db->query($sql);

        if ($name > 0) {
            PrintJSON("", " user ID: " . $this->userid . " have foreign key in member", 0);
            die();
        }
    }
    public function validateall()
    {
        foreach ($this as $property => $value) {
            $this->validate($property);
        }
    }
    public function validate($p)
    {
        switch ($p) {
            case 'name':
                $this->validateName();
                break;
            case 'username':
                $this->validateUserName();
                break;
            case 'password':
                $this->validatePass();
                break;
        }
    }
    public function validateUsername()
    {
        $db = new DatabaseController();
        $sql = "select * from users where username='$this->username' and userid !='$this->userid' ";
        $name = $db->query($sql);
        if ($name > 0) {
            PrintJSON("", " username: " . $this->username . " already exist", 0);
            die();
        }
        if (strlen($this->username) < 3) {
            PrintJSON("", "username is short ", 0);
            die();
        }
    }
    public function validatePass()
    {
        if (strlen($this->password) < 6) {
            PrintJSON("", "password is short ", 0);
            die();
        }
    }
    public function validateName()
    {
        if (empty($this->name)) {
            PrintJSON("", "name is empty!", 0);
        }
    }
}
