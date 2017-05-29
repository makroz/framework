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


function _tablaShow(tabla, campo,addTr,delTr,thead){
  if (thead){
    $(tabla+' thead').html(thead);
  }
  
  var datos;
  if (isFunction(campo)){
    datos=campo(tabla);
  }else{
    datos=campo;
  }
  $(tabla).data('indice','0').data('delTr',delTr).data('addTr',addTr);
  datos=datos+'*';
  var tr=datos.split('*');
  $(tabla+' tbody tr').remove();
  for (i = 0; i < tr.length; i++) {
    if (tr[i]!=''){
      var dato=(tr[i]).split('|');
      if (isFunction(addTr)){
        addTr(tabla,dato);
      }
    }
  }
}

function _tablaIndice(tabla){
  var ind= $(tabla).data('indice');
  ind++;
  $(tabla).data('indice',ind);
  return ind;  
}

function _tablaDelTr(tr){
tr=$(tr).closest('tr');
var delTr=$(tr).closest('table').data('delTr');
if (isFunction(delTr)){
  if (delTr(tr)==false){
    alert('No puede Eliminarse, No Esta Vacio');
    return false;
  }
}
$(tr).hide().data('delete','1');
}

function _tablaAddTr(tabla,dato){
var addTr=$(tabla).data('addTr');
if (isFunction(addTr)){
  addTr(tabla,dato);
}
}

function _tablaSave(tabla,campo){
  var dato='';
  $(tabla).find('tbody tr').each(function( index ) {
    if ($( this ).data('delete')!=1){
    var i=$( this ).data('i');
    $(tabla).find('.dato'+i).each(function( index ) {
      if ($( this ).prop("tagName")!='DIV'){
        dato=dato+$( this ).val()+'|';
      }
    });
    dato=dato+'*';
    }
  });
  if (campo){
    $(campo).val(dato);
  }
  return dato;
}



function _extend(destination, source) {
  source || ( source = {} );
  for (var property in source)
    destination[property] = source[property];
  return destination;
}



 

