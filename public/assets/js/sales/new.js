$(document).ready( function () {

    var ProductSelect;
    var ProductList;
    var TaxesList;
    var frmProductValidate;
    var DataSet = [];
    var arrProduct = [];
    var dtProductsList;

    function FunctionsSaleList(){

        function save(){
    
            let total_price = $('[name=total_price]').val();
            total_price = (total_price != ''? total_price: 0);

            let total_taxes = $('[name=total_price_tax]').val();
            total_taxes = (total_taxes != ''? total_taxes: 0);

            let description_sale = $('[name=sale_descrition]').val();
         
            var Sale = {
                'total_price': total_price,
                'total_taxes': total_taxes,
                'description_sale': description_sale
            };
    
            var jsonDatas = {
                'Products': arrProduct,
                'Sale': Sale
            };

            $('#jsonDatas').val(JSON.stringify(jsonDatas));
            $('#formSaveSale').attr('action', '/sale/save');
            $('#formSaveSale').submit();
        }

        function initProductsList() {
            var tblProductsList =  `
             <table id="tblProductsList" class="table w-100">
                <thead>
                    <tr>
                        <th class="col-productID">Codigo</th>
                        <th class="col-productDesc">Produto</th>
                        <th class="col-quantity">Quantidade</th>
                        <th class="col-unitPrice">Valor</th>
                        <th class="col-unitPriceTax">Imposto</th>
                        <th class="col-total">Total</th>
                        <th class="col-totalTax">Total Imposto</th>
                        <th class="col-description">Obs</th>
                    </tr>
                </thead>
                <tbody></tbody>
            </table>
            `;
    
            if(!(dtProductsList == 'undefined' || dtProductsList == null)){
                dtProductsList.destroy();
                $('#tblProductsList').empty();
            }
    
            $('#div-tblProductsList').html('');
            $('#div-tblProductsList').append(tblProductsList);
    
            dtProductsList = $('#tblProductsList').DataTable({
                data: DataSet,
                lengthChange: false,
                lenght: '-1',
                searching: false,
                info: false,
                processing: true,
                columnDefs: [
                    {
                        targets: 'col-productID',
                        visible:false,
                        render: function (data, type, row, meta) {
                            return data;
                        }
                    },
                    {
                        targets: 'col-quantity',
                        className: 'text-center',
                        render: function (data, type, row, meta) {
                            return parseInt(data);
                        }
                    },
                    {
                        targets: 'col-unitPriceTax',
                        className: 'text-center',
                        render: function (data, type, row, meta) {
                            return $().money(data, {commas: true, symbol: "R$ "}, true);
                        }
                    },
                    {
                        targets: 'col-total',
                        className: 'text-center',
                        render: function (data, type, row, meta) {
                            return $().money(data, {commas: true, symbol: "R$ "}, true);
                        }
                    },
                    {
                        targets: 'col-totalTax',
                        className: 'text-center',
                        render: function (data, type, row, meta) {
                            return $().money(data, {commas: true, symbol: "R$ "}, true);
                        }
                    }    
                ]
            });
        }

        function fillProductSelect() {

            let all = TaxesList.filter((t) => {
                return (t.product_type_id != 0 && t.product_type_id == ProductSelect.product_type_id)
            });

            let somaPercentage = all.reduce((accumulator, object) => {
                return parseFloat(accumulator) + parseFloat(object.unit_percentage);
              }, 0);

            ProductSelect.unit_taxe_percentage = somaPercentage;
            ProductSelect.unit_taxe_price = parseFloat(ProductSelect.unit_price) * (parseFloat(somaPercentage)/100);


            $('[name=unit_price]').val($().money(ProductSelect.unit_price, {commas: true}, true));

            $('[name=unit_price_tax]').val($().money(ProductSelect.unit_taxe_price, {commas: true}, true));
    
            $('[name=quantity]').focus();
        }

        function calcUnitVal(){
            let quantidade = $('[name=quantity]').val();
            let valorUnitario = $('[name=unit_price]').val().replace(/[.]/g,'').replace(/[,]/g,'.');
            let Total = 0;
            let TotalTax = 0;
            if(quantidade > 0 && valorUnitario > 0){
                Total = parseFloat(parseFloat(quantidade) * parseFloat(valorUnitario)).toFixed(2);
                TotalTax = parseFloat(parseFloat(Total) * (parseFloat(ProductSelect.unit_taxe_percentage)/100)).toFixed(2);
                Total = $().money(Total, {commas: true}, true);
                TotalTax = $().money(TotalTax, {commas: true}, true);
                $('[name=total]').val(Total);
                $('[name=unit_price_tax]').val(TotalTax);
            }
        }

        function addProduct(){

            let Quantity = $('[name=quantity]').val();
            let UnitPrice = $('[name=unit_price]').val();//.replace(/[.]/g,'').replace(/[,]/g,'.');
            UnitPrice = (UnitPrice != ''? UnitPrice: 0);
            let TotalTax = $('[name=unit_price_tax]').val();//.replace(/[.]/g,'').replace(/[,]/g,'.');
            TotalTax = (TotalTax != ''? TotalTax: 0);

            let Total = $('[name=total]').val();//.replace(/[.]/g,'').replace(/[,]/g,'.');
            Total = (Total != ''? Total: 0);
            let ProdutoDescription = $('[name=product_description]').val();
    
            let DataSetArray = [
                ProductSelect.product_id,
                ProductSelect.description,
                Quantity,
                UnitPrice,
                ProductSelect.unit_taxe_price,
                Total,
                TotalTax,
                ProdutoDescription
            ];
            DataSet.push(DataSetArray);
    
            let Product = {
                'ProductID': ProductSelect.product_id,
                'Quantity': Quantity,
                'UnitPrice': UnitPrice ,
                'UnitPriceTax': ProductSelect.unit_taxe_price,
                'ProdutoDescription': ProdutoDescription,
                'Total': Total,
                'TotalTax': TotalTax,
            };
            arrProduct.push(Product);

            ProductSelect = '';
    
            cleanInputsProducts();
    
            initProductsList();
    
            initTotaisCalcs();
        }

        function cleanInputsProducts(){
            $('[name=cboProducts]').val('0');
            $('[name=product_description]').val('');
            $('[name=quantity]').val('');
            $('[name=unit_price]').val('');
            $('[name=unit_price_tax]').val('');
            $('[name=total]').val('');
        }

            
        function initTotaisCalcs(){
   
            let SubTotal = 0;
            let Total =  0;
            let TotalTax =  0;
            Object.keys(DataSet).forEach(function (key) {
                SubTotal = parseFloat(SubTotal) + parseFloat(DataSet[key][5]);
                TotalTax = parseFloat(TotalTax) + parseFloat(DataSet[key][6]);
            });

            Total = parseFloat(SubTotal)+parseFloat(TotalTax);

            Total = $().money(Total, {commas: true}, true);
            $('[name=total_price]').val(Total);

            SubTotal = $().money(SubTotal, {commas: true}, true);
            $('[name=subtotal]').val(SubTotal);

            TotalTax = $().money(TotalTax, {commas: true}, true);
            $('[name=total_price_tax]').val(TotalTax);
    

        }

        function events(){
            $('[name=cboProducts]').change(function (e) {
                // $('[name=quantity]').val('');
                // $('[name=unit_price]').val('');
                // $('[name=unit_priceTotal]').val('');
    
                ProductSelect = '';
    
                let product_id = $(this).val();
           
                ProductSelect = ProductList.filter((t) => {
                    return (t.product_id != 0 && t.product_id == product_id)
                })[0];

                if( ProductSelect !==  'undefined' && ProductSelect !==  undefined){
                    fillProductSelect();
                }

                console.log(ProductSelect);
    
            });
    
            $('[name=unit_price]').on('keyup', function(){
                calcUnitVal();
            });
    
            $('[name=quantity]').on('keyup', function(){
                calcUnitVal();
            });
    
            $('#btnAddProduct').on('click', function(){
                let bErro = false;
    
                if (!$('#formCreateProduct').valid()) bErro = true;
    
                Object.keys(DataSet).forEach(function(key){
                    if(DataSet[key][0] == ProductSelect.product_id){
                        alert("Produto já adicionado ");
                        bErro = true;
                    }
                });
    
                if(bErro){
                    return false;
                }
    
                addProduct();
            });
    
    
            // future add events delete
            $('body').on('click', '.icon-delete',  function(){
            });
    
    
            $('#btnSaveSale').on('click', function(){
                let bErro = false;
    
                if(arrProduct.length == 0){
                    bErro = true;
                    alert("Necessário Incluir Produto !");
                }
    
                if(bErro){
                    return false;
                }
    
                save();
            });
    
            $('#btnCleanSale').on('click', function(){
                cleanProductList();

                cleanSale();
    
                $('#cboProducts-error').addClass('d-none');
                frmProductValidate.resetForm();
            });
    
            function cleanProductList(){
                cleanInputsProducts();
                arrProduct = [];
                DataSet = [];
                dtProductsList.clear().draw();
                initTotaisCalcs();
            }
    
            function cleanSale(){
                $('[name=cboProducts]').val('0');
                $('[name=product_description]').val('');
                $('[name=quantity]').val('');
                $('[name=unit_price]').val('');
                $('[name=unit_price_tax]').val('');
                $('[name=total]').val('');
                $('[name=subtotal]').val('');
                $('[name=total_price_tax]').val('');
                $('[name=total_price]').val('');
                $('[name=sale_descrition]').val('');
            }
    
        }

        function init(){
            ProductList = JSON.parse($('#jsonProducts').text());
            $('#jsonProducts').remove();

            TaxesList = JSON.parse($('#jsonTaxes').text());
            $('#jsonTaxes').remove();
    
            $('.price').mask("#.##0,00", {reverse: true});
    
            $(".number").mask('0000000000');
    
            //
            function initValidationProduct(){
                $.validator.addMethod('requiredCombo', function (value, element, args) {
                    return (value > 0)
                }, 'Este campo é obrigatório');
    
                frmProductValidate = $('#formCreateProduct').validate({
                    errorClass: 'text-danger is-invalid',
                    rules: {
                        quantity: "required",
                        unit_price: "required",
                        cboProducts: 'requiredCombo',
                    },
                    messages: {
                        quantity: "Informe a quantidade",
                        unit_price: "Informe um Valor",
                    },
                    invalidHandler: function (form, validator) {
                        var erros = validator.numberOfInvalids();
                        if (erros) {
                            validator.errorList[0].element.focus();
                        }
                    }
                });
            }
    
            initValidationProduct(); 
    
            initProductsList();
        }
    

        function main(){

            events();
    
            init();
        }

        main();
    }
    FunctionsSaleList();
});