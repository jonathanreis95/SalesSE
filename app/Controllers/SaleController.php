<?php

namespace App\Controllers;

use App\Models\Sale;
use Core\BaseController;
use Core\DataBase;
use Core\Container;
use Core\Redirect;

class SaleController extends BaseController
{

    private $saleModel;

    public function __construct()
    {
        parent::__construct();
        $this->saleModel = Container::getModel("Sale");
    }
    

    public function index()
    {

        $query = "SELECT 
		sp.sale_id, sp.sale_product_id, sp.unit_price, sp.unit_price_tax, sp.quantity, sp.total_price, sp.total_price_tax, sp.description, 
		pr.product_id, pr.description
        FROM  sale_products sp 
        INNER JOIN products pr ON pr.product_id = sp.product_id
		  where sp.status = 1 and pr.status = 1 
		  ORDER BY sp.sale_id desc";
        $this->view->saleProducts  = $this->saleModel->executeSQL($query);

        $this->setPageTitle('Vendas');
        $this->view->sales  = $this->saleModel->findAll();
        $this->render('sales/index', 'layout');
    }

    public function create()
    {

        $query = "select * from products tb where tb.status = '1'";
        $this->view->products  = $this->saleModel->executeSQL($query);

        $query = "select * from taxe_product_types tb where tb.status = '1' ORDER BY product_type_id desc";
        $this->view->taxes  = $this->saleModel->executeSQL($query);

        $this->setPageTitle('Nova Venda');
        $this->render('sales/create', 'layout');
    }

    public function save($request)
    {

        $objSale = json_decode($request->post->jsonDatas);
        $status = true;
        $dataSale = [
            'total_price' => $this->getPrice($objSale->Sale->total_price),
            'total_taxes' => $this->getPrice($objSale->Sale->total_taxes),
            'description' => $objSale->Sale->description_sale,            
            'status' => '1'
        ];    
        $saleID  = $this->saleModel->save($dataSale, null, true); 

        $saleID  = 4;
        if($saleID > 0):
            if(isset($objSale->Products)):
                foreach($objSale->Products as $Products):
                    $dataProductSale = [
                        'sale_id' => $saleID,
                        'product_id' => $Products->ProductID,
                        'unit_price' => $this->getPrice($Products->Price),
                        'unit_price_tax' => $this->getPrice($Products->PriceTax),
                        'quantity' => $Products->Quantity,    
                        'total_price' => $this->getPrice($Products->Total),
                        'total_price_tax' => $this->getPrice($Products->TotalTax),                            
                        'description' => $Products->ProductDesc,            
                        'status' => '1'
                    ]; 

                    $saleID  = $this->saleModel->save($dataProductSale, 'sale_products', false);
                    if(!$saleID){
                        $status = false;  
                    }
                endforeach;    
            endif;    
        else:
            $status = false;   
        endif;    
        
        if($status){
            Redirect::route('/sales'); 
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
    
}