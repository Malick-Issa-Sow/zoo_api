<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
 
// database connection will be here
// include database and object files
include_once '../configuration/database.php';
include_once '../animale/animales.php';
 
// instantiate database and animale object
$database = new Database();
$db = $database->getConnection();
 
// initialize object                                                                                                                                                                                                                                                                                                                                                    
$animale = new animale($db);
 
// read animales will be here

// query animales
$stmt = $animale->read();
$num = $stmt->rowCount();
 
// check if more than 0 record found
if($num>0){
 
    // animales array
    $animales_arr=array();
    $animales_arr["animals"]=array();
 
    // retrieve our table contents
    // fetch() is faster than fetchAll()
    // http://stackoverflow.com/questions/2770630/pdofetchall-vs-pdofetch-in-a-loop
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
        // extract row
        // this will make $row['espece'] to
        // just $espece only
        extract($row);
 
        $animale_item=array(
           
            "espece" => $espece,
            "commentaire" => html_entity_decode($commentaire),
            "sexe" => $sexe,
            "nom" => $nom,
        );
 
        array_push($animales_arr["animals"], $animale_item);
    }
 
    // set response code - 200 OK
    http_response_code(200);
 
    // show animales data in json format
    echo json_encode($animales_arr);
}
 
// no animales found will be here
else{
 
    // set response code - 404 Not found
    http_response_code(404);
 
    // tell the user no animales found
    echo json_encode(
        array("message" => "No animales found.")
    );
}

?>