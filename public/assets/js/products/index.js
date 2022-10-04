$(document).ready(function(){
    function functionProduct()
    {
        function init()
        {
            $('.price').mask("#.##0,00", {reverse: true});
        }

        init();
    }
    functionProduct();
});