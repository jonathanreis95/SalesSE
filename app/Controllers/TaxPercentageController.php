<?php

namespace App\Controllers;

use App\Models\TaxPercentage;
use App\Models\ProductType;
use Core\BaseController;
use Core\DataBase;
use Core\Container;
use Core\Redirect;

class TaxPercentageController extends BaseController
{
    private $taxPercentageModel;
    private $productTypeModel;

    public function __construct()
    {
        parent::__construct();
        $this->taxPercentageModel = Container::getModel("TaxPercentage");
    }
    
    public function index()
    {
        
        $this->setPageTitle('Imposto dos tipos de produtos');

        /* $query = "SELECT tb.* , pt.description as product_type_desc
         FROM  taxe_product_types tb INNER JOIN product_types pt ON pt.product_type_id = tb.product_type_id where tb.status='1' and pt.status='1'"; */
         $query = 'SELECT * FROM "V_TAXES"';
        
        $this->view->taxPoductTypes  = $this->taxPercentageModel->executeSQL($query);
        $this->render('tax_percentages/index', 'layout');
    }

    public function show($id)
    {
        $this->setPageTitle('Produto');
        $this->view->taxPoductTypes  = $this->taxPercentageModel->find($id);
        $this->render('tax_percentages/show', 'layout');
    }

    public function create()
    {        
        $query = "select * from product_types tb where tb.status = '1'";
        $this->view->productTypes  = $this->taxPercentageModel->executeSQL($query);
        $this->setPageTitle('Novo Imposto do tipo de produto');
        $this->render('tax_percentages/create', 'layout');
    }

    public function save($request)
    {

        $data = [
            'product_type_id' => $request->post->product_type_id,
            'taxe_type' => $request->post->taxe_type,
            'unit_percentage' => $this->getUnitPrice($request->post->unit_percentage),
            'status' => '1'
        ]; 
        
        $status  = $this->taxPercentageModel->save($data);
        if($status){
            Redirect::route('/tax-percentages'); 
        }else{
            echo 'Erro  ao inserir no Banco de dados !';
        }
    }

    private function getUnitPrice($unitPrice)
    {
        $unitPrice = str_replace('%', '', $unitPrice);
        $unitPrice = str_replace(',', '.', $unitPrice);
        return $unitPrice;
    }

    public function edit($id)
    {
        $query = "select * from product_types tb where tb.status = '1'";
        $this->view->productTypes  = $this->taxPercentageModel->executeSQL($query);
        $this->view->taxPoductTypes = $this->taxPercentageModel->find($id);
        $this->setPageTitle('Editar Imposto do tipo de produto');
        $this->render('tax_percentages/edit', 'layout');
    }

    public function update($id, $request)
    {                
        $data = [
            'product_type_id' => $request->post->product_type_id,
            'taxe_type' => $request->post->taxe_type,
            'unit_percentage' => $this->getUnitPrice($request->post->unit_percentage),
            'status' => '1'
        ];    
        
        $status  = $this->taxPercentageModel->update($data, $id);
        if($status){
            Redirect::route('/tax-percentages'); 
        }else{
            echo 'Erro  ao inserir no Banco de dados !';
        }
    }

    public function delete($id, $request)
    {                
        $data = [
            'status' => '0'
        ];    
        
        $status  = $this->taxPercentageModel->update($data, $id);
        if($status){
            Redirect::route('/tax-percentages'); 
        }else{
            echo 'Erro  ao inserir no Banco de dados !';
        }
    }

}