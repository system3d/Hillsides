$(document).ready(function() {

  function refreshToken() {
      $.get(urlbaseGeral + '/system/refresh-token').done(function(data){
          $.ajaxSetup({
              headers: {
                  'X-CSRF-TOKEN': data
              }
          });
      });
  };

  setInterval(refreshToken, 300000);

  $( document ).ajaxError(function() {
    flashMessage('error', 'Erro na resposta do servidor');
    $('#modal').modal("hide");
    $('#modal_loader').addClass('hidden');
  });

  $('#fa-estagios-sidebar').click(function(event) {
    $('#set-est-side').toggleClass('hidden');
    $(this).find('.fa-sidebar').toggleClass('fa-plus-square fa-minus-square');
  });

   $('#fa-stp-sidebar').click(function(event) {
    $('#set-stp-side').toggleClass('hidden');
    $(this).find('.fa-sidebar').toggleClass('fa-plus-square fa-minus-square');
  });

   $('#fa-trp-sidebar').click(function(event) {
    $('#set-trp-side').toggleClass('hidden');
    $(this).find('.fa-sidebar').toggleClass('fa-plus-square fa-minus-square');
  });

   $('#fa-sfp-sidebar').click(function(event) {
    $('#set-sfp-side').toggleClass('hidden');
    $(this).find('.fa-sidebar').toggleClass('fa-plus-square fa-minus-square');
  });

    $(".cep").mask("99.999-999");

    var FoneMaskBehavior = function (val) {
      return val.replace(/\D/g, '').length === 11 ? '(00) 00000-0000' : '(00) 0000-00009';
    },
    foneOptions = {
      onKeyPress: function(val, e, field, options) {
          field.mask(FoneMaskBehavior.apply({}, arguments), options);
        }
    };

    $('.telefone').mask(FoneMaskBehavior, foneOptions);

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

Array.prototype.last = function() {
    return this[this.length-1];
}

Array.prototype.befLast = function() {
    return this[this.length-2];
}

$.fn.serializeAndEncode = function() {
      return $.map(this.serializeArray(), function(val) {
        return [val.name, encodeURIComponent(val.value)].join('=');
      }).join('&');
    };



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

function inArray(needle, haystack) {
    var length = haystack.length;
    for(var i = 0; i < length; i++) {
        if(typeof haystack[i] == 'object') {
            if(arrayCompare(haystack[i], needle)) return true;
        } else {
            if(haystack[i] == needle) return true;
        }
    }
    return false;
}


function secondsToTime(secs)
{
    var hours = Math.floor(secs / (60 * 60));
   
    var divisor_for_minutes = secs % (60 * 60);
    var minutes = Math.floor(divisor_for_minutes / 60);
 
    var divisor_for_seconds = divisor_for_minutes % 60;
    var seconds = Math.ceil(divisor_for_seconds);
   
    var obj = {
        "h": hours,
        "m": minutes,
        "s": seconds
    };
    return obj;
}

