$(document).ready(function() {

    $('#loader').addClass('hidden'); 

    // Bootstrap Select
    $('.selectpicker').selectpicker({
        size: 4
    });

    /* Adiciona Token no Header de cada ajax*/
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
        }
    });

});


function number_format(numero, decimal, decimal_separador, milhar_separador) {
    numero = (numero + '').replace(/[^0-9+\-Ee.]/g, '');
    var n = !isFinite(+numero) ? 0 : +numero,
        prec = !isFinite(+decimal) ? 0 : Math.abs(decimal),

        sep = (typeof milhar_separador === 'undefined') ? ',' : milhar_separador,

        dec = (typeof decimal_separador === 'undefined') ? '.' : decimal_separador,

        s = '',

        toFixedFix = function(n, prec) {

            var k = Math.pow(10, prec);

            return '' + Math.round(n * k) / k;

        };

    // Fix para IE: parseFloat(0.55).toFixed(0) = 0;

    s = (prec ? toFixedFix(n, prec) : '' + Math.round(n)).split('.');

    if (s[0].length > 3) {

        s[0] = s[0].replace(/\B(?=(?:\d{3})+(?!\d))/g, sep);

    }

    if ((s[1] || '').length < prec) {

        s[1] = s[1] || '';

        s[1] += new Array(prec - s[1].length + 1).join('0');

    }
    return s.join(dec);

}

function dd(param) {
    console.log(param);
}

function diffForHumans(data){
  var dateAll = data.split(" ");
  var dateS = dateAll[0].split("-");
  var dateT = dateAll[1].split(":");
  var RSaida = dateS[2]+'/'+dateS[1]+'/'+dateS[0]+' '+dateT[0]+':'+dateT[1];
  return RSaida;
}

function diffForMachines(data){
  var dateS = data.split("/");
  var RSaida = dateS[2]+'-'+dateS[1]+'-'+dateS[0];
  return RSaida;
}