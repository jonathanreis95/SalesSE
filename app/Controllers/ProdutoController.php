<?php

namespace App\Controllers;

use App\Models\Produto;
use Core\BaseController;
use Core\DataBase;
use Core\Container;
use Core\Redirect;

class ProdutoController extends BaseController
{

    private $produtoModel;

    public function __construct()
    {
        parent::__construct();
        $this->produtoModel = Container::getModel("Produto");
    }
    

    public function index()
    {
        $this->setPageTitle('Produtos');
        $this->view->produtos  = $this->produtoModel->findAll();
        $this->render('produtos/index', 'layout');
    }

    public function create()
    {
        $this->setPageTitle('Novo Produto');
        $this->render('produtos/create', 'layout');
    }

    public function save($request)
    {
        $data = [
            'DE_PRODUTO' => $request->post->DE_PRODUTO
        ];    
        $status  = $this->produtoModel->save($data);
        if($status){
            Redirect::route('/produto'); 
        }else{
            echo 'Erro  ao inserir no Banco de dados !';
        }
    }

    public function edit($id)
    {
        $this->view->produto = $this->produtoModel->find($id);
        $this->setPageTitle('Editar Produto :: ' . $this->view->produto->DE_PRODUTO);
        $this->render('produtos/edit', 'layout');
    }

    public function update($id, $request)
    {                
        $data = [
            'DE_PRODUTO' => $request->post->DE_PRODUTO
        ];    
        $status  = $this->produtoModel->update($data, $id);
        if($status){
            Redirect::route('/produto'); 
        }else{
            echo 'Erro  ao inserir no Banco de dados !';
        }
    }
    
}