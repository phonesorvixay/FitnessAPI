
<?php

include "../services/services.php";
include 'database.controller.php';
require_once "databasePDO.controller.php";

class ReportTicketController
{
    public function __construct()
    {
    }
    public function reportService($get)
    {
        try {
            $db = new DatabaseController();
            $sql1 = "select s.*,m.membername,m.phonenumber,m.image from service as s
                    INNER JOIN member as m ON s.memberid = m.memberid 
                    where date(checkin) between '$get->first_date' and '$get->last_date'";
            $data1 = $db->query($sql1);
            $json = json_encode($data1);
            if ($data1 > 0) {
                echo $json;
            } else {
                echo '[]';
            }
        } catch (Exception $e) {
            print_r($e);
        }
    }
    public function reportMemberStart($get)
    {
        try {
            $db = new DatabaseController();
            $sql1 = "select m.*,p.packagename,u.name as name_of_user from member as m
                     INNER JOIN package as p ON m.packageid = p.packageid 
                     INNER JOIN users as u ON m.userid = u.userid
                     where startpackage between '$get->first_date' and '$get->last_date'";
            $data1 = $db->query($sql1);
            $json = json_encode($data1);
            if ($data1 > 0) {
                echo $json;
            } else {
                echo '[]';
            }
        } catch (Exception $e) {
            print_r($e);
        }
    }
    public function reportMemberEnd($get)
    {
        try {
            $db = new DatabaseController();
            $sql1 = "select m.*,p.packagename,u.name as name_of_user from member as m
                     INNER JOIN package as p ON m.packageid = p.packageid 
                     INNER JOIN users as u ON m.userid = u.userid
                     where endpackage between '$get->first_date' and '$get->last_date'";
            $data1 = $db->query($sql1);
            $json = json_encode($data1);
            if ($data1 > 0) {
                echo $json;
            } else {
                echo '[]';
            }
        } catch (Exception $e) {
            print_r($e);
        }
    }
}
