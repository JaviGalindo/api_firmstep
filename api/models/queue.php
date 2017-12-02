<?php

/**
 * Class of Queue
 * This class connects to DB to retrieve and create queue data.
 */
class Queue{
    private $conn;
    private $table_name ="queue";

    public $id;
    public $firstName;
    public $lastName;
    public $organization;
    public $type;
    public $service;
    public $queuedDate;
    public $serviceValues = ["Council Tax", "Benetifs", "Rent"];
    public $typeValues = ["Citizen", "Anonymous"];

    public function __construct($db){
        $this->conn = $db;
    }

    /**
     * Retrieve rows from queue table of database
     * @param {string} $type  This param is used to filter rows. Values (Citizen or Anonymous)
     */
    function get($type = NULL){
        $where = "";
        if(!is_null($type)){
            $where = " WHERE type=:type";            
        }

        $query = "SELECT * FROM ".$this->table_name." $where";

        $result = $this->conn->prepare($query);
        if(!is_null($type)){
            $type = htmlspecialchars(strip_tags($type));
            $result->bindParam(":type", $type);
        }
        $result->execute();
        return $result;
    }

    /**
     * Retrieve rows from queue table of database
     * @param {string} $type  Type of the queue. Values (Citizen or Anonymous).
     * @param {string} $service  Service of the queue. Values (Council Tax, Benetifs, Rent).
     * @param {string} $firstName  Firstname if type is Citizen.
     * @param {string} $lastName  LastName if type is lastName.
     * @param {string} $organization  Name of the organization.
     */
    function create($type, $service, $firstName = null, $lastName = null, $organization = null) {
        $query = "INSERT INTO ".$this->table_name." SET 
            type=:type, 
            firstName=:firstName, 
            lastName=:lastName,
            organization=:organization, 
            service=:service
        ";

        $result = $this->conn->prepare($query);

        $this->type = htmlspecialchars(strip_tags($type));
        $this->service = htmlspecialchars(strip_tags($service));
        $this->firstName = htmlspecialchars(strip_tags($firstName));
        $this->lastName = htmlspecialchars(strip_tags($lastName));
        $this->organization = htmlspecialchars(strip_tags($organization));

        $result->bindParam(":type", $this->type);
        $result->bindParam(":firstName", $this->firstName);
        $result->bindParam(":lastName", $this->lastName);
        $result->bindParam(":organization", $this->organization);
        $result->bindParam(":service", $this->service);
        if($result->execute()){
            return true;
        } else {
            return false;
        }
    }
}