
<div class="container">
    <div class="row">
        <div class="col-12">
            <h1>
                <?php $this->getPageTitle(); ?>
                <a href="/product/create" class="btn btn-primary float-right mt-2">
                    Adicionar Produto
                </a>
            </h1>  
        </div>
        <div class="col-12">
            <table class="table table-striped table-sm">
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Descrição</th>
                        <th scope="col">Tipo de Produto</th>
                        <th scope="col">Valor de Venda Produto</th>
                        <th scope="col">Ações</th>
                    </tr>
                </thead>
                <tbody>
                    <?php  
                            if(isset($this->view->products) && count($this->view->products) > 0):
                                foreach($this->view->products as $product): ?>
                                    <tr>
                                        <td> <?php  echo $product->product_id; ?> </td>
                                        <td> <?php  echo $product->description; ?></td>
                                        <td> <?php  echo $product->product_type_desc; ?></td>
                                        <td class="price"> R$ <?php  echo number_format($product->unit_price, 2, ',', '');  ?></td>
                                        <td> 
                                            <div class="row col-12">
                                                <div class="mr-2">
                                                    <a href="/product/<?php echo $product->product_id; ?>/edit" class="btn btn-outline-primary float-right mt-2"> Editar</a>
                                                </div>
                                                <div>
                                                <a href="/product/<?php echo $product->product_id; ?>/delete" 
                                                    class="btn btn-outline-danger float-right mt-2" 
                                                    onclick="return confirm('Are you sure you want to delete this item?');"> Excluir</a>
                                                </div>
                                            </div>
                                        </td>
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

