<?php

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

include_once '../config/database.php';
include_once '../models/queue.php';

$database = new Database();
$db = $database->getConnection();

$queue = new Queue($db);
$type = null;

//checking if type param is set
if(isset($_GET['type'])){
    //if the value is Citizen or Anonymous then $type is this value
    if($_GET['type'] === 'Citizen' || $_GET['type'] === 'Anonymous'){
        $type = $_GET['type'];
    } else { // if this type doesn't exists then return an error
        echo json_encode(array(
            "status" => "Error",
            "data" => "No data found for this type"
        ));
        exit;
    }
}

//retrieve information from DB
$results = $queue->get($type);
$numRows = $results->rowCount();

if($numRows>0){
    $queueArr = array();
    $queueArr["records"] = array();
    //set the array with the information from DB
    while($row = $results->fetch(PDO::FETCH_ASSOC)){
        $queue_row = array(
            "id" => $row['id'],
            "firstName" => $row['firstName'],
            "lastName" => $row['lastName'],
            "organization" => $row['organization'],
            "type" => $row['type'],
            "service" => $row['service'],
            "queueDate" => $row['queuedDate']
        );
        array_push($queueArr["records"], $queue_row);
    }
    //return json encoded data
    echo json_encode($queueArr);
} else {
    echo json_encode(array(
        "status" => "Error",
        "data" => "No data was found in Database"
    ));
}