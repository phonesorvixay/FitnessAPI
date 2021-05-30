<?php
include "../services/services.php";
include 'database.controller.php';
class ServiceController
{
    public function __construct()
    {
    }
    public function checkIn($get)
    {
        try {

            date_default_timezone_set("Asia/Vientiane");
            $nowDate = date("Y-m-d H:i:s ");

            $db = new DatabaseController();
            $sql = "insert into service (memberid,status,checkin) values ('$get->memberid',1,'$nowDate')";
            $data = $db->query($sql);
            if ($data) {
                PrintJSON("", "Checkin OK!", 1);
            } else {
                PrintJSON("", "Checkin failed!", 0);
            }
        } catch (Exception $e) {
            print_r($e);
        }
    }
    public function checkOut($get)
    {
        try {

            date_default_timezone_set("Asia/Vientiane");
            $nowDate = date("Y-m-d H:i:s ");

            $db = new DatabaseController();
            $sql = "update service set status=0 ,checkout ='$nowDate' where serviceid='$get->serviceid'";
            $data = $db->query($sql);
            if ($data) {
                PrintJSON("", "Checkout OK!", 1);
            } else {
                PrintJSON("", "Checkout failed!", 0);
            }
        } catch (Exception $e) {
            print_r($e);
        }
    }
    public function deleteservice($get)
    {
        try {
            $db = new DatabaseController();
            $sql = "delete from service where serviceid='$get->serviceid'";
            $data = $db->query($sql);
            if ($data) {
                PrintJSON("", "service ID: " . $get->serviceid . " delete Ok", 1);
            } else {
                PrintJSON("", "delete service failed!", 0);
            }
        } catch (Exception $e) {
            print_r($e);
        }
    }
    public function serviceList($get)
    {
        try {
            $db = new DatabaseController();

            if ($get->page == "" && $get->limit == "") {
                $sql = "select s.*,m.membername,m.phonenumber,m.image from service as s
                        INNER JOIN member as m ON s.memberid = m.memberid ";

                if (isset($get->status) && $get->status != '') {
                    $sql .= "where status='$get->status'";
                }

                $sql .= " order by serviceid desc  ";

                $doquery = $db->query($sql);
                $list = json_encode($doquery);
                $json = "{\"Data\":$list}";
                echo $json;
            } else {
                $offset = (($get->page - 1) * $get->limit);

                $sql = "select s.*,m.membername,m.phonenumber,m.image from service as s
                INNER JOIN member as m ON s.memberid = m.memberid   ";

                if (isset($get->status) && $get->status != '') {
                    $sql .= "where status='$get->status'";

                    if (isset($get->keyword) && $get->keyword != "") {
                        $sql .= "and m.membername like '%$get->keyword%' ";
                    }
                } else if (isset($get->keyword) && $get->keyword != "") {
                    $sql .= "where
                                m.membername like '%$get->keyword%'
                          ";
                }
                $sql_page = "order by serviceid desc limit $get->limit offset $offset  ";
                // echo $sql.$sql_page;die();
                $doquery = $db->query($sql);
                if ($doquery > 0) {
                    $count = sizeof($doquery);
                    if ($count > 0) {
                        $data = $db->query($sql . $sql_page);
                        $list1 = json_encode($data);
                    }
                } else {
                    $list1 = json_encode([]);
                    $count = 0;
                }

                $number_count = $count;
                $total_page = ceil($number_count / $get->limit);
                $list3 = json_encode($total_page);
                $json = "{  \"Data\":$list1,
                        \"Page\":$get->page,
                        \"Pagetotal\":$list3,
                        \"Datatotal\":$number_count
                    }";
                echo $json;
            }
        } catch (Exception $e) {
            print_r($e);
        }
    }
    public function getservice($get)
    {
        try {
            $db = new DatabaseController();

            $sql = "select * from service  where serviceid ='$get->serviceid' ";
            $data = $db->query($sql);
            $list = json_encode($data);
            echo $list;
        } catch (Exception $e) {
            print_r($e);
        }
    }
}
