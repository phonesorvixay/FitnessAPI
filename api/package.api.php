<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
//error_reporting(E_ALL);

include "../controllers/package.controller.php";
include_once "../models/package.model.php";

try {
    Initialization();
    $m = getallheaders()['m'];

    $json = json_decode(file_get_contents('php://input'), true);
    $control = new PackageController();

    if ($m == "addpackage") {
        $model = new PackageModel($json);
        $model->validatePackageName();
        $model->validatePrice();
        $control->addPackage($model);
    } else if ($m == "updatepackage") {
        $model = new PackageModel($json);
        $model->checkId();
        $model->validatePackageName();
        $model->validatePrice();
        $control->updatePackage($model);
    } else if ($m == "deletepackage") {
        $model = new PackageModel($json);
        $model->checkdelete();
        $control->deletepackage($model);
    } else if ($m == "packagelist") {
        $model = new PackageModel($json);
        $control->packageList($model);
    } else if ($m == "getpackage") {
        $model = new PackageModel($json);
        $control->getPackage($model);
    } else {
        PrintJSON("", "wrong method!!!", 0);
    }
} catch (Exception $e) {
    print_r($e);
}
