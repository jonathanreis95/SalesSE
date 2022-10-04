$(document).ready(function(){
    function functionTaxes()
    {

        var formProductType;

        function initValidation(){
            formProductType = $('#formProductType').validate({
                errorClass: 'text-danger is-invalid',
                rules: {
                    description: "required",
                },
                messages: {
                    description: 'Este campo é obrigatório',
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
            initValidation();
        }

        init();
    }
    functionTaxes();
});