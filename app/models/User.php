<?php
class User {
    private $db;

    public function __construct() {
        $this->db = new Database;
    }
    
    public function getUsers() {
        $this->db->query("SELECT * FROM users"); // Prépare la requête
    
        $result = $this->db->resultSet(); // Récupère un tableau d'objets
    
        return $result; // Retourne le résultat
    }
    
}
