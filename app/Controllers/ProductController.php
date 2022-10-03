<?php

namespace App\Controllers;

use App\Models\Product;
use Core\BaseController;
use Core\DataBase;
use Core\Container;
use Core\Redirect;

class ProductController extends BaseController
{
    private $productModel;

    public function __construct()
    {
        parent::__construct();
        $this->productModel = Container::getModel("Product");
    }
    
    public function index()
    {

        $query = "SELECT tb.* , pt.description as product_type_desc
        FROM  products tb INNER JOIN product_types pt ON pt.product_type_id = tb.product_type_id where tb.status='1' and pt.status='1'";
       
       $this->view->products  = $this->productModel->executeSQL($query);

        $this->setPageTitle('Produto');
        $this->render('product/index', 'layout');
    }


    public function create()
    {

        $query = "select * from product_types tb where tb.status = '1'";
        $this->view->productTypes  = $this->productModel->executeSQL($query);

        $this->setPageTitle('Novo Produto');
        $this->render('product/create', 'layout');
    }

    public function save($request)
    {
        $data = [
            'description' => $request->post->description,
            'product_type_id' => $request->post->product_type_id,
            'unit_price' => $this->getPrice($request->post->unit_price),
            'status' => '1'
        ];    

        $status  = $this->productModel->save($data);
        if($status){
            Redirect::route('/product'); 
        }else{
            echo 'Erro  ao inserir no Banco de dados !';
        }
    }

    private function getPrice($price)
    {
        $price = str_replace('.', '', $price);
        $price = str_replace(',', '.', $price);
        return $price;
    }


    public function edit($id)
    {
        $query = "select * from product_types tb where tb.status = '1'";
        $this->view->productTypes  = $this->productModel->executeSQL($query);
        
        $this->view->product = $this->productModel->find($id);
        $this->setPageTitle('Editar Tipo de Produto :: ' . $this->view->product->description);
        $this->render('product/edit', 'layout');
    }

    public function update($id, $request)
    {                
        $data = [
            'description' => $request->post->description,
            'product_type_id' => $request->post->product_type_id,
            'unit_price' => $this->getPrice($request->post->unit_price),
            'status' => '1'
        ];         
        
        $status  = $this->productModel->update($data, $id);
        if($status){
            Redirect::route('/product'); 
        }else{
            echo 'Erro  ao inserir no Banco de dados !';
        }
    }

    public function delete($id, $request)
    {                
        $data = [
            'status' => '0'
        ];    
        
        $status  = $this->productModel->update($data, $id);
        if($status){
            Redirect::route('/product'); 
        }else{
            echo 'Erro  ao inserir no Banco de dados !';
        }
    }

}