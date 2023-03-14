Hello world ! (from Database.php)

<?php
class Database {
    private $dbHost = "localhost";
    private $dbUser = "root";
    private $dbPass = "";
    private $dbName = "mymvcframework";

// Déclarons la proriété privée $statement qui sera utilisée pour les requêtes :

    private $statement;

// Déclarons la proriété privée $dbHandler qui sera le gestionnaire de la connexion à la BDD (instance de l'objet PDO) : 

    private $dbHandler;

// Déclarons une propriété privée $error qui contiendra un potentiel message d'erreur :

    private $error;

// Implémentons le constructeur qui permet de se connecter à la base de données :


    public function __construct() {
        $conn = 'mysql:host=' . $this->dbHost . ';dbname=' . $this->dbName;
        $options = array(
            PDO::ATTR_PERSISTENT => true,
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
        );
    
        try {
            $this->dbHandler = new PDO($conn, $this->dbUser, $this->dbPass, $options);
        }
        catch(PDOException $e) {
            $this->error = $e->getMessage();
            echo $this->error;
        }
    }
    
// La méthode query() permettra de préparer une requête :

    public function query($sql) {
        $this->statement = $this->dbHandler->prepare($sql);
    }

// La méthode bind() est la méthode qui permet de faire le bind (association) des valeurs :

/* Cette méthode prend trois paramètres :

$parameter : le paramètre à binder
$value : la valeur qui sera bindée
$type : le type (PDO::PARAM_INT, PDO::PARAM_BOOL, PDO::PARAM_NULL, PDO::PARAM_STR). Ce paramètre est facultatif. 
S'il est omis, la méthode choisira le type automatiquement en fonction de la valeur. */

public function bind($parameter, $value, $type = null) {
    switch(is_null($type)) {
        case is_int($value):
            $type = PDO::PARAM_INT;
            break;
        case is_bool($value):
            $type = PDO::PARAM_BOOL;
            break;
        case is_null($value):
            $type = PDO::PARAM_NULL;
            break;
        default:
            $type = PDO::PARAM_STR;
    }

    $this->statement->bindValue($parameter, $value, $type);
}

// La méthode execute() permettra d'exécuter la requête préparée :

public function execute() {
    return $this->statement->execute();
}

// La méthode resultSet() permettra d'exécuter la requête préparée et récupérer le résultat (c-à-d tous les enregistrements) retourner par le requpete sous forme de tableau d'objets :

    public function resultSet() {
        $this->execute();
        return $this->statement->fetchAll(PDO::FETCH_OBJ);
    }

// La méthode single() sera utilisée dans le cas où un seul enregistrement est attendu de la requête qui sera retourné sous forme d'objet :

public function single() {
    $this->execute();
    return $this->statement->fetch(PDO::FETCH_OBJ);
}

// La méthode rowCount() permettra de retourner le nombre de lignes affectées par l'exécution de la requête :

public function rowCount() {
    return $this->statement->rowCount();
}

};
