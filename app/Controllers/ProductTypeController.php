<?php

namespace App\Controllers;

use App\Models\ProductType;
use Core\BaseController;
use Core\DataBase;
use Core\Container;
use Core\Redirect;

class ProductTypeController extends BaseController
{
    private $productTypeModel;

    public function __construct()
    {
        parent::__construct();
        $this->productTypeModel = Container::getModel("ProductType");
    }
    
    public function index()
    {
        $this->setPageTitle('Tipos de Produto');
        $this->view->productTypes  = $this->productTypeModel->findAll();
        $this->render('product_types/index', 'layout');
    }

    public function show($id)
    {
        $this->setPageTitle('Produto');
        $this->view->productType  = $this->productTypeModel->find($id);
        $this->render('product_types/show', 'layout');
    }

    public function create()
    {
        $this->setPageTitle('Novo Tipo de Produto');
        $this->render('product_types/create', 'layout');
    }

    public function save($request)
    {
        $data = [
            'description' => $request->post->description,
            'status' => '1'
        ];    

        $status  = $this->productTypeModel->save($data);
        if($status){
            Redirect::route('/product-types'); 
        }else{
            echo 'Erro  ao inserir no Banco de dados !';
        }
    }

    public function edit($id)
    {
        $this->view->productType = $this->productTypeModel->find($id);
        $this->setPageTitle('Editar Tipo de Produto :: ' . $this->view->productType->description);
        $this->render('product_types/edit', 'layout');
    }

    public function update($id, $request)
    {                
        $data = [
            'description' => $request->post->description
        ];    
        
        $status  = $this->productTypeModel->update($data, $id);
        if($status){
            Redirect::route('/product-types'); 
        }else{
            echo 'Erro  ao inserir no Banco de dados !';
        }
    }

    public function delete($id, $request)
    {                
        $data = [
            'status' => '0'
        ];    
        
        $status  = $this->productTypeModel->update($data, $id);
        if($status){
            Redirect::route('/product-types'); 
        }else{
            echo 'Erro  ao inserir no Banco de dados !';
        }
    }

}