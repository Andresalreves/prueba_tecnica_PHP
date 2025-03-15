<?php

require_once __DIR__ . '/../helpers/helper_view.php';

class HomeController {
    public function index() {
        // Cargar la vista principal
        // Tambien se le puede pasar data a la vista View("home",["productos"=>$productos])
        View('home');
    }
}
?>