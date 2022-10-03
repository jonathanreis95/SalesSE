<div class="container">

    <h1 class="h1"> 
        <?php $this->getPageTitle(); ?> 
    </h1>


    <form action="/tax-percentage/save" method="POST">

        <div class="form-group">
            <label for="product_type_id">Tipo de Produto</label>
            <select class="form-control" name="product_type_id" id="product_type_id">
            <?php  
                if(isset($this->view->productTypes) && count($this->view->productTypes) > 0):
                    foreach($this->view->productTypes as $ProductTypes): ?>
                    <option value="<?php echo $ProductTypes->product_type_id;  ?>">
                        <?php echo $ProductTypes->description; ?>
                    </option>
            <?php
                endforeach; 
                endif; ?>
                
            </select>
        </div>

        <div class="form-group">
            <label for="taxe_type">Imposto</label>
            <input type="text" class="form-control" name="taxe_type" id="taxe_type" placeholder="ICMS, ETC ..">
        </div>
        <div class="form-group">
            <label for="unit_percentage">Valor Porcentual da Unidade do Imposto</label>
            <input type="text" class="form-control percent" name="unit_percentage" id="unit_percentage" placeholder="2,5%">
        </div>
        <button type="submit" class="btn btn-primary">Salvar</button>
    </form>
</div>



<script src="/assets/js/taxPercentage.js"></script>
