<?php
include "../services/services.php";
include 'database.controller.php';
require_once "databasePDO.controller.php";
class PackageController
{
    public function __construct()
    {
    }
    public function addPackage($get)
    {
        try {
            $db = new DatabaseController();

            $sql = "insert into package (packagename,price,description) values ('$get->packagename','$get->price','$get->description')";
            $data = $db->query($sql);
            if ($data) {
                PrintJSON("", "add package OK!", 1);
            } else {
                PrintJSON("", "add package failed!", 0);
            }
        } catch (Exception $e) {
            print_r($e);
        }
    }
    public function updatePackage($get)
    {
        try {
            $db = new DatabaseController();

            $sql = "update package set packagename='$get->packagename',price='$get->price',description='$get->description' where packageid ='$get->packageid' ";
            $data = $db->query($sql);
            if ($data) {
                PrintJSON("", "update package OK!", 1);
            } else {
                PrintJSON("", "update package failed!", 0);
            }
        } catch (Exception $e) {
            print_r($e);
        }
    }
    public function deletePackage($cate)
    {
        try {
            $db = new DatabaseController();

            $sql = "delete from package where packageid='$cate->packageid'";
            $data = $db->query($sql);
            if ($data) {
                PrintJSON("", "package ID: " . $cate->packageid . " delete Ok", 1);
            } else {
                PrintJSON("", "delete package failed!", 0);
            }
        } catch (Exception $e) {
            print_r($e->getMessage());
        }
    }
    public function packageList($get)
    {
        try {
            $db = new DatabaseController();

            if ($get->page == "" && $get->limit == "") {
                $sql = "select *from package order by packageid desc ";
                $doquery = $db->query($sql);

                $list = json_encode($doquery);
                $json = "{\"Data\":$list}";
                echo $json;
            } else {
                $offset = (($get->page - 1) * $get->limit);

                $sql = "select * from package ";
                if (isset($get->keyword) && $get->keyword != "") {
                    $sql .= "where
                        packagename like '%$get->keyword%'
                          ";
                }
                $sql_page = "order by packageid desc limit $get->limit offset $offset  ";
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
    public function getPackage($cate)
    {
        try {
            $db = new DatabaseController();
            $sql1 = " select* from package where packageid='$cate->packageid'";
            $data = $db->query($sql1);
            $list = json_encode($data);
            echo $list;
        } catch (Exception $e) {
            print_r($e);
        }
    }
}
