<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
//error_reporting(E_ALL);

include "../controllers/member.controller.php";
include_once "../models/member.model.php";

try {
    Initialization();
    $m = getallheaders()['m'];

    $json = json_decode(file_get_contents('php://input'), true);
    $control = new MemberController();
    $model = new MemberModel($json);

    if ($m == "addmember") {
        $model->validateall();
        $control->addmember($model);
    } else if ($m == "updatemember") {
        $model->checkId();
        $model->validateall();
        $control->updatemember($model);
    } else if ($m == "deletemember") {
        $model->checkId();
        $control->deletemember($model);
    } else if ($m == "memberlist") {
        $control->memberList($model);
    } else if ($m == "getmember") {
        $control->getmember($model);
    } else {
        PrintJSON("", "wrong method!!!", 0);
    }
} catch (Exception $e) {
    print_r($e);
}
