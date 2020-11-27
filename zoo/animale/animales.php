<?php
class animale{
 
    // database connection and table espece
    private $conn;
    private $table_espece = "animales";
 
    // object properties
    
    public $espece;
    public $commentaire;
    public $sexe;
    public $nom;
 
    // constructor with $db as database connection
    public function __construct($db){
        $this->conn = $db;
    }

    // read Animaless
function read(){
 
    // select all query
    $query = "SELECT
 espece ,nom,commentaire,sexe
            FROM " . $this->table_espece . " animales";
 
    // prepare query statement
    $stmt = $this->conn->prepare($query);
 
    // execute query
    $stmt->execute();
 
    return $stmt;
}


// create product
function create(){
 
    // query to insert record
    $query = "INSERT INTO
                " . $this->table_espece . "
            SET
                espece=:espece, nom=:nom, commentaire=:commentaire, sexe=:sexe, created=:created";
 
    // prepare query
    $stmt = $this->conn->prepare($query);
 
    // sanitize
    $this->espece=htmlspecialchars(strip_tags($this->espece));
    $this->nom=htmlspecialchars(strip_tags($this->nom));
    $this->commentaire=htmlspecialchars(strip_tags($this->commentaire));
    $this->sexe=htmlspecialchars(strip_tags($this->sexe));
    $this->created=htmlspecialchars(strip_tags($this->created));
 
    // bind values
    $stmt->bindParam(":espece", $this->espece);
    $stmt->bindParam(":nom", $this->nom);
    $stmt->bindParam(":commentaire", $this->commentaire);
    $stmt->bindParam(":sexe", $this->sexe);
    $stmt->bindParam(":created", $this->created);
 
    // execute query
    if($stmt->execute()){
        return true;
    }
 
    return false;
     
}


function readOne(){
 
    // query to read single record
    $query = "SELECT *
            FROM  animales
            WHERE  espece =?";
 
    // prepare query statement
    $stmt = $this->conn->prepare( $query );
 
    // bind id of product to be updated
    $stmt->bindParam(1, $this->espece);
 
    // execute query
    $stmt->execute();
 
    // get retrieved row
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
 
    // set values to object properties
    $this->espece = $row['espece'];

    $this->commentaire = $row['commentaire'];
    $this->nom = $row['nom'];
    $this->sexe = $row['sexe'];
}

}
?>