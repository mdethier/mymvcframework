Hello world ! (from Core.php)

<?php
    class Core {

// Dans la classe Core, nous ajoutons la propriété protégée $currentController qui indique le conrtrôleur à utiliser. Par défaut, ce sera le controleur Pages.
        protected $currentController = 'Pages';

// nous ajoutons la propriété protégée $currentMethod qui indique la méthode du contrôleur à appeler, ce qui correspond à l'action à effectuer. Par défaut, c'est la méthode index qui sera appelée.


        protected $currentMethod = 'index';

// Nous ajoutons une troisième propriété protégée $params qui est un tableau contenant les paramètres à passer à la méthode appelée.

        protected $params = [];

// Nous allons implémenter la méthode getUrl() dans la classe Core qui permettra de déterminer le contrôleur, la méthode et les paramètres à partir de l'URL.

        public function getUrl() {
            if(isset($_GET['url'])) {
                $url = rtrim($_GET['url'], '/');
                $url = filter_var($url, FILTER_SANITIZE_URL);
                $url = explode('/', $url);
                return $url;
            }
        }
// Dans un premier, nous vérifions si des paramètres sont passés dans l'URL. Si le dernier caractère de l'URL est un '/', celui-ce est retiré. L'URL est ensuite filtré afin de supprimer tous les caractères qui ne sont pas autorisés dans une URL ($, *, etc...). Enfin, un tableau est crée à partir de l'URL contenant les éléments de l'URL séparés par des /. C'est ce tableau qui est retourné par la méthode. 

// Pour tester le bon fonctionnement de la méthode, nous implémentons un constructeur dans la classe Core qui affichera ce tableau en appelant la fonction getUrl().
    //    public function __construct() {
    //        print_r($this->getUrl());
    //    }


// Voici le code complet de la méthode __construct() :

public function __construct() {
    $url = $this->getUrl();

    if(file_exists('../app/controllers/' . ucwords($url[0]) . '.php')) { 
        $this->currentController = ucwords($url[0]);
        unset($url[0]);
    }

    require_once '../app/controllers/' . $this->currentController . '.php';
    $this->currentController = new $this->currentController;


 // Nous commençons par vérifier si le nom d'une méthode est précisée dans l'URL :

   
if(isset($url[1])) {
    // Pour rappel, la méthode getUrl()retourne un tableau dont le premier élément est le contrôleur, le deuxième est la méthode et les suivants les paramètres.
// Ensuite, nous vérifions si la méthode définie existe bien dans la classe du contrôleur :


    if( method_exists($this->currentController, $url[1])) {

    // Si la méthode existe, nous remplaçons la méthode par défaut (qui est index pour rappel) et supprimer le deuxième élément du tableau :


        $this->currentMethod = $url[1];
        unset($url[1]);
    }
}
// Il reste à récupérer les paramètres dans l'URL s'il y en a :
$this->params = $url ? array_values($url) : [];

// Puis nous appelons la méthode du contrôleur avec les paramètres :
call_user_func_array([$this->currentController, $this->currentMethod], $this->params);
}
    }