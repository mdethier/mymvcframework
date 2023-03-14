<?php

class Pages extends Controller {

    private $userModel;

    public function __construct() {
        $this->userModel = $this->model('User');
        
    }
    
    public function index() {

        $users = $this->userModel->getUsers();

        $data = [ // Tableau pour simuler des données qui viendraient du modèle
            'title' => 'Home page',
            'name' => 'toto'
        ];
        $this->view('pages/index', $data);

    }

    public function about() {
        $this->view('pages/about');
    }
    
}
