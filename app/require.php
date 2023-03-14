<?php
    // Inclus les bibliothèques depuis le répertorie libraries
    require_once 'libraries/Core.php';
    require_once 'libraries/Controller.php';
    require_once 'libraries/Database.php';

    require_once 'config/config.php';

// Dans le fichier require.php nous allons instancier la classe Core.
// L'instanciation de la classe Core exécutera la méthode contructeur qui affiche le tableau généré à partir de l'URL.

    $init = new Core();