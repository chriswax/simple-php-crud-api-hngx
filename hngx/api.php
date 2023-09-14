<?php
require_once "config.php";
//require_once "functions.php";
global $conn;

//get the Request method sent from client e.g POST, GET, PUT and DELETE
$allow_method = '';
if (isset($_SERVER['REQUEST_METHOD'])) {
    $allow_method = $_SERVER['REQUEST_METHOD'];
}

//Initialize and get id passed for getUser, Update and delete routes

function esc($value)
{
    global $conn;
    $val = trim($value);
    $val = mysqli_real_escape_string($conn, $val);
    $val = strip_tags($val);
    return $val;
}

$id = 0;
if (isset($_GET['id'])) {
    $id = esc($_GET['id']);   //sanitize
}
//call header functions
header("Content-Type: application/json");
header("Acess-Control-Allow-Origin: *");
header("Acess-Control-Allow-Methods: $allow_method");
header("Acess-Control-Allow-Headers: Acess-Control-Allow-Headers,Content-Type, Acess-Control-Allow-Methods, Authorization");




$dataInput = json_decode(file_get_contents("php://input"), true);

function getPersons()
{
    global $conn;
    $data = array();

    $query = "SELECT * FROM persons";
    $result = mysqli_query($conn, $query) or die("Select Query Failed.");
    $count = mysqli_num_rows($result);

    if ($count > 0) {
        $row = mysqli_fetch_all($result, MYSQLI_ASSOC);
        $data = [
            "data" => $row,
            "message" => "Data Fetched Successfully",
            "status_code" => 200
        ];
    } else {
        $data = [
            "message" => "No Data Found",
            "status_code" => 204
        ];
    }
    echo  json_encode($data);
}

function getPerson()
{
    global $conn, $id;
    $data = array();

    if ($id === 0) {
        $data = [
            "message" => "User Id must be provided",
            "status_code" => 501
        ];
    } else {
        $query = "SELECT * FROM persons WHERE id=$id";
        $result = mysqli_query($conn, $query);
        $count = mysqli_num_rows($result);

        if ($count > 0) {
            $row = mysqli_fetch_all($result, MYSQLI_ASSOC);
            $data = [
                "data" => $row,
                "message" => "Data Fetched Successfully",
                "status_code" => 200
            ];
        } else {
            $data = [
                "message" => "User Data Not Found",
                "status_code" => 204
            ];
        }
    }
    echo  json_encode($data);
}

function createPerson()
{
    global $conn,  $dataInput;
    $data = array();

    $name = $dataInput["name"];
    $name = esc($name);   //sanitize
    $dateAdded = date("Y-m-d H:i:s");

    if ($name == "") {
        $data = [
            "message" => "Person's name is required",
            "status_code" => 501
        ];
    } else {
        $query = mysqli_query($conn, "INSERT INTO persons(name, dateAdded) VALUES ('" . $name . "', '" . $dateAdded . "')") or die("Insert Query Failed");
        if ($query) {
            $data = [
                "message" => "Person Created Successfully",
                "status_code" => 201
            ];
        } else {
            $data = [
                "message" => "Failed, Person Not Created",
                "status_code" => 501
            ];
        }
    }
    echo  json_encode($data);
}

function updatePerson()
{
    global $conn,  $dataInput, $id;
    $data = array();
    $id = $id;
    $name = $dataInput["name"];
    $name = esc($name);   //sanitize
    if ($name == "" || $id == 0) {
        $data = [
            "message" => "Person's name is required",
            "status_code" => 501
        ];
    } else {
        $query = mysqli_query($conn, "UPDATE persons SET name ='" . $name . "' WHERE id='" . $id . "'") or die("Update Query Failed");
        if ($query) {
            $data = [
                "message" => "Person Updated Successfully",
                "status_code" => 200
            ];
        } else {
            $data = [
                "message" => "Failed, Person Not Updated",
                "status_code" => 501
            ];
        }
    }

    echo  json_encode($data);
}


function deletePerson()
{
    global $conn,  $id;
    $id = $id;
    $data = array();

    if ($id == 0) {
        $data = [
            "message" => "User Id must be provided",
            "status_code" => 501
        ];
    } else {
        $query = mysqli_query($conn, "DELETE FROM persons WHERE id='" . $id . "' ");
        if ($query) {
            $data = [
                "message" => "Person Deleted Successfully!",
                "status_code" => 200
            ];
        } else {
            $data = [
                "message" => "Failed, Person Not Deleted",
                "status_code" => 501
            ];
        }
    }
    echo  json_encode($data);
}



//////////####################################################################//////////////////////
//Simple Api that uses get to ndisplay the details of HNG slack details
if ((isset($_GET['slack_name']) && $_GET['slack_name'] != "") && (isset($_GET['track']) && $_GET['track'] != "")) {
    $slackname =  $_GET['slack_name'];
    $track = $_GET['track'];
    getData($slackname, $track);
}

function getData($slackname, $track)
{
    //set time zone
    date_default_timezone_set("Africa/Lagos");
    $utc = gmdate("Y-m-d\TH:i:s\Z");
    $data = [
        "slack_name" => $slackname,
        "current_day" => date('l'),
        "utc_time" => $utc,
        "track" => $track,
        "github_file_url" => "https://github.com/chriswax/hngx/blob/main/api.php",
        "github_repo_url" => "https://github.com/chriswax/hngx",
        "status_code" => 200
    ];
    echo json_encode($data);
}
//////////####################################################################//////////////////////


//call the API functions based on the the request method type
switch ($allow_method) {
    case "GET":
        if ($id == 0 && !isset($_GET['slack_name'])) { //if the id is passed fetch for single user else fetch for all users
            getPersons();
        } elseif (!isset($_GET['slack_name'])) {
            getPerson();
        }
        break;
    case "POST":
        createPerson();
        break;
    case "PUT":
        updatePerson();
        break;
    case "DELETE":
        deletePerson();
        break;
}
