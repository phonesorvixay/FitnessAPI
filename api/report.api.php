<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
//error_reporting(E_ALL);

include_once "../controllers/report.controller.php";
try {

    Initialization();
    $m = GetMethod();

    $json = json_decode(file_get_contents('php://input'), true);
    $tk = (object) $json;
    $control = new ReportTicketController();

    if ($m == "reportservice") {
        $control->reportService($tk);
    } else if ($m == "reportmemberstart") {
        $control->reportMemberStart($tk);
    } else if ($m == "reportmemberend") {
        $control->reportMemberEnd($tk);
    } else {
        PrintJSON("", "method not provided", 0);
    }
} catch (Exception $e) {
    print_r($e);
}
