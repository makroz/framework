/*modulo Conponentes*/
var Mk_Componentes = {};
(function (modulo){
  var modalComponentes='<div id="mk_componentes_lista"></div>';
  var modalConfig='#menu-campos-config';
  var items = [];
  var tools =' <i class="material-icons" onclick="Mk_Componentes.openAdd(this)">add</i>'+
      ' <i class="material-icons" onclick="Mk_Componentes.openConfig(this)">settings</i>'+
      ' <i class="material-icons handle">open_with</i>';
  var tagFin='<!-- fin -->';
  var updateCB=function(){};
  modulo.cur_Type='';
  modulo.cur_Id='';

  function Mk_Componente(options){
  this.type= options.type || 'c-base';
  this.isItem= options.isItem || 0;
  this.parametros = options.parametros || false;
  this.name= options.name || 'Base';
  this.icon=  options.icon || 'extension';
  this.color=  options.color || 'green';
  this.hide=  options.hide || false;
  this.html= options.html || '';
  this.openForm=  options.openForm || '';
  this.cant=  options.cant || -1;
  this.init = options.init || false;
  this.add = options.add || function(nitem){return this.html;};
  this.saveConfig = options.saveConfig || false;
  this.classAdd = options.classAdd || '';
  this.openConfig = options.openConfig || false;
  this.showConfig = options.showConfig || false;
  this.tools = options.tools || false;

  //_extend(this,options);
  };
  
  function helper(){
    $(".form-content > .col").removeClass('col').addClass('row');
    $(".dropin > .row ").removeClass('row').addClass('col s12');

  }

  modulo.setModalConfig=function(value){
    modalConfig=value;
  };

  modulo.setHtml=function(type,html){
    if (items[type]){
      html=str_replace( ['(%','%)','\\','[[]]'],['{%','%}','\\\\','$'], html);
      items[type].html=html;
    }
  };

  modulo.setParametros=function(type,param){
    if (items[type]){
      for (var pp in param){
        if (!items[type].parametros){
          items[type].parametros=[];
        }
        if (!items[type].parametros[param[pp]]){
          items[type].parametros[param[pp]]='string';  
        }
        
      }
      
    }
  };

  modulo.getModalConfig=function(value){
    return modalConfig;
  };

  modulo.setModalComponentes=function(value){
    modalComponentes=value;
  };

  modulo.getModalComponentes=function(value){
    return modalComponentes;
  }

  modulo.setTagFin=function(value){
    tagFin=value;
  }

  modulo.getTagFin=function(value){
    return tagFin;
  }

  modulo.setTools=function(value){
    tools=value;
  };

  modulo.getTools=function(id){
    if (items[id]){
      return items[id].tools || tools;
    }else{
      return tools;
    }
  };

  function binder(items){
    //alert('binder:'+items);
    if (!items){
      var items=".form-config,.form-config-section";
    }

  $(items).filter(':not(.bindered)')
  .mouseenter(function() {
    let id=$(this).data('type');
    let tt= Mk_Componentes.getTools(id);
    tt='<span class="campos-edit">'+tt+'</span>';
    $( this ).prepend(tt);
  })
  .mouseleave(function() {
    $( this ).find( ".campos-edit" ).remove();
  })
  .addClass('bindered');

  }

 
  modulo.openAdd=function(boton){
     if (!boton){
      return false;
    }

    var componente=$(boton).closest('.componente');

    if ($(componente).prop('class')==undefined){
      componente=$(boton).closest('.form-config-section');
    }

    if ($(componente).prop('class')==undefined){
      return false;
    }

    if ($(componente).find('.dropin').length==0){
      return false;
    }
  
  modulo.cur_Id=$(componente).prop('id');

  new Custombox.modal({
  content: {
    effect: 'fadein',
    target: '#panelComponentes'
  }
  }).open();

 //   var tpadre='';
 //   var padre=$(campo).parent();

    //$(this.getModalConfig()).html(this.showAll(this.getModalComponentes())).show();

  }


  modulo.addComponente=function(id,donde){
    if (!donde){
      donde=this.cur_Id;
    }

     $('#'+donde).find('.dropin').eq(0).append(this.showComponente(id));
          this.initComponentes();
          helper();

  }


  modulo.init=function(quien){
    $(".form-config,.form-config-section").removeClass('bindered');
    binder();
    /*$(quien) .droppable({
      hoverClass: "drop-hover",
      greedy: false,
      drop: function( event, ui ) {
        console.log('droppable:',this.id,$(this).prop('class'));
        var id=$(ui.draggable).prop('id');
          $(this).append(Mk_Componentes.showComponente(id));
          Mk_Componentes.initComponentes();
          helper();
      }
    });*/
  };

  modulo.initComponentes=function(update){
    //todo: hacer la iniciacion de un solo componente espcifico
    if (!isFunction(update)){
      update=this.updateCB;
    }
    this.updateCB=update;
     $(".dropin").sortable({
        items: "> .form-config-section, > .form-config",
        connectWith: ".dropin",
        cursor: "move",
        greedy: false,
        helper: "clone",
        forceHelperSize: true,
         hoverClass: "drop-hover",
        forcePlaceholderSize: true,
        placeholder: "sortable-placeholder",
        handle: ".handle",
        opacity: 0.5,
         update: function( event, ui ) { update(); helper();}
    });

/*    $(".form-config-section, .dropin").sortable({
      items: "> .form-config",
       containment: ".form-content",
       connectWith: ".dropin",
       //connectWith: ".form-config-section, .dropin",
        cursor: "move",
        greedy: false,
         hoverClass: "drop-hover",
         placeholder: "sortable-placeholder",
        helper: "clone",
        forceHelperSize: true,
        forcePlaceholderSize: true,
        handle: ".handle",
        opacity: 0.5,
         update: function( event, ui ) { update(); helper();}
    });
*/
    binder();

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
      if (items[type].cant<=0){
        $('.i_'+type).each(function(){
            let n=$(this).prop('id');
            console.log('componente:',n);
            n=n.replace(type+'-','');
            n=n.replace('-','');
            n=n*1;
            if ((!isNaN(n))&&(n>items[type].cant)){
              items[type].cant=n;
            }
        });
        if (items[type].cant<=0){
          items[type].cant=0;
        }
      }
      items[type].cant++;
      console.log('componente cant:',items[type].cant);
      
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
      //tools+
      '<div class="mk_comp_html">'+items[type].add(items[type].cant)+'</div>'+
      openF+
      '<input type="hidden" name="componente['+type+']" id="data-'+type+'-'+items[type].cant+'" value="'+type+'">';
      '</div>';
    }
  };

  modulo.saveConfigDef=function(typec,idc){
    if (!typec){
      typec=this.cur_Type;
    }
    if (!idc){
      idc=this.cur_Id;
    }
    
    if ((items[typec].parametros)){
       var html=items[typec].html;
        for (var param in items[typec].parametros) {
          html=this.configParamSave(param,items[typec].parametros[param],idc,html);
        }
        console.log(html);
        $('#'+idc).find('.mk_comp_html').html(html);
    }

  }

  modulo.configParamSave=function(idparam,type='string',idc,html){
    if (!idc){
      idc=this.cur_Id;
    }
    if ((type=='string')&&(idparam!='')&&(idparam!=undefined)){
      var dato =$('#option-'+idparam).val();
      //var value=$('#data-'+idc).data(idparam);
      if (dato==undefined){dato='';}
      $('#data-'+idc).data(idparam,dato);
      if (dato!=''){
        html=str_replace('[[var:]]'+idparam+'[[:var]]',dato,html);
      }

    }
    return html;
     
  }

  modulo.configParam=function(idparam,type='string',value='',idc){
    if (!idc){
      idc=this.cur_Id;
    }
    if (value==''){
      value=$('#data-'+idc).data(idparam);
    }
    if (value==undefined){
      value='';
    }
    if ((type=='string')&&(idparam!='')&&(idparam!=undefined)){
     return ' '+
     '<div class="input-field col s12">'+
     '   <input id="option-'+idparam+'" name="option-'+idparam+'" type="text" value="'+value+'" >'+
     '   <label for="option-'+idparam+'" >'+idparam+':</label>'+
     ' </div>'; 
    }
    return '';
     
  }
  modulo.saveConfig = function(){
    if(items[this.cur_Type].saveConfig){
      items[this.cur_Type].saveConfig(this.cur_Id);
      
    }else{
      this.saveConfigDef();
    }
    this.updateCB();
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
      /*if ($(padre).hasClass('col')){
        tpadre=$(padre).prop('id')+' Col > '+tpadre;
      }
      if ($(padre).hasClass('row')){
        tpadre=$(padre).prop('id')+' Row > '+tpadre;
      }*/
      tpadre=tpadre+$(padre).prop('id')+'>';
      padre=$(padre).parent();
    }
    //tpadre='::'+tpadre;
    this.cur_Type =$(campo).data('type');
    this.cur_Id=$(campo).data('campo');

    if ((this.isEmpty)&&(!items[this.cur_Type].openConfig)&&(!items[this.cur_Type].parametros)){
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
          .html("<div style='font-size:0.5em;'>"+tpadre+'</div>'+this.cur_Id)
        .end()
        .find('.modal-content')
          .html('<div class="row op-edit op-edit-'+this.cur_Type+'">'+
            items[this.cur_Type].showConfig()+
            '</div')
        .end()
        .show(); 

      items[this.cur_Type].openConfig(this.cur_Id);
      actualizarUI();
    }else{
      var lparam='';
      if ((items[this.cur_Type].parametros)){
        for (var param in items[this.cur_Type].parametros) {
          lparam = lparam + this.configParam(param,items[this.cur_Type].parametros[param]);
        }

          if (items[this.cur_Type].hide!=1){
              $(this.getModalConfig())
            .find('#config-borrar').show();        
          }else{
            $(this.getModalConfig())
            .find('#config-borrar').hide();
          }

          $(this.getModalConfig())
            .find('h4')
              .html("<div style='font-size:0.5em;'>"+tpadre+'</div>'+this.cur_Id)
            .end()
            .find('.modal-content')
              .html('<div class="row op-edit op-edit-'+this.cur_Type+'">'+
                lparam+
                '</div')
            .end()
            .show(); 

          //items[this.cur_Type].openConfig(this.cur_Id);
          actualizarUI();


 
      }


    }



  };

  modulo.show=function(type){
    if (items[type]){
      return '<div class="comp_dragable" id="'+items[type].type+'" onclick="Mk_Componentes.addComponente(\''+items[type].type+'\')" style="text-align: center;display: inline-block;margin:5px;">'+
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
    donde=$(donde).html(r);

   /* $( ".comp_dragable" ).draggable({
      revert: "invalid",
      helper:"clone"
    });*/
    return donde;
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
      return '<div class="dropin row" >'+
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

Mk_Componentes.add({
  name:'maestro/DETALLE',
  type:'c-Mdetalle',
  icon:'view_compact',
  color:'red', 
  isItem:1,
  add:function(nitem){
    let nid='tMaster-'+nitem;
    Mk_MasterDetails.add({
      id:nid,
      master:'masterprueba',
      slave:'slaveprueba'
    });

    return Mk_MasterDetails.show(nid);  
  }
});

/*Mk_Componentes.add({
  name:'tabla',
  type:'c-Table',
  icon:'view_module',
  color:'green', 
  isItem:1,
  add:function(nitem){
    let nid='cTable-'+nitem;
    Mk_Tablas.add({
      id:nid,
      options:'#,options',
      getDatos:  function(){return [['pruebas']];}
    });

    return Mk_Tablas.show(nid);  
  }
});
*/