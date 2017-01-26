function getSelAjax(id,url,idtarget,valtarget){
  var dato=$(id).val();
  var oldvalue=$(id).attr('oldvalue');
  if ((dato!='-1')&&(dato!=oldvalue)){
    $.ajax({
  url: url,
  data:  {
    valor: dato
  },
  success: function( result ) {

    $(idtarget).html(result);
    if (valtarget!=''){
    
      $(idtarget).val(valtarget);
    }
    $(id).attr('oldvalue',dato);
    $('select').material_select();
  }
  });
  }

  if (dato=='-1'){
    $(id).attr('oldvalue',dato);
    $(idtarget).html('<option value="-1" selected="selected">...</option>>');
    $('select').material_select();
  }
  return dato;
  
}

function reaction(options,newAction, newModule){
 var opciones='';
 var action=getQueryVariable('url');
if (newAction){
  if (newModule){
    action=newModule+'/'+newAction;
  }else{
    action=action+'/';
    action=action.split("/");//TODO: ver si existe url
    action=action[0]+'/'+newAction;
  }
}else{
    if (newModule){
      action=newModule;
    }
}
  
   for (let opt in options) {
    opciones=opciones+'&'+opt+'='+options[opt];
  }
  var search=(action!='')? 'url='+action+opciones+window.location.hash:opciones.substring(1)+window.location.hash;
//  search=(window.location.href.indexOf('?')!=-1)? window.location.href+opciones : window.location.href+'?'+opciones.substring(1);
  window.location=window.location.pathname+'?'+search;
}


 function getQueryVariable(variable) {
        var query = window.location.search.substring(1);
        var vars = query.split("&");
//        alert(vars);
        for (var i=0; i < vars.length; i++) {
            var pair = vars[i].split("="); 
            if (pair[0] == variable) {
                return pair[1];
            }
        }
        return false;
    }

/* funcion para colocar el estado del check a un checkbok */
function checkboxSet(id,status){
  $(id).checked=status;
}