var Mk_Componentes = {};
(function (modulo){
  var modalConfig='#menu-campos-config';
  var items = [];
  var tools ='<span class="campos-edit">'+
      ' <i class="material-icons" onclick="Mk_Componentes.openConfig(this)">settings</i>'+
      ' <i class="material-icons handle">open_with</i>'+
      ' </span>';
  var tagFin='<!-- fin -->';
  var updateCB=function(){};
  modulo.cur_Type='';
  modulo.cur_Id='';

  function Mk_Componente(options){
  this.type= options.type || 'c-base';
  this.isItem= options.isItem || 0;
  this.name= options.name || 'Base';
  this.icon=  options.icon || 'extension';
  this.color=  options.color || 'green';
  this.hide=  options.hide || false;
  this.openForm=  options.openForm || '';
  this.cant=  options.cant || -1;
  this.init = options.init || false;
  this.add = options.add || false;
  this.classAdd = options.classAdd || '';
  this.saveConfig = options.saveConfig || false;
  this.openConfig = options.openConfig || false;
  this.showConfig = options.showConfig || false;

  //_extend(this,options);
  };
  
  modulo.setModalConfig=function(value){
    modalConfig=value;
  };

  modulo.getModalConfig=function(value){
    return modalConfig;
  };

  modulo.setTagFin=function(value){
    tagFin=value;
  }

  modulo.getTagFin=function(value){
    return tagFin;
  }

  modulo.setTools=function(value){
    tools=value;
  };

  modulo.getTools=function(){
    return tools;
  };

  modulo.init=function(quien){
    $(quien) .droppable({
      hoverClass: "drop-hover",
      greedy: true,
      drop: function( event, ui ) {
        console.log('droppable:',this.id,$(this).prop('class'));
        var id=$(ui.draggable).prop('id');
          $(this).append(Mk_Componentes.showComponente(id));
          Mk_Componentes.initComponentes();
      }
    });
  };

  modulo.initComponentes=function(update){
    if (!isFunction(update)){
      update=this.updateCB;
    }
    this.updateCB=update;
     $(".form-content").sortable({
        items: "> .form-config-section, > .form-config",
        connectWith: ".dropin",
        cursor: "move",
        greedy: true,
        helper: "clone",
        forceHelperSize: true,
        handle: ".handle",
        opacity: 0.5,
         update: function( event, ui ) { update();}
    });

    $(".form-config-section, .dropin").sortable({
      items: "> .form-config",
       containment: ".form-content",
       connectWith: ".dropin",
       //connectWith: ".form-config-section, .dropin",
        cursor: "move",
        greedy: true,
        helper: "clone",
        forceHelperSize: true,
        handle: ".handle",
        opacity: 0.5,
         update: function( event, ui ) { update();}
    });

    for (let item in items){
      if (item.init){
        item.init();
      }
    }

    update();

  }

  modulo.add = function(item){
    if (item.type){
      items[item.type]=new Mk_Componente(item);
    }
  };


  modulo.showComponente = function(type){
    //console.log('showComponente:',type,':',items[type]);
    if((items[type])&&(items[type].add)){
      //console.log('componente antes:',items[type].index,'.componente .i_'+type);
      if (items[type].cant<0){
        $('.componente.i_'+type).each(function(){
            let n=$(this).prop('id');
            //console.log('componente:',n);
            n=n.replace(type+'-','');
            n=n*1;
            if ((!isNaN(n))&&(n>items[type].cant)){
              items[type].cant=n;
            }
        });
        if (items[type].cant<0){
          items[type].cant=0;
        }
      }
      items[type].cant++;
      let openF='';
      if (items[type].openForm!=''){
        openF='<span class"oculto">[[setvar: openform]]'+items[type].openForm+'[[:setvar]]</span>';
      }

      let isItem='row form-config-section componente';
      if (items[type].isItem==1){
        isItem='col s12 form-config';
      }

      if (items[type].classAdd!=''){
        isItem=isItem+' '+items[type].classAdd;
      }

      return '<div class="'+isItem+' i_'+type+'" id="'+type+'-'+items[type].cant+'" data-campo="'+type+'-'+items[type].cant+'" data-type="'+type+'">'+
      tools+
      items[type].add(items[type].cant)+
      openF+
      '</div>';
    }
  };

  modulo.saveConfig = function(){
    if(items[this.cur_Type].saveConfig){
      items[this.cur_Type].saveConfig(this.cur_Id);
      this.updateCB();
    }
    this.closeConfig();
  };

  modulo.isEmpty= function(){
   var canDel=0;
    $('#'+this.cur_Id).find('.dropin').each(function(){
      if ($(this).is(':empty')==false){
        canDel++;
      }
    });

    if (canDel>0){
      return false;
    }
    return true;
  }

  modulo.delConfig = function(seguro){
    if (!this.isEmpty()){
      $.alert('No esta Vacio!!!');
      return false;
    }

    if (!seguro){
      $.confirm({
          title: 'Eliminar?',
          content: '¿Esta seguro de querer borrar este Componente?:',
          type:'red',
          buttons: {
              confirm: function () {
                Mk_Componentes.delConfig(true);
              },
              cancel: function () {
              }
          }
      });
      return false; 
    }

    $('#'+this.cur_Id).remove();
    this.updateCB();
    this.closeConfig();
  };

  modulo.closeConfig= function(){
    $(this.getModalConfig()).hide();
  };

  modulo.openConfig = function(boton){
    if (!boton){
      return false;
    }

    var campo=$(boton).closest('.form-config');

    if ($(campo).prop('class')==undefined){
      campo=$(boton).closest('.form-config-section');
    }

    if ($(campo).prop('class')==undefined){
      return false;
    }

    var tpadre='';
    var padre=$(campo).parent();
    
    while ((padre)&&(!$(padre).hasClass('form-content'))){
      if ($(padre).hasClass('col')){
        tpadre='Col > '+tpadre;
      }
      if ($(padre).hasClass('row')){
        tpadre=$(padre).prop('id')+' > '+tpadre;
      }
      padre=$(padre).parent();
    }
    tpadre='::'+tpadre;
    this.cur_Type =$(campo).data('type');
    this.cur_Id=$(campo).data('campo');

    if ((this.isEmpty)&&(!items[this.cur_Type].openConfig)){
      this.delConfig();
      return false;  
    }
    

    if ((items[this.cur_Type].showConfig)&&(items[this.cur_Type].openConfig)){

      if (items[this.cur_Type].hide!=1){
          $(this.getModalConfig())
        .find('#config-borrar').show();        
      }else{
        $(this.getModalConfig())
        .find('#config-borrar').hide();
      }

      $(this.getModalConfig())
        .find('h4')
          .html(tpadre+this.cur_Id)
        .end()
        .find('.modal-content')
          .html('<div class="row op-edit op-edit-'+this.cur_Type+'">'+
            items[this.cur_Type].showConfig()+
            '</div')
        .end()
        .show(); 

      items[this.cur_Type].openConfig(this.cur_Id);
      actualizarUI();
    }



  };

  modulo.show=function(type){
    if (items[type]){
      return '<div class="comp_dragable" id="'+items[type].type+'" style="text-align: center;display: inline-block;margin:5px;">'+
        '<a class="btn-floating  waves-effect waves-light '+items[type].color+'"><i class="material-icons">'+items[type].icon+'</i></a>'+
        '<div style="font-size: 9px;text-align: center;">'+items[type].name+'</div>'+
        '</div>';
    }else{
      return 'no existe';
    }
  };
  modulo.showAll=function(donde){
    let r='';
    for (let item in items){
      //console.log('item es:',items[item]);
      if (items[item].hide!=1){
        r=r+this.show(item);
      }
    }
    $(donde).html(r);

    $( ".comp_dragable" ).draggable({
      revert: "invalid",
      helper:"clone"
    });

  };


})(Mk_Componentes);

