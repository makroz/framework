var _config=unescape(getCookie('_config_'));
    _config=JSON.parse(_config);
function setCookie(cname, cvalue, exdays) {
    if (!exdays){
      var exdays=1;
    }
    var d = new Date();
    d.setTime(d.getTime() + (exdays * 24 * 60 * 60 * 1000));
    var expires = "expires="+d.toUTCString();
    document.cookie = cname + "=" + cvalue + ";" + expires + ";path=/";
}

function getCookie(cname) {
    var name = cname + "=";
    var ca = document.cookie.split(';');
    for(var i = 0; i < ca.length; i++) {
        var c = ca[i];
        while (c.charAt(0) == ' ') {
            c = c.substring(1);
        }
        if (c.indexOf(name) == 0) {
            return c.substring(name.length, c.length);
        }
    }
    return "";
}

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

  function getAjax(link,method='GET',data={},div='',success=null)
  {
    if (div!=''){
      $(div).LoadingOverlay("show");
    }
   
    $.ajax({
    method: method,
    url: link,
    data: data,
    success: function(msg){

        if (div!=''){
          $(div).LoadingOverlay("hide",true);
        }
        
        if (success){
          if (success(msg)<0){
            div='';
          }
        }

        if (div!=''){
          $(div).html(msg);
        }

          $("select").material_select();
           Materialize.updateTextFields();

       }
    });

  }

  function reaction(options,newAction='', newModule='',isajax='',callback=null,method='GET'){
   var opciones='';
   var action=getQueryVariable('url');

  if (newAction!=''){
    if (newModule!=''){
      action=newModule+'/'+newAction;
    }else{
      action=action+'/';
      action=action.split("/");//TODO: ver si existe url
      action=action[0]+'/'+newAction;
    }
  }else{
      if (newModule!=''){
        action=newModule;
      }
  }
    
    if ($.isArray(options)){
     for (let opt in options) {
      opciones=opciones+'&'+opt+'='+options[opt];
    }
    }else{
     opciones=opciones+'&'+options; 
    }
    var search=(action!='')? 'url='+action+opciones+window.location.hash:opciones.substring(1)+window.location.hash;
  //  search=(window.location.href.indexOf('?')!=-1)? window.location.href+opciones : window.location.href+'?'+opciones.substring(1);
    //alert(window.location.pathname+'?'+search);
    if (isajax==''){
    window.location=window.location.pathname+'?'+search;
    }else{
      if (isajax===true){
        return window.location.pathname+'?'+search;
      }else{
        //alert('cargand ajax'+window.location.pathname+'?'+search);
        $(isajax).LoadingOverlay("show");
        //if (callback){
          getAjax(window.location.pathname+'?'+search,method,{ },isajax,callback);
          //$(ajax).load(window.location.pathname+'?'+search,callback()); 
        //}else{

          //$(ajax).load(window.location.pathname+'?'+search); 
        //}
      }
    }
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

  function showMensajes(){
    $('._msg').each(function(){
      var title=$(this).prop('title');
      var content=$(this).html();
      $.alert({content:content, title:title,type:'red'});
    });
    $('._msg').remove();

  }


  function _changeLimitList(elem,ajax){
    if (!ajax){
      var ajax='.listTable';
    }
    var valor=$(elem).val();
    reaction('limit='+valor,'','',ajax);
  }

  function _changePageList(page,ajax){
    if (!ajax){
      var ajax='.listTable';
    }
    reaction('page='+page,'','',ajax); 
  }

  function _getFloat(dato, cero){
  if (!cero){
    var cero='';
  }
  var v=String(dato);
  dato=v.replace(',','.');
  if (dato!=''){
  return dato=parseFloat(dato,10);
  }else{return cero;}
  }

  function _isNumeric(dato){
    if (dato==''){
          return 0;
      }
    
    if (isNaN(dato)){
          return -1;
      }

      if (dato % 1 == 0) {
              return 1; 
          }
          else{
              return 2;
          }
  }


  function _formValidate(f){
  var campos=$('input, select',f);
  var errors='';
  var error=0;
  $(campos).each(function(){
    var validar=$(this).data('validate');
    if ((validar!='')&&(validar!=undefined)){
      
      validar=validar.trim().split(',');

      var campo=this;
      var msg='';
      var dato=$(campo).val();
      if (!dato){dato='';}

      $(validar).each(function (){
        var tipo=this.trim();

       

        if (tipo=='numeric'){
            if (_isNumeric(_getFloat(dato))<0){
              msg=msg+"Este Campo debe ser Numerico";      
              error++;
              // alert("validacin for "+$(campo).attr('id')+'is :' + tipo+' dato es: '+dato);
            }
        }

        if (tipo=='required'){
            if (dato.trim()==''){
              msg=msg+"Este Campo es Obligatorio";      
              error++;
              // alert("validacin for "+$(campo).attr('id')+'is :' + tipo+' dato es: '+dato);
            }
        }

       
        $(campo).parent().parent().find('.error_input').html(msg);



      });
      
    }
  });

  if (error==0){
    return true;
  }
    //alert('error='+error);
    return false;
  }

  function soloNum(e,i)   
  {   
  var tecla=(document.all) ? e.keyCode : e.which;

  var ok=false;
  var s=i.value;

  if ((tecla > 47)&&(tecla < 58)){ok=true;}
  if (tecla < 34){ok=true;}
  if (tecla == 45){ok=true;if (s.indexOf('-')!=-1){ok=false;}}

  if ((tecla == 44)||(tecla == 46)){
    ok=true;
    if ((s.indexOf('.')!=-1)||(s.indexOf(',')!=-1)){ok=false;}
  }

  if (tecla==32){ok=false;}
  //alert(tecla);

  return ok;
  }  

  function soloInt(e)   
  {   
  var tecla=(document.all) ? e.keyCode : e.which;

   var ok=false;
    if ((tecla > 47)&&(tecla < 58)){ok=true;}
    if (tecla < 34){ok=true;}
    if (tecla == 45){ok=true;}
    if (tecla == 32){ok=false;}
    //if (ok==false){window.event.keyCode=0;}
    return ok;
  }  

  function _setFloat(dato){
  var v=String(dato);
  if (_sepdec==','){return v.replace('.',',');}else{return v.replace(',','.');}
  return dato;
  }

  function _refreshFloat(id){
    var dato=$(id).val();
    if (dato!=''){
      $(id).val(_getFloat(dato).toFixed($(id).data('decimal')));
    }
  }


  function _sendForm(f,isAjax, success){
    //var action=$(f).data('_action');
    $(f).attr('action',reaction('','','',true));

    //alert(link);
    if (_formValidate($(f))){
      if (!isAjax){
        isAjax=0;
      }
      if (isAjax==1){
        reaction($(f).serialize(),'save','','#mk_formulario .modal-content',success,'POST');
      }else{
        $(f).submit();
      }
    }

  }

