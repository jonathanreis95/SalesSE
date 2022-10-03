
<div class="container">
<p id="jsonSaleProducts" hidden><?php echo(isset($this->view->saleProducts) ? json_encode($this->view->saleProducts) : '') ?></p>
    <div class="row">
        <div class="col-12">
            <h1>
                <?php $this->getPageTitle(); ?>
                <a href="/sale/create" class="btn btn-primary float-right mt-2">
                    Nova Venda
                </a>
            </h1>  
        </div>
        <div class="col-12">
            <table id="table_id" class="table table-striped table-sm">
                <thead>
                    <tr>
                        <th scope="col"></th>                        
                        <th scope="col">#</th>                        
                        <th scope="col">Valor de Venda Produto</th>
                        <th scope="col">Valor de Taxas</th>
                    </tr>
                </thead>
                <tbody>
                    <?php  
                            if(isset($this->view->sales) && count($this->view->sales) > 0):
                                foreach($this->view->sales as $sale): ?>
                                    <tr>
                                        <td class="details-control"> </td>
                                        <td> <?php  echo $sale->sale_id; ?> </td>
                                        <td> R$ <?php  echo number_format($sale->total_price, 2, ',', '');  ?></td>
                                        <td> R$ <?php  echo number_format($sale->total_taxes, 2, ',', '');  ?></td>
                                    </tr> 
                    
                           <?php 
                           endforeach; 
                            else: ?>
                                    <tr>                                        
                                        <td colspan="3" class="text-center"> Nenhum registro encontrado ! </td>                                        
                                    </tr>  
                        <?php
                        endif; ?>
                </tbody>
            </table>
        </div>
    </div>
  
</div>


<script src="/assets/js/sales/list.js"></script>

