<?php 
header("Access-Control-Allow-Origin: *");
header("Content-type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

include_once "../config/database.php";
include_once "../models/queue.php";

$database = new Database();
$db = $database->getConnection();

$queue = new Queue($db);

//checkin if params are correct.

if(!isset($_POST["type"]) || !in_array($_POST["type"], $queue->typeValues)) {
    echo json_encode(array(
        "status" => "Error",
        "data" => "The value of type is wrong"
    ));
    exit;
}

if(!isset($_POST["service"]) || !in_array($_POST["service"], $queue->serviceValues)) {
    echo json_encode(array(
        "status" => "Error",
        "data" => "The value of service is wrong"
    ));
    exit;
}

if($_POST["type"] === "Citizen" && (!isset($_POST["firstName"]) || $_POST["firstName"] === "" || !isset($_POST["lastName"]) || $_POST["lastName"] === "")){
    echo json_encode(array(
        "status" => "Error",
        "data" => "If type is Citizen you should fill FirstName and Lastname fields"
    ));
    exit;
}

if($queue->create($_POST["type"],$_POST["service"],$_POST["firstName"],$_POST["lastName"],$_POST["organization"])){
    echo json_encode(array(
        "status" => "Success",
        "data" => "The data has been saved in DB"
    ));
} else {
    echo json_encode(array(
        "status" => "Error",
        "data" => "Error saving data"
    ));
}
