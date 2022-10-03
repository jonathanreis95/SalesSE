$(document).ready( function () {
    
    function functionSaleList()
    {

        var SaleProducts;

        function init()
        {

            SaleProducts = JSON.parse($('#jsonSaleProducts').text());
            $('#jsonSaleProducts').remove();

            var dt = $('#table_id').DataTable({
                processing: true,
                order: [[1, 'asc']],
            });
         
            // Array to track the ids of the details displayed rows
            var detailRows = [];
         
            $('#table_id tbody').on('click', 'tr td.details-control', function () {
              
                var tr = $(this).closest('tr');
                var row = dt.row(tr);
                var idx = detailRows.indexOf(tr.attr('id'));
         
                if (row.child.isShown()) {
                    tr.removeClass('details');
                    row.child.hide();
         
                    // Remove from the 'open' array
                    detailRows.splice(idx, 1);
                } else {
                    tr.addClass('details');
                    let sale_id = row.data()[1];
                    let  Products = SaleProducts.filter((t) => {
                        return (t.sale_id != 0 && t.sale_id == sale_id)
                    });
                    if(Products.length > 0){
                        //@todo criar uma tabela
                    }
                    console.log(ProductSelect);
                    row.child(row.data()).show();
         
                    // Add to the 'open' array
                    if (idx === -1) {
                        detailRows.push(tr.attr('id'));
                    }
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