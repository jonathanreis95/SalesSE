<?php

namespace App\Controllers;

use Core\BaseController;

class HomeController extends BaseController
{

    public function index()
    {
        // ROTA E CONTROLLER SOMENTE PARA TESTE
        $this->setPageTitle('Welcome');
        $this->view->nome = "JONATHAN REIS";

        $this->render('home/index', 'layout');
    }
}