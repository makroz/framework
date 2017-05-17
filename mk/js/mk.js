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
          var r=success(msg);
          if (r<0){
            div='';
          }
        }

        if (div!=''){
          $(div).html(msg);
          if (r=='001'){
            success(msg,true);
          }
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
    var validar=$(this).prop('class');
    if ((validar!='')&&(validar!=undefined)){
      
      validar=validar.trim().split(' ');

      var campo=this;
      var dis=$(campo).prop('disabled');
      $(campo).prop('disabled',false);

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
              alert("validacin for "+$(campo).attr('id')+' is :' + tipo+' dato es: '+dato+' dis:'+dis);
            }
        }

        if (tipo=='mail'){
            if (!isEmail(dato)){
              msg=msg+"Este Campo debe ser un eMail valido";      
              error++;
              // alert("validacin for "+$(campo).attr('id')+'is :' + tipo+' dato es: '+dato);
            }
        }
      
      });
       inputMsg(campo,msg);
       if (error>0){
          if (dis==true){
            $(campo).prop('disabled',true);
          }
       }
    }
  });

  if (error==0){
    return true;
  }
    //alert('error='+error);
    return false;
  }

function inputMsg(campo,msg){
  $('label[for="'+$(campo).prop('id')+'"] ~ .error_input').html(msg);
  //$(campo).parent().find('.error_input').html(msg);
  //$(campo).parent().parent().find('.error_input').html(msg);

}

function alertfocus(msg,inp,color,def,){
  //alert(msg);
  if (!color){color='red';}
  if (!def){def='';}else{$(inp).val(def);}
  
  inputMsg(inp,msg);
  $(inp).focus();
  //$.alert({ content:"Este Campo debe ser un eMail valido",type: color});
  //if (inp.indexOf('.')<0){inp='#'+inp;}
  //setTimeout("$('"+inp+"').focus();",75); 
  setTimeout("inputMsg('"+inp+"','');",5000); 
}


  function _valEmail(campo){
    if (!isEmail($(campo).val())){
      alertfocus('Este Campo debe ser un eMail valido','#'+ $(campo).prop('id'));
    }
  }

  function isEmail(dato){
    if (dato==''){return true;}
    var emailRegex = /^([a-zA-Z0-9_.+-])+\@(([a-zA-Z0-9-])+\.)+([a-zA-Z0-9]{2,4})+$/;
    return emailRegex.test(dato);
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

  function dataUnique(pk,campo, valor, _success){
    //getAjax(reaction('searh_type=0&search_campo[]='+_campo+'&search_cond=3&search_search_text[]='+_valor,'dataExist', '',true),'GET',{},'',_success)
    getAjax(reaction('campo='+campo+'&pk='+pk+'&valor='+valor,'dataExist', '',true),'GET',{},'',_success)

  }

  function iDisabledCheck(check,target,val){
    if (!val){
      val='';
    }
    var c= $(check).is(':checked');
    if (c==true){
      $(target).attr('old_check_value',$(target).val()).prop('disabled',true).val(val);
    }else{
      $(target).prop('disabled',false).val($(target).attr('old_check_value'));
    }
    Materialize.updateTextFields();
  }

function actualizarUI(){
  $("select").material_select();
    Materialize.updateTextFields();
  if ($('ul.tabs').length>0){
      $('ul.tabs').tabs();
  }
}

function getNodosTree(nodo){
  var r= new Object();
  var tree=$(nodo);
  $(tree).treegrid('getAllNodes').each(function() {
    var key=$(this).treegrid('getNodeId');
    var p=$(this).treegrid('getParentNodeId');
    var t=$(this).find('td:eq(0)').text();
    var r1= new Object();
    r1.t=t;
    if (p!=null){
     r1.p=p;
    }
    r[key]=r1;
  });
  r=JSON.stringify(r);
  return r;

}

function stripslashes (str) {

  return (str + '').replace(/\\(.?)/g, function (s, n1) {
    switch (n1) {
    case '\\':
      return '\\';
    case '0':
      return '\u0000';
    case '':
      return '';
    default:
      return n1;
    }
  });
}

function setNodosTree(nodo,data){
  if (data==''){
    data='';
    return false;
  }
  data=stripslashes(data);
  data= JSON.parse(data);

  var html='';
  $.each(data, function(i, item) {
    var parent='';
    if (item.p){
      parent='treegrid-parent-'+item.p;
    }
    html=html+"<tr id='node-"+i+"' class='treegrid-"+i+" "+parent+" '><td>"+item.t+"</td><td><a class='btn-floating  waves-effect waves-light green' title='Adicionar'><i class='material-icons'>add</i></a><a class='btn-floating  waves-effect waves-light red' title='Borrar'><i class='material-icons'>delete</i></a><a class='btn-floating  waves-effect waves-light yellow' title='Editar'><i class='material-icons'>edit</i></a></td></tr>";
  });
  $(nodo).html(html);
  return html;

}

function sortByCol(arr, colIndex){
    arr.sort(sortFunction)
    function sortFunction(a, b) {
        a = a[colIndex]
        b = b[colIndex]
        return (a === b) ? 0 : (a < b) ? -1 : 1
    }
    return arr;
}


function inspeccionar(obj)
{
  var msg = '';

  for (var property in obj)
  {
    if (typeof obj[property] == 'function')
    {
      var inicio = obj[property].toString().indexOf('function');
      var fin = obj[property].toString().indexOf(')')+1;
      var propertyValue=obj[property].toString().substring(inicio,fin);
      msg +=(typeof obj[property])+' '+property+' : '+propertyValue+' ;\n';
    }
    else if (typeof obj[property] == 'unknown')
    {
      msg += 'unknown '+property+' : unknown ;\n';
    }
    else
    {
      msg +=(typeof obj[property])+' '+property+' : '+obj[property]+' ;\n';
    }
  }
  return msg;
}

function isFunction(nombreFuncion){
  if( typeof nombreFuncion !== 'undefined' && jQuery.isFunction( nombreFuncion ) ) {
    return true;
  }
  return false;
}


function myType(obj){

var toType = function(obj) {
return ({}).toString.call(obj).replace(/^\[.+?\s(\w+)\]$/,"$1").toLowerCase();
}
/*var toType = function(obj) {
  return ({}).toString.call(obj).match(/\s([a-z|A-Z]+)/)[1].toLowerCase()
}
*/
 return window.fff && Object.toType(fff);
}


  function iReplace(target,str1, str2){
    var ignore='';
  str1=str1.replace(/([\/\,\!\\\^\$\{\}\[\]\(\)\.\*\+\?\|\<\>\-\&])/g,"\\$&");

  str2=(typeof(str2)=="string")?str2.replace(/\$/g,"$$$$"):str2;
  return target.replace(new RegExp(str1,(ignore?"gi":"g")),str2);
} 
