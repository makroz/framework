/*modulo Conponentes*/
var Mk_Componentes = {};
(function (modulo){
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

  modulo.init=function(quien){
    $(".form-config,.form-config-section").removeClass('bindered');
    binder();
    $(quien) .droppable({
      hoverClass: "drop-hover",
      greedy: false,
      drop: function( event, ui ) {
        console.log('droppable:',this.id,$(this).prop('class'));
        var id=$(ui.draggable).prop('id');
          $(this).append(Mk_Componentes.showComponente(id));
          Mk_Componentes.initComponentes();
          helper();
      }
    });
  };

  modulo.initComponentes=function(update){
    //todo: hacer la iniciacion de un solo componente espcifico
    if (!isFunction(update)){
      update=this.updateCB;
    }
    this.updateCB=update;
     $(".form-content").sortable({
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

    $(".form-config-section, .dropin").sortable({
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
        tpadre=$(padre).prop('id')+' Col > '+tpadre;
      }
      if ($(padre).hasClass('row')){
        tpadre=$(padre).prop('id')+' Row > '+tpadre;
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
/*      return ''+
      '<table class="tDetalle" data-tmaster="" >'+
      '  <thead>'+
      '    <tr><th>Col1</th><th>Col2</th></tr>'+
      '  </thead>'+
      '  <tbody>'+
      '    <tr><td>Col1</td><td>Col2</td></tr>'+
      '  </tbody>'+
      '</table>';
*/  }
});

Mk_Componentes.add({
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
