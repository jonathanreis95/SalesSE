;(function( $ ){

  $.fn.money = function(number, format,retornaValor = false) {

  	var $this = this;

  	if (typeof(number) === 'object') {
  		//incase just parameters are entered and not a number
  		
      var format = number;
  		number = $this.html();

  	}

  	
  	var format = format || {},
    commas = format.commas || true,
    symbol = format.symbol || "",
    digits = format.digits || 2;

    number = parseFloat(number, 10)
    .toFixed(digits);


    number = number.replace('.',',');


    if (commas) {

     var count = 0;
     var numArr = number.toString().split("");

     var len = numArr.length - 6; 

     for (var i = len; i > 0; i= i - 3) {
      numArr.splice(i,0,".");

    }

    number = numArr.join("");

  }

  if (typeof symbol === 'string') {
   number = symbol + number;

 }

 if(!retornaValor){
 	$this.html(number);  
 	return $this;
 }else{
  return number;
 }

 
};

})( jQuery );
