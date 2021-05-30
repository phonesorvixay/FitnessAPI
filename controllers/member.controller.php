<?php

include "../services/services.php";
include 'database.controller.php';
class MemberController
{
    public function __construct()
    {
    }
    public function addmember($get)
    {
        try {

            $type = explode('/', explode(';', $get->image)[0])[1];
            $p = preg_replace('#^data:image/\w+;base64,#i', '', $get->image);
            $name_image = "member-$get->membername-$get->phonenumber.$type";
            $name = MY_PATH . $name_image;
            $image = base64_to_jpeg($p, $name);

            date_default_timezone_set("Asia/Vientiane");
            $userid = $_SESSION["uid"];
            $nowDate = date("Y-m-d");

            $db = new DatabaseController();
            $sql = "insert into member (membername,phonenumber,image,packageid,startpackage,endpackage,userid)
                    values ('$get->membername','$get->phonenumber','$name_image','$get->packageid','$nowDate','$get->endpackage','$userid')";
            $data = $db->query($sql);
            if ($data) {
                PrintJSON("", "add member OK!", 1);
            } else {
                PrintJSON("", "add member failed!", 0);
            }
        } catch (Exception $e) {
            print_r($e);
        }
    }
    public function updatemember($get)
    {
        try {

            $type = explode('/', explode(';', $get->image)[0])[1];
            $p = preg_replace('#^data:image/\w+;base64,#i', '', $get->image);
            $name_image = "member-$get->membername-$get->phonenumber.$type";
            $name = MY_PATH . $name_image;
            $image = base64_to_jpeg($p, $name);


            $db = new DatabaseController();
            $sql = "update member set membername='$get->membername',phonenumber='$get->phonenumber', image='$name_image',
                    packageid='$get->packageid', endpackage='$get->endpackage' where memberid='$get->memberid' ";
            $data = $db->query($sql);
            if ($data) {
                PrintJSON("", "update member OK!", 1);
            } else {
                PrintJSON("", "update member failed!", 0);
            }
        } catch (Exception $e) {
            print_r($e);
        }
    }

    public function deletemember($get)
    {
        try {
            $db = new DatabaseController();
            $sql = "delete from member where memberid='$get->memberid'";
            $data = $db->query($sql);
            if ($data) {
                PrintJSON("", "member ID: " . $get->memberid . " delete Ok", 1);
            } else {
                PrintJSON("", "delete member failed!", 0);
            }
        } catch (Exception $e) {
            print_r($e);
        }
    }
    public function memberList($get)
    {
        try {
            $db = new DatabaseController();

            if ($get->page == "" && $get->limit == "") {
                $sql = "select m.*,p.packagename,u.name as name_of_user from member as m
                        INNER JOIN package as p ON m.packageid = p.packageid 
                        INNER JOIN users as u ON m.userid = u.userid order by memberid desc ";
                $doquery = $db->query($sql);
                $list = json_encode($doquery);
                $json = "{\"Data\":$list}";
                echo $json;
            } else {
                $offset = (($get->page - 1) * $get->limit);

                $sql = "select m.*,p.packagename,u.name as name_of_user from member as m
                        INNER JOIN package as p ON m.packageid = p.packageid 
                        INNER JOIN users as u ON m.userid = u.userid  ";
                if (isset($get->keyword) && $get->keyword != "") {
                    $sql .= "where
                        memberid like '%$get->keyword%' or
                        membername like '%$get->keyword%' or
                        phonenumber like '%$get->keyword%'
                          ";
                }
                $sql_page = "order by memberid desc limit $get->limit offset $offset  ";
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
    public function getmember($get)
    {
        try {
            $db = new DatabaseController();

            $sql = "select m.*,p.packagename,u.name as name_of_user from member as m
                    INNER JOIN package as p ON m.packageid = p.packageid 
                    INNER JOIN users as u ON m.userid = u.userid  where memberid ='$get->memberid' ";
            $data = $db->query($sql);
            $list = json_encode($data);
            echo $list;
        } catch (Exception $e) {
            print_r($e);
        }
    }
}
