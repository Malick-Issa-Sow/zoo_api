<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
 
// get database connection
include_once '../configuation/database.php';
 
// instantiate animales object
include_once '../objects/animales.php';
 
$database = new Database();
$db = $database->getConnection();
 
$animales = new animales($db);
 
// get posted data
$data = json_decode(file_get_contents("php://input"));
 
// make sure data is not empty
if(
    !empty($data->espece) &&
    !empty($data->nom) &&
    !empty($data->commentaire) &&
    !empty($data->datenaissance)
){
 
    // set animales property values
    $animales->espece = $data->espece;
    $animales->nom = $data->nom;
    $animales->comentaire = $data->comentaire;
    $animales->datenaissance = $data->datenaissance;
    $animales->created = date('Y-m-d H:i:s');
 
    // create the animales
    if($animales->create()){
 
        // set response code - 201 created
        http_response_code(201);
 
        // tell the user
        echo json_encode(array("message" => "animales was created."));
    }
 
    // if unable to create the animales, tell the user
    else{
 
        // set response code - 503 service unavailable
        http_response_code(503);
 
        // tell the user
        echo json_encode(array("message" => "Unable to create animales."));
    }
}
 
// tell the user data is incomplete
else{
 
    // set response code - 400 bad request
    http_response_code(400);
 
    // tell the user
    echo json_encode(array("message" => "Unable to create animales. Data is incomplete."));
}
?>