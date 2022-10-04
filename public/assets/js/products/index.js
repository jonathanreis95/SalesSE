$(document).ready(function(){
    function functionProduct()
    {

        var formProduct;

        function initValidation(){
            $.validator.addMethod('requiredCombo', function (value, element, args) {
                return (value > 0)
            }, 'Este campo é obrigatório');

            formProduct = $('#formProduct').validate({
                errorClass: 'text-danger is-invalid',
                rules: {
                    description: "required",
                    unit_price: "required",
                    product_type_id: 'requiredCombo',
                },
                messages: {
                    description: 'Este campo é obrigatório',
                    unit_price: 'Este campo é obrigatório',
                },
                invalidHandler: function (form, validator) {
                    var erros = validator.numberOfInvalids();
                    if (erros) {
                        validator.errorList[0].element.focus();
                    }
                }
            });
        }

        function init()
        {
            $('.price').mask("#.##0,00", {reverse: true});

            initValidation();
        }

        init();
    }
    functionProduct();
});