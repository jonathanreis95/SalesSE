<div class="container">

    <h1 class="h1"> 
        <?php $this->getPageTitle(); ?> 
    </h1>


    <form id="formProduct" action="/product/save" method="POST">

        <div class="form-group">
            <label for="description">Descrição do Produto</label>
            <input type="text" class="form-control" name="description" id="description">
        </div>

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
            <label for="unit_price">Valor de Venda</label>
            <input type="text" class="form-control price" name="unit_price" id="unit_price" placeholder="R$ ..">
        </div>
        <button type="submit" class="btn btn-primary">Salvar</button>
    </form>
</div>



<script src="/assets/js/products/index.js"></script>
