$(document).ready(function(){
    function functionTaxes()
    {
        function init()
        {
            $('.percent').mask('##0,00%', {reverse: true});
        }

        init();
    }
    functionTaxes();
});