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

