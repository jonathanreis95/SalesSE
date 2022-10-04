<div class="container">

    <h1 class="h1"> 
        <?php $this->getPageTitle(); ?> 
    </h1>


    <form id="formProductType" action="/product-type/save" method="POST">
        <div class="form-group">
            <label for="description">Tipo de Produto</label>
            <input type="text" class="form-control" name="description" id="description">
        </div>
        <button type="submit" class="btn btn-primary">Salvar</button>
    </form>

</div>

<script src="/assets/js/productType/index.js"></script>