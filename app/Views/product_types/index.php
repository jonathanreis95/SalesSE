
<div class="container">
    <div class="row">
        <div class="col-12">
            <h1>
                <?php $this->getPageTitle(); ?>
                <a href="/product-type/create" class="btn btn-primary float-right mt-2">
                    Adicionar Tipo de Produto
                </a>
            </h1>  
        </div>
        <div class="col-12">
            <table class="table table-striped table-sm">
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Descrição</th>
                        <th scope="col">Ações</th>
                    </tr>
                </thead>
                <tbody>
                    <?php  
                            if(isset($this->view->productTypes) && count($this->view->productTypes) > 0):
                                foreach($this->view->productTypes as $productType): ?>
                                    <tr>
                                        <td> <?php  echo $productType->product_type_id; ?> </td>
                                        <td> <?php  echo $productType->description; ?></td>
                                        <td> 
                                            <div class="row col-12">
                                                <div class="mr-2">
                                                    <a href="/product-type/<?php echo $productType->product_type_id; ?>/edit" class="btn btn-outline-primary float-right mt-2"> Editar</a>
                                                </div>
                                                <div>
                                                <a href="/product-type/<?php echo $productType->product_type_id; ?>/delete" 
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