Mk_Componentes.add({
  name:'Campos',
  type:'field',
  hide:1,
  openForm:'$("ul.tabs").tabs();',
  openConfig:function(id){
    var idp='tam';
    var datos=$('#field-'+id+'-'+idp).val();
    $('#option-'+idp).val(datos);
  },
  saveConfig:function(id){
    var idt='tam';
    var dato=$('#option-'+idt).val();
    var olddatos=$('#field-'+id+'-'+idt).val();
    $('#field-'+id+'-'+idt).val(dato);
    var clase=$('#form-config-'+id).prop('class');
    clase=clase.replace(olddatos,dato);
    $('#form-config-'+id).prop('class',clase);
  },
  showConfig:function(){
    return ' '+
     '<div class="input-field col s12">'+
     '   <input id="option-tam" name="option-tam" type="text" value="" >'+
     '   <label for="option-tam" >Tamano del Campo:</label>'+
     ' </div>';
  }
});

Mk_Componentes.add({
  name:'Seccion',
  type:'c-section',
  icon:'crop_7_5',
  color:'blue', 
  add:function(nitem){
      return '<div class="dropin" >'+
      '</div>';
  }
});

Mk_Componentes.add({
  name:'maestro/DETALLE',
  type:'c-Mdetalle',
  icon:'view_compact',
  color:'red', 
  isItem:1,
  add:function(nitem){
      return '<div class="lista row s6" >Esta es una lista'+
      '</div>';
  }
});


