<div class="container">

<p id="jsonProducts" hidden><?php echo(isset($this->view->products) ? json_encode($this->view->products) : '') ?></p>
<p id="jsonTaxes" hidden><?php echo(isset($this->view->taxes) ? json_encode($this->view->taxes) : '') ?></p>

<div  class="row">
    <div class="col-8 row">
        <div class="col-12">
            <div class="card mb-4">
                <div class="card-header"></div>
                <div class="card-body">

                    <form id="formSaveSale" method="post" action="#">
                        <input type="hidden" id="jsonDatas" name="jsonDatas" value=""/>
                    </form>

                    <form id="formCreateProduct" method="post" action="#">

                        <input type="hidden" id="ObjectData" />

                        <div class="row">
                            <div class="col-12">
                                <div class="form-group">
                                    <label for="cboProducts">Produto</label>
                                    <select data-live-search="true" class="form-control selectpicker" name="cboProducts" id="cboProducts">
                                        <option value="0">-- SELECIONE --</option>
                                        <?php
                                        if(isset($this->view->products)):
                                            foreach ($this->view->products as $products): ?>
                                                <option value="<?php echo $products->product_id; ?>"><?php echo $products->description; ?></option>
                                            <?php endforeach;
                                        endif;?>
                                    </select>
                                </div>
                            </div>

                            <div class="col-12">
                                <div class="form-group">
                                    <label for="product_description">Observação</label>
                                    <input autocomplete="no" type="text" class="form-control" name="product_description" id="product_description" 
                                    placeholder="Informações adicionais do Produto">
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-12 col-md-2">
                                <div class="form-group">
                                    <label for="quantity">Quantidade</label>
                                    <input autocomplete="no" type="text" class="form-control number" name="quantity" id="quantity" placeholder="00">
                                </div>
                            </div>
                            <div class="col-12 col-md-2">
                                <div class="form-group">
                                    <label for="unit_price">Valor</label>
                                    <input autocomplete="no" type="text" class="form-control price" name="unit_price" id="unit_price" placeholder="R$ 00,00">
                                </div>
                            </div>
                            <div class="col-12 col-md-2">
                                <div class="form-group">
                                    <label for="unit_price_tax">Impostos</label>
                                    <input autocomplete="no" type="text" class="form-control price" name="unit_price_tax" id="unit_price_tax" placeholder="R$ 00,00" disabled>
                                </div>
                            </div>
                            <div class="col-12 col-md-2">
                                <div class="form-group">
                                    <label for="total">Total</label>
                                    <input autocomplete="no" type="text" class="form-control price" name="total" id="total" placeholder="R$ 00,00" disabled>
                                </div>
                            </div>
                            <div class="col-12 col-md-12 ">
                                <button id="btnAddProduct" class="btn btn-icon btn-3 btn-primary w-100" type="button">
                                    <span class="btn-inner--icon"><i class="fas fa-plus"></i></span>
                                    <span class="btn-inner--text">Add</span>
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="col-4 row">
        <div class="col-12">
            <div class="card mb-4">
                <div class="card-header">Valores e Informações da venda</div>
                <div class="card-body">
                    <div class="row">
                    <div class="col-4">
                            <div class="form-group">
                                <label for="subtotal">Sub total</label>
                                <input autocomplete="no" type="text" class="form-control" name="subtotal" id="subtotal" placeholder="R$ 0,00" disabled>
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="form-group">
                                <label for="total_price_tax">Impostos</label>
                                <input autocomplete="no" type="text" class="form-control" name="total_price_tax" id="total_price_tax" placeholder="R$ 0,00" disabled>
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="form-group">
                                <label for="total_price">Total</label>
                                <input autocomplete="no" type="text" class="form-control" name="total_price" id="total_price" placeholder="R$ 0,00" disabled>
                            </div>
                        </div>

                        <div class="col-12">
                            <div class="form-group">
                                <label for="sale_descrition">Informações da venda</label>
                                <input autocomplete="no" type="text" class="form-control" name="sale_descrition" id="sale_descrition" placeholder="Observação da venda">
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>

        <div class="col-12">
           
        </div>
    </div>

    <div class="col-12">
        <div class="card mb-4">
            <div class="card-header">Produtos</div>
            <div class="card-body">
                <div id="div-tblProductsList" class="table-responsive"></div>
            </div>
        </div>
    </div>

    <div class="col-12">
        <button id="btnCleanSale" class="btn btn-icon btn-3 btn-secondary" type="button">
            <span class="btn-inner--icon"><i class="fas fa-times"></i></span>
            <span class="btn-inner--text">Limpar</span>
        </button>

        <button id="btnSaveSale" class="btn btn-icon btn-3 btn-primary" type="button">
            <span class="btn-inner--icon"><i class="fas fa-check"></i></span>
            <span class="btn-inner--text">Gravar</span>
        </button>
    </div>

</div>

</div>


<script src="/assets/js/sales/new.js"></script>
