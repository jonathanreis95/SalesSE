$(document).ready(function(){        
    $('.price').mask("#.##0,00", {reverse: true});
});$(document).ready( function () {


    function funcoesVendaCadastro(){

        var ProductSelect;
        var ProductList;
        var frmProductValidate;
        var DataSet = [];
        var arrProduto = [];
        var dtProductsList;
    
        /******************** PRODUTO ***************/
        function req_save(){
    
            let EspecieCobranca = $('[name=cboEspecieCobranca]').val();
            let ObservacaoPedido = $('[name=inputObservacaoPedido]').val();
            let TipoVenda = $('[name=cboTipoVenda]').val();
            let FormaCobranca = $('[name=inputCondicaoPagamento]').val();
            let Desconto = $('[name=inputDesconto]').val().replace(/[.]/g,'').replace(/[,]/g,'.');
            Desconto = (Desconto != ''? Desconto: 0);
    
            var Venda = {
                'Codigo': 0,
                'PessoaID': 0,
                'NumVenda': 0,
                'Observacao': ObservacaoPedido,
                'TipoVenda': TipoVenda,
                'EspecieCobranca': EspecieCobranca,
                'FormaCobranca': FormaCobranca ,
                'ValorDesconto': Desconto
            };
    
            var Cadastro = {
                'Produtos': arrProduto,
                'Venda': Venda
            };
    
            //Inicia uma requisição AJAX para gravar o pedido
            $.ajax({
                url: base_url('venda/gravar'),
                type: 'post',
                dataType: 'json',
                beforeSend: function () {
                    //modFuncGeral.ativaCarregamento(true);
                },
                data: JSON.stringify(Cadastro)
            }).done(function (r) {
    
                swal.fire({
                    title: "Gravado com Sucesso !! ",
                    text: "",
                    type: 'warning',
                    confirmButtonText: "OK",
                    confirmButtonClass: "btn btn-primary",
                    showConfirmButton: true,
                    timer: 1000
                });
    
                $('#btnLimparPedido').trigger('click');
    
            }).fail(function(error){
                swal.fire({
                    title: 'Erro ao Gravar',
                    text: "",
                    type: 'warning',
                    confirmButtonText: "OK",
                    confirmButtonClass: "btn btn-danger",
                    showConfirmButton: true,
                    timer: 1000
                });
            });
        }
    
        function initCadastroProduto() {
            var tblProductsList =  `
             <table id="tblProductsList" class="table table-store w-100">
                <thead>
                    <tr>
                        <th class="col-codigo">Codigo</th>
                        <th class="col-codProduto text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Cód.</th>
                        <th class="col-produto text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Produto</th>
                        <th class="col-quantidade text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Quantidade</th>
                        <th class="col-valor text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Valor</th>
                        <th class="col-total text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Total</th>
                        <th class="col-obs text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Obs</th>
                        <th class="col-acao">#</th>
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
                        targets: 'col-codigo',
                        visible:false,
                        render: function (data, type, row, meta) {
                            return data;
                        }
                    },
                    {
                        targets: 'col-codProduto',
                        render: function (data, type, row, meta) {
                            return data;
                        }
                    },
                    {
                        targets: 'col-quantidade',
                        className: 'text-center',
                        render: function (data, type, row, meta) {
                            return parseInt(data);
                        }
                    },
                    {
                        targets: 'col-valor',
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
                        targets: 'col-acao',
                        orderable: false,
                        render: function (data, type, row, meta) {
                            return data;
                        }
                    },
    
                ]
            });
        }
    
        function fillProductSelect() {
            $('[name=unit_price]').val($().money(ProductSelect.ValorVenda, {commas: true}, true));
            $('[name=inputCusto]').val($().money(ProductSelect.ValorCusto, {commas: true}, true));
            $('[name=inputEstoque]').val(' ... ');
    
            // Faz uma requisição para buscar o saldo do Estoque
            buscaEstoque();
    
            // Foca no Proximo Campo
            $('[name=quantity]').focus();
        }
    
        // Busca Saldo do Estoque ao Selecionar um produto
        function buscaEstoque(){
            let Filtro = {
                'ProdutoID': $('[name=cboProducts]').val(),
            };
    
            $.ajax({
                url: base_url('produto/saldoestoque'),
                type: 'post',
                dataType: 'json',
                beforeSend: function () {
                    $('#loadingEstoqueAtual').removeClass('d-none');
                },
                complete: function(){
                    $('#loadingEstoqueAtual').addClass('d-none');
                },
                data: JSON.stringify(Filtro)
            }).done(function (Retorno) {
    
                let Quantidade = 0;
                if(Retorno.length > 0){
                    Quantidade = Retorno[0].SaldoQuantidade;
                }
                $('[name=inputEstoque]').val(Quantidade);
    
            }).fail(function(error){
                console.log(error);
            });
    
    
        }
    
        function calcUnitVal(){
            let quantidade = $('[name=quantity]').val();
            let valorUnitario = $('[name=unit_price]').val().replace(/[.]/g,'').replace(/[,]/g,'.');
            let Total = 0;
            if(quantidade > 0 && valorUnitario > 0){
                Total = parseFloat(parseFloat(quantidade) * parseFloat(valorUnitario)).toFixed(2);
                Total = $().money(Total, {commas: true}, true);
                $('[name=total]').val(Total);
            }
        }
    
        // ADICIONA O PRODUTO SELECIONADO
        function addProduto(){
    
            let Quantidade = $('[name=quantity]').val();
            let Valor = $('[name=unit_price]').val().replace(/[.]/g,'').replace(/[,]/g,'.');
            Valor = (Valor != ''? Valor: 0);
            let Total = $('[name=total]').val().replace(/[.]/g,'').replace(/[,]/g,'.');
            Total = (Total != ''? Total: 0);
            let Observacao = $('[name=inputAcrescimo]').val();
    
            // ADD DATA SET PARA A TABELA
            let DataSetRegistro = [
                ProductSelect.Codigo,
                ProductSelect.CodigoProduto,
                ProductSelect.Descricao,
                Quantidade,
                Valor,
                Total,
                Observacao,
                '<span data-codigo="'+ProductSelect.Codigo+'" class="icon-deletar fas fa-times text-danger cursor-pointer"></span>'
            ];
            DataSet.push(DataSetRegistro);
    
            // ADD ARRAY GLOBAL
            let Produto = {
                'ProdutoID': ProductSelect.Codigo,
                'Quantidade': Quantidade,
                'ValorVenda': Valor ,
                'Acrescimo': Observacao,
                'ValorCusto': ProductSelect.ValorCusto,
            };
            arrProduto.push(Produto);
            // Limpa o Objeto Produto Select
            ProductSelect = '';
    
            // Limpa os campos aos adiciona um produto
            limparCamposAddProduto();
    
            // INIT DA TABELA
            initCadastroProduto();
    
            // INIT CALCULADO SUB-TOTAL
            initCalculoSubTotal();
        }
    
        function limparCamposAddProduto(){
            // Limpa os campos do Produto quando adiciona
            $('[name=cboProducts]').val('0').selectpicker('refresh');
            $('[name=inputAcrescimo]').val('');
            $('[name=quantity]').val('');
            $('[name=unit_price]').val('');
            $('[name=inputCusto]').val('');
            $('[name=total]').val('');
            $('[name=inputEstoque]').val('');
        }
    
        function initCalculoSubTotal(){
            let SubTotal = 0;
            Object.keys(DataSet).forEach(function (key) {
                SubTotal = parseFloat(SubTotal) + parseFloat(DataSet[key][5]);
            });
            SubTotal = $().money(SubTotal, {commas: true}, true);
            $('[name=inputSubTotal]').val(SubTotal);
    
            initCalculoTotal();
        }
    
        function initCalculoTotal(){
            let SubTotal = $('[name=inputSubTotal]').val().replace(/[.]/g,'').replace(/[,]/g,'.');
            let Desconto = $('[name=inputDesconto]').val().replace(/[.]/g,'').replace(/[,]/g,'.');
            let Total =  0;
    
            if(SubTotal > 0){
                Total =  parseFloat(SubTotal);
            }
    
            if(Desconto > 0){
                Total = parseFloat(Total) - parseFloat(Desconto);
            }
    
            Total = $().money(Total, {commas: true}, true);
            $('[name=totalVenda]').val(Total);
    
        }
    
        function events(){
            // Função de Change do Produto
            $('[name=cboProducts]').change(function (e) {
                // Zera quantidade e Valor
                // $('[name=quantity]').val('');
                // $('[name=unit_price]').val('');
                // $('[name=unit_priceTotal]').val('');
    
                ProductSelect = '';
    
                let product = $(this).val();
    
                ProductSelect = ProductList.filter((t) => {
                    return (t.Codigo != 0 && t.Codigo == product)
                })[0];
    
                if( ProductSelect !==  'undefined' && ProductSelect !==  undefined){
                    // Preenche as informaçõe do Produto selecionado
                    fillProductSelect();
                }
    
            });
    
            $('[name=unit_price]').on('keyup', function(){
                calcUnitVal();
            });
    
            // EVENTO PRESSIONAR A TECLA ENTER GRAVAR O PRODUTO
            $("[name=unit_price]").keypress(function (e) {
                if (e.which == 13) {
                    $('#btnAddProduct').trigger('click');
                }
            });
    
            $('[name=unit_price]').keydown( function(e) {
                if (e.which == 9) {
                    $('#btnAddProduct').focus();
                    e.preventDefault();
                    e.stopPropagation();
                }
            });
    
            $('[name=quantity]').on('keyup', function(){
                calcUnitVal();
            });
    
            // EVENTO PRESSIONAR A TECLA ENTER GRAVAR O PRODUTO
            $('[name=quantity]').keypress(function (e) {
                if (e.which == 13) {
                    $('#btnAddProduct').trigger('click');
                }
            });
    
            $('[name=inputObservacaoPedido]').keydown( function(e) {
                if (e.which == 9) {
                    $('#btnGravarPedido').focus();
                    e.preventDefault();
                    e.stopPropagation();
                }
            });
    
            // EVENTO CALCULO DO DESCONTO EM CIMA DO SUBTOTAL
            $('[name=inputDesconto]').on('keyup', function(){
                initCalculoTotal();
            });
    
            $('#btnAddProduct').on('click', function(){
                let bErro = false;
    
                // Adiciona validação dos campos
                if (!$('#formCreateProduct').valid()) bErro = true;
    
                // Verifica se o Produto já existe
    
                Object.keys(DataSet).forEach(function(key){
                    if(DataSet[key][0] == ProductSelect.ProdutoID && DataSet[key][3] == LojaNome){
                        swal.fire({
                            title: "Produto já adicionado nesta Loja ! ",
                            text: "",
                            type: 'warning',
                            confirmButtonText: "OK",
                            confirmButtonClass: "btn btn-primary",
                            showConfirmButton: true,
                            timer: 1000
                        });
                        bErro = true;
                    }
                });
    
                if(bErro){
                    return false;
                }
    
                addProduto();
            });
    
            $('#btnAddProduct').keydown( function(e) {
                if (e.which == 9) {
                    $('#inputDesconto').focus();
                    e.preventDefault();
                    e.stopPropagation();
                }
            });
    
            // EVENTO REMOVE ITEM DA GRADE DE PRODUTOS
            $('body').on('click', '.icon-deletar',  function(){
    
                let Codigo = $(this).attr('data-codigo');
                let ItemID = 0;
                var el = this;
    
                for(var i=0; i<arrProduto.length;i++){
                    if (arrProduto[i].ProdutoID == Codigo) {
                        arrProduto.splice(i, 1);
                        i--;
                    }
                }
    
                for(var i=0; i<DataSet.length;i++){
                    if (DataSet[i][0] == Codigo) {
                        DataSet.splice(i, 1);
                        i--;
                    }
                }
    
                // REMOVER DO DATASET
                dtProductsList.row($(el).parent().parent()).remove().draw(false);
    
                // INIT CALCULADO SUB-TOTAL
                initCalculoSubTotal();
            });
    
    
            $('#btnGravarPedido').on('click', function(){
                let bErro = false;
    
                if(arrProduto.length == 0){
                    bErro = true;
                    swal.fire({
                        title: "Necessário Incluir Produto ! ",
                        text: "",
                        type: 'warning',
                        confirmButtonText: "OK",
                        confirmButtonClass: "btn btn-primary",
                        showConfirmButton: true,
                        timer: 1000
                    });
                }
    
                if(bErro){
                    return false;
                }
    
                req_save();
            });
    
            $('#btnLimparPedido').on('click', function(){
                // Limpar todos os Produtos
                limparTbProduto();
    
                // Limpar os demais Campos do Pedido
                limparPedido();
    
                //Limpar
                $('#cboProducts-error').addClass('d-none');
                frmProductValidate.resetForm();
            });
    
            function limparTbProduto(){
                limparCamposAddProduto();
                arrProduto = [];
                DataSet = [];
                dtProductsList.clear().draw();
                initCalculoSubTotal();
            }
    
            function limparPedido(){
    
                // Limpa os campos do Produto quando adiciona
                $('[name=cboProducts]').val('0').selectpicker('refresh');
                $('[name=inputAcrescimo]').val('');
                $('[name=inputCusto]').val('');
                $('[name=quantity]').val('');
                $('[name=unit_price]').val('');
                $('[name=total]').val('');
                $('[name=inputEstoque]').val('');
                $('[name=inputSubTotal]').val('');
                $('[name=inputDesconto]').val('');
                $('[name=totalVenda]').val('');
                $('[name=inputCondicaoPagamento]').val('');
                $('[name=inputObservacaoPedido]').val('');
                $('[name=cboEspecieCobranca]').val('1');
                $('[name=cboTipoVenda]').val('1');
            }
    
        }
    
        function init(){
            Products = JSON.parse($('#jsonProducts').text());
            $('#jsonProducts').remove();
    
           
            $('.price').mask("#.##0,00", {reverse: true});
    
            $(".number").mask('0000000000');
    
            //
            function initValidationProduct(){
                $.validator.addMethod('requiredCombo', function (value, element, args) {
                    return (value > 0)
                }, 'Este campo é obrigatório');
    
                frmProductValidate = $('#formCreateProduct').validate({
                    errorClass: 'inputError is-invalid',
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
    
           // initCadastroProduto();
        }
    
        function index(){
            //alert('Carregado !');
            events();
    
            init();
    
    
        }
    
        index();
    }

    funcoesVendaCadastro();
    
} );