$(document).ready( function () {
    
    function functionSaleList()
    {

        var SaleProducts;

        function iniProductListTaable(sale_id){
            let  Products = SaleProducts.filter((t) => {
                return (t.sale_id != 0 && t.sale_id == sale_id)
            });

            console.log(Products);

            var tblProductsList =  `
                        <table class="table w-100">
                            <thead class="thead-dark">
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
                            </thead><tbody>
                        `;
                

                if(Products.length > 0){
                    Object.keys(Products).forEach(function (key) {
                        tblProductsList += '<tr>';
                        tblProductsList += '<td>#'+Products[key].product_id+ '</td>';
                        tblProductsList += '<td>'+Products[key].product_desc+ '</td>';
                        tblProductsList += '<td>'+Products[key].quantity+ '</td>';
                        tblProductsList += '<td>'+$().money(Products[key].unit_price, {commas: true, symbol: "R$ "}, true);+ '</td>';
                        tblProductsList += '<td>'+$().money(Products[key].unit_price_tax, {commas: true, symbol: "R$ "}, true)+ '</td>';
                        tblProductsList += '<td>'+$().money(Products[key].total_price, {commas: true, symbol: "R$ "}, true)+ '</td>';
                        tblProductsList += '<td>'+$().money(Products[key].total_price_tax, {commas: true, symbol: "R$ "}, true)+ '</td>';
                        tblProductsList += '<td>'+Products[key].description+ '</td>';
                        tblProductsList += '</tr>';
                    });
                
                }else{
                    tblProductsList += '<td colspan="8">Nenhum Produto Encontrado</td>';
                }

                tblProductsList += '</tbody></table>';

            return tblProductsList;
        }

        function init()
        {

            SaleProducts = JSON.parse($('#jsonSaleProducts').text());
            $('#jsonSaleProducts').remove();

            
            var dt = $('#table_id').DataTable({                
                searching: false,
                order: [[1, 'desc']]
            });
         
            // Array to track the ids of the details displayed rows
            var detailRows = [];
         
            $('#table_id tbody').on('click', 'tr td.details-control', function () {
              
                
                var tr = $(this).closest('tr');
                var row = dt.row(tr);
                var idx = detailRows.indexOf(tr.attr('id'));
                var tblProductsList = '';      
                if (row.child.isShown()) {
                    tr.removeClass('details');
                    row.child.hide();
                   
                    // Remove from the 'open' array
                    detailRows.splice(idx, 1);
                } else {
                    tr.addClass('details');
                    let sale_id = row.data()[1];
                    tblProductsList = iniProductListTaable(sale_id); 
                  
                    row.child(tblProductsList).show();
                }
         
                // Add to the 'open' array
                if (idx === -1) {
                    detailRows.push(tr.attr('id'));
                }

            });
         
            // On each draw, loop over the `detailRows` array and show any child rows
            dt.on('draw', function () {
                detailRows.forEach(function(id, i) {
                    $('#' + id + ' td.details-control').trigger('click');
                });
            });
        }

        init();
    }

    functionSaleList();
    
} );