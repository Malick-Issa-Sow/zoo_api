<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: access");
header("Access-Control-Allow-Methods: GET");
header("Access-Control-Allow-Credentials: true");
header('Content-Type: application/json');
 
// include database and object files
include_once '../configuration/database.php';
include_once '../animale/animales.php';
 
// get database connection
$database = new Database();
$db = $database->getConnection();
 
// prepare animale object
$animale = new animale($db);
 
// set ID property of record to read
$animale->espece = isset($_GET['espece']) ? $_GET['espece'] : die();
 
// read the details of animale to be edited
$animale->readOne();
 
if($animale->espece!=null){
    // create array
    $animale_arr = array(
        
        "espece" => $animale->espece,
        "nom" => $animale->nom,
        "sexe" => $animale->sexe,
        "datenaissance" => $animale->datenaissance
 
    );
 
    // set response code - 200 OK
    http_response_code(200);
 
    // make it json format
    echo json_encode($animale_arr);
}
 
else{
    // set response code - 404 Not found
    http_response_code(404);
 
    // tell the user animale does not exist
    echo json_encode(array("message" => "animale does not exist."));
}
?>