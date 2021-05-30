<?php

class ServiceModel
{
    public $serviceid;
    public $memberid;
    public $status;

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
            if (property_exists('ServiceModel', $property)) {
                $this->$property = $value;
            }
        }
    }
    public function checkId()
    {
        $db = new DatabaseController();
        $sql = "select * from service where serviceid='$this->serviceid' and status = 1 ";
        $name = $db->query($sql);

        if ($name == 0) {
            PrintJSON("", " service ID: " . $this->serviceid . " is checkouted!", 0);
            die();
        }
    }

    public function validateMemberId()
    {
        $db = new DatabaseController();
        $sql = "select * from member where memberid='$this->memberid'";
        $name = $db->query($sql);

        if ($name == 0) {
            PrintJSON("", " member ID: " . $this->memberid . " is not exist!", 0);
            die();
        }
        if (empty($this->memberid)) {
            PrintJSON("", "member id is empty!", 0);
            die();
        }
    }
}
