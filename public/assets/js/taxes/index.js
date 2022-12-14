$(document).ready(function(){
    function functionTaxes()
    {

        var formTaxes;

        function initValidation(){
            $.validator.addMethod('requiredCombo', function (value, element, args) {
                return (value > 0)
            }, 'Este campo é obrigatório');

            formTaxes = $('#formTaxes').validate({
                errorClass: 'text-danger is-invalid',
                rules: {
                    unit_percentage: "required",
                    taxe_type: "required",
                    product_type_id: 'requiredCombo',
                },
                messages: {
                    unit_percentage: 'Este campo é obrigatório',
                    taxe_type: 'Este campo é obrigatório',
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
            $('.percent').mask('##0,00%', {reverse: true});

            initValidation();
        }

        init();
    }
    functionTaxes();
});