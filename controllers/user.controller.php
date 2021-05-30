<?php
include "../services/services.php";
include 'database.controller.php';
class UserController
{
    public function __construct()
    {
    }
    public function addUser($u)
    {
        try {
            $db = new DatabaseController();
            $sql = "insert into users (name,username,password) values ('$u->name','$u->username','$u->password')";
            $data = $db->query($sql);
            if ($data) {
                PrintJSON("", "add user OK!", 1);
            } else {
                PrintJSON("", "add user failed!", 0);
            }
        } catch (Exception $e) {
            print_r($e);
        }
    }
    public function updateUser($u)
    {
        try {
            $db = new DatabaseController();

            $sql = "update users set name='$u->name', username='$u->username',password='$u->password' where userid ='$u->userid' ";
            $data = $db->query($sql);
            if ($data) {
                PrintJSON("", "update user OK!", 1);
            } else {
                PrintJSON("", "update user failed!", 0);
            }
        } catch (Exception $e) {
            print_r($e);
        }
    }
    public function deleteUser($u)
    {
        try {
            $db = new DatabaseController();

            $sql = "delete from users where userid='$u->userid'";
            $data = $db->query($sql);
            if ($data) {
                PrintJSON("", "user ID: " . $u->userid . " delete Ok", 1);
            } else {
                PrintJSON("", "delete user failed!", 0);
            }
        } catch (Exception $e) {
            print_r($e);
        }
    }
    public function getuser($get)
    {
        try {

            $db = new DatabaseController();
            $sql = "select * from users where userid ='$get->userid' ";
            $data = $db->query($sql);
            $json = json_encode($data[0]);
            echo $json;
        } catch (Exception $e) {
            print_r($e);
        }
    }
    public function userList($get)
    {
        try {

            $db = new DatabaseController();

            $offset = (($get->page - 1) * $get->limit);

            $sql = "select * from users ";
            if (isset($get->keyword) && $get->keyword != "") {
                $sql .= "where
                        user_name like '%$get->keyword%'
                          ";
            }
            $sql_page = "order by userid desc limit $get->limit offset $offset";
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
        } catch (Exception $e) {
            print_r($e);
        }
    }
}
