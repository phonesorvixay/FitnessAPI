<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
//error_reporting(E_ALL);

include "../controllers/service.controller.php";
include_once "../models/service.model.php";

try {
    Initialization();
    $m = getallheaders()['m'];
    $json = json_decode(file_get_contents('php://input'), true);
    $control = new ServiceController();
    $model = new ServiceModel($json);

    if ($m == "checkin") {
        $model->validateMemberId();
        $control->checkIn($model);
    } else if ($m == "checkout") {
        $model->checkId();
        $control->checkOut($model);
    } else if ($m == "deleteservice") {
        $model->checkId();
        $control->deleteservice($model);
    } else if ($m == "servicelist") {
        $control->serviceList($model);
    } else if ($m == "getservice") {
        $control->getservice($model);
    } else {
        PrintJSON("", "wrong method!!!", 0);
    }
} catch (Exception $e) {
    print_r($e);
}
