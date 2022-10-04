
<div class="container">
    <div class="row">
        <div class="col-12">
            <h1>
                <?php $this->getPageTitle(); ?>
                <a href="/tax-percentage/create" class="btn btn-primary float-right mt-2">
                    Adicionar imposto
                </a>
            </h1>  
        </div>
        <div class="col-12">
            <table class="table table-striped table-sm">
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Tipo de Produto</th>
                        <th scope="col">Imposto</th>
                        <th scope="col">Porcentual</th>
                        <th scope="col">actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php  
                            if(isset($this->view->taxPoductTypes) && count($this->view->taxPoductTypes) > 0):
                                foreach($this->view->taxPoductTypes as $TaxPoductType): ?>
                                    <tr>
                                        <td> <?php  echo $TaxPoductType->taxe_product_type_id; ?> </td>
                                        <td> <?php  echo $TaxPoductType->product_type_desc; ?></td>
                                        <td> <?php  echo $TaxPoductType->taxe_type; ?></td>
                                        <td> <?php  echo str_replace('.', ',', $TaxPoductType->unit_percentage) . '%'; ?></td>
                                        <td> 
                                            <div class="row col-12">
                                                <div class="mr-2">
                                                    <a href="/tax-percentage/<?php echo $TaxPoductType->taxe_product_type_id; ?>/edit" class="btn btn-outline-primary float-right mt-2"> Editar</a>
                                                </div>
                                                <div>
                                                <a href="/tax-percentage/<?php echo $TaxPoductType->taxe_product_type_id; ?>/delete" 
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
                                        <td colspan="5" class="text-center"> Nenhum registro encontrado ! </td>                                        
                                    </tr>  
                        <?php
                        endif; ?>
                </tbody>
            </table>
        </div>
    </div>
  

  
</div>

