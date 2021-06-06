<?php

class MemberModel
{
    public $memberid;
    public $membername;
    public $phonenumber;
    public $image;
    public $packageid;
    public $endpackage;

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
            if (property_exists('MemberModel', $property)) {
                $this->$property = $value;
            }
        }
    }
    public function checkId()
    {
        $db = new DatabaseController();
        $sql = "select * from member where memberid='$this->memberid' ";
        $name = $db->query($sql);

        if ($name == 0) {
            PrintJSON("", " member ID: " . $this->memberid . " is not available!", 0);
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
            case 'membername':
                $this->validateMemberName();
                break;
            case 'phonenumber':
                $this->validatePhonenumber();
                break;
                // case 'image':
                //     $this->validateImage();
                //     break;
            case 'packageid':
                $this->validatePackageId();
                break;
            case 'endpackage':
                $this->validateEndPackage();
                break;
        }
    }

    public function validateMemberName()
    {
        if (empty($this->membername)) {
            PrintJSON("", "member name is empty", 0);
            die();
        }
    }
    public function validatePhonenumber()
    {
        if (empty($this->phonenumber)) {
            PrintJSON("", "phonenumber is empty", 0);
            die();
        }
    }
    public function validateImage()
    {
        if (empty($this->image)) {
            PrintJSON("", "image is empty", 0);
            die();
        }
    }
    public function validatePackageId()
    {
        if (empty($this->packageid)) {
            PrintJSON("", "packageid is empty", 0);
            die();
        }
    }
    public function validateEndPackage()
    {
        if (empty($this->endpackage)) {
            PrintJSON("", "end package is empty", 0);
            die();
        }
    }
}