Mk_Componentes.add({
  name:'Tabulador',
  type:'c-tab',
  icon:'tab', 
  init:function(){
    $("ul.i_tab").tabs();
  },
  add:function(nitem){
        return '<ul class="tabs z-depth-1 i_tab" id="tab-'+nitem+'">'+
        '<li class="tab col s12"><a class="active" href="#tab-'+nitem+'-1">TAB-'+nitem+'-1</a></li>'+
        '</ul>'+
        '<div  id="tab-'+nitem+'-1" class="col s12 dropin"></div>';
  },
  saveConfig:function(id){

       $('#tabtable').find('tbody tr').each(function( index ) {
        var i=$( this ).data('i');
        var key=$( this ).data('key');
        if (key!=''){
          var links = $( 'a[href="#'+key+'"]' );
        }else{
          var links = [];
        }
        var newid=$(this).find('#id-'+i).val();
        var newlabel=$(this).find('#label-'+i).val();
        var newtam=$(this).find('#tam-'+i).val()
        if ($(links).length>0){
          $( this ).data('key',newid);
          $('#'+key).prop('id',newid);  
          $(links).html(newlabel);
          $(links).prop('href','#'+newid);
          var clase=$(links).parent().prop('class');
          var clase1=clase;
          clase1=clase1.replace('tab col ','');
          clase=clase.replace(clase1,newtam);
          $(links).parent().prop('class',clase);
          if ($( this ).data('delete')==1){
            $(links).parent().remove();
            $('#'+key).remove();
          }
        }else{
          $( this ).data('key',newid);
          $('#'+id+' ul.tabs').append('<li class="tab col '+newtam+'"><a  href="#'+newid+'" style="">'+newlabel+'</a></li>');
          $('#'+id+' ul.tabs').after('<div id="'+newid+'" class="col s12 dropin"></div>');
        }
      });
      $('#'+id+' ul').tabs();

  },
  openConfig:function(id){
    function delTrTab(tr){
      var key=$(tr).data('key');
      if (key==''){
          return true;
      }else{
        if (($('#'+key).is(':empty'))||($('#'+key).html()=='')||($('#'+key).html()==undefined)){
        return true;
        }else{
        return false;
        }
      }
    }

    function addTrTab(tabla,dato){
      var i=_tablaIndice(tabla);
      if (dato==''){
        dato=[];
        let n=Mk_Componentes.cur_Id.replace(/[^\d]/g, '');
        //console.log('cur id',n,Mk_Componentes.cur_Id);
        n='tab-'+n+'-'+($(tabla+' tbody tr').length+1);
        dato[0]=n;
        //console.log('vacio?',$('#'+n).is(':empty'),$('#'+n).html());
        dato[1]=n.toUpperCase();
        dato[2]='s'+(12/($(tabla+' tbody tr').length+1));
        dato[3]='';
      }else{
        dato[3]=dato[0];
      }
      $(tabla+' tbody').append('<tr id="trlista'+i+'" data-i="'+i+'" data-key="'+dato[3]+'">'+
        '<td><input id="id-'+i+'" type="text" class="validate dato'+i+'" value="'+dato[0]+'"></td>'+
        '<td><input id="label-'+i+'" type="text" class="validate dato'+i+'" value="'+dato[1]+'"></td>'+
        '<td><input id="tam-'+i+'" type="text" class="validate dato'+i+'" value="'+dato[2]+'"></td>'+
        '<td> <i class="material-icons red-text" data-i="'+i+'" onclick="_tablaDelTr(this);" style="cursor: pointer;" >delete</i></td>'+
        '</tr>');
    }

    var datos='';
    $('#'+id+' li  a').each(function(){
      let tam=$(this).parent().prop('class');
      tam=tam.replace('tab col ','');
      let ref=$(this).prop('href');
      ref=ref.substr(ref.indexOf('#')+1);
      datos=datos+ref+'|'+$(this).text()+'|'+tam+'*';
    });
    $('#tabtable').data('campo',id);
    _tablaShow('#tabtable', datos,addTrTab,delTrTab);
  },
  showConfig:function(){
    return ' '+
      '<div class="input-field col s12">'+
      '  <label for="option-tam" >Crear Tabuladores:</label>'+
      '</div>'+
          
      '<table class="striped" id="tabtable">'+
      '  <thead>'+
      '    <tr>'+
      '        <th data-field="valor">idTAB</th>'+
      '        <th data-field="texto">Label</th>'+
      '        <th data-field="tag">Tamano</th>'+
      '        <th data-field="action">'+
      '          <a class="btn-floating  waves-effect waves-light green" onclick="_tablaAddTr(\'#tabtable\',\'\');" >'+
      '           <i class="material-icons">add</i>'+
      '          </a>'+
      '        </th>'+
      '    </tr>'+
      '  </thead>'+
      '  <tbody>'+
      '  </tbody>'+
      '</table>';
  }
});
