<div class="container">

    <h1 class="h1"> 
        <?php $this->getPageTitle(); ?> 
    </h1>


    <form action="/produto/save" method="POST">
        <div class="form-group">
            <label for="DE_PRODUTO">Texto</label>
            <input type="text" class="form-control" name="DE_PRODUTO" id="DE_PRODUTO">
        </div>
        <button type="submit" class="btn btn-primary">Save</button>
    </form>

</div>