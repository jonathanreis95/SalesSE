
<div class="container">
    <h1>
        <?php $this->getPageTitle(); ?>
        <a href="/produto/create" class="btn btn-primary pull-right">
            <i class="glyphicon glyphicon-plus-sign"></i> Novo Produto
        </a>
    </h1>    

    <?php  
        if(isset($this->view->produtos)):
            foreach($this->view->produtos as $produto): ?>
                <h3>
                    <?php  echo $produto->DE_PRODUTO; ?>
                </h3>
    <?php endforeach; 
        endif; ?>
</div>

