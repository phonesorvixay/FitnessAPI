<?php

class PackageModel
{
    public $packageid;
    public $packagename;
    public $price;
    public $description;

    public $page;
    public $limit;
    public $keyword;
    public function __construct($object)
    {
        // print_r($object);die();
        if (!$object) {
            echo '{"message":" data is empty"}';
            die();
        }
        foreach ($object as $property => $value) {
            if (property_exists('PackageModel', $property)) {
                $this->$property = $value;
            }
        }
    }
    public function checkId()
    {
        $db = new DatabaseController();
        $sql = "select * from package where packageid='$this->packageid' ";
        $name = $db->query($sql);

        if ($name == 0) {
            PrintJSON("", " package ID: " . $this->packageid . " is not available!", 0);
            die();
        }
    }
    public function checkdelete()
    {
        $db = new DatabaseController();
        $sql = "select * from member where packageid='$this->packageid' ";
        $name = $db->query($sql);

        if ($name > 0) {
            PrintJSON("", " package ID: " . $this->packageid . " have foreign key in member", 0);
            die();
        }
    }
    public function validatePackageName()
    {
        $db = new DatabaseController();
        $sql = "select * from package where packagename='$this->packagename' and packageid!='$this->packageid' ";
        $name = $db->query($sql);

        if ($name > 0) {
            PrintJSON("", " package name: " . $this->packagename . " is already exist!", 0);
            die();
        }
        if (empty($this->packagename)) {
            PrintJSON("", "package name is empty!", 0);
            die();
        }
    }

    public function validatePrice()
    {
        if (empty($this->price)) {
            PrintJSON("", "price is empty!", 0);
            die();
        }
    }
}
