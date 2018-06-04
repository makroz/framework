

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
  for (var i = 0; i < tr.length; i++) {
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
var tr=$(tr).closest('tr');
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

/*modulo tablas*/
var Mk_Tablas ={};
(function (modulo){
   var items = [];
   var optTableAdd='<a class="btn-floating  waves-effect waves-light green" onclick="Mk_Tablas.addTr(this);" >'+
      '<i class="material-icons">add</i>'+
      '</a>',
      optTableDel='<a class="btn-floating  waves-effect waves-light red" onclick="Mk_Tablas.delTr(this);" >'+
      '<i class="material-icons">delete</i>'+
      '</a>';

  function Mk_Tabla(options){
  this.id= options.id || '0';
  this.classTable=  options.classTable || '';
  this.options= options.options || '';
  this.moreAttr=  options.moreAttr || '';
  this.index=  options.index || 0;
  this.cols = options.cols || [{id:'id',label:'label',type:'input',tam:'',clase:''}];
  this.addTr = options.addTr || false;
  this.delTr = options.delTr || false;
  this.getDatos = options.getDatos || function(){return [];};
  this.optTableAdd= options.optTableAdd || false;
  this.optTableDel= options.optTableDel || false;
  this.optTableEdit= options.optTableEdit || false;
  
  }

  function numTabla(id,col){
    if (!col){
      var col=-1;
      $('#'+id+' tbody tr:eq(0) td').each(function(i,fila){
          if ($(fila).hasClass('_rowNum')){
            col=i;
          }
      });  
    }
    console.log('Numtabla:',col, id);

    if (col==-1){
      return false;
    }

    var nrow=0;
    $('#'+id+' tbody tr').filter(":visible").each(function(i,fila){
        nrow++;
        $(this).find('td:eq('+col+')').html(nrow);
    });
    
  }

  function _delTr(tr,idr,n,id){
      if (n==1){
      $(tr).remove();
    }else{
      $(tr).data('delete','1').hide();
    }
    return true;
  };

  function _addTr(id,datos,ret){
    var i=items[id];
    var fila='';
    $.each(i.cols,function(j,col){
          let d='';
          if (datos){
            d=datos[j];
          }
          var c='<input type="hidden" id="'+col.id+'[]" name="'+col.id+'[]" value="'+d+'">';

          switch(col.type) {
              case 'text':
                    d=d+c;
                  //code block
                  break;
              case 'input':
                  //code block
                  d='<input type="text" id="'+col.id+'[]" name="'+col.id+'[]" value="'+d+'">';
                  break;

              default:
                  //code block
          }
          var clase='';
          if (col.clase!=''){
            clase='class="'+col.clase+'"';
          }
          fila=fila+'<td '+clase+' >'+d+'</td>';    
        
    });

    i.index++;

     if (i.options.indexOf('#')>=0){
          fila='<td class="_rowNum">'+i.index+'</th>'+fila;
      }

     if (i.options.indexOf('options')>=0){
          let optDel=i.optTableDel||optTableDel;
          fila=fila+'<td class="_rowOptions" >'+optDel+'</td>';
      }

    fila='<tr data-i="'+i.index+'" data-new="1" >'+fila+'</tr>';

    if (ret===true){
      return fila;
    }
    $('#'+id+' tbody').append(fila);
    
    numTabla(id);
  }


  modulo.add = function(item){
    if (item.id){
      items[item.id]=new Mk_Tabla(item);
    }
  };

  

  modulo.addTr=function (t,datos,ret){
   if (ret===true){
        var id=t;
      }else{
        var ret=false;
        var id=$(t).closest('table').prop('id');  
      }
      
      console.log('tablaid Add:',id, datos);
      if (id!=undefined){
        var i=items[id];
        let addFila=i.addTr || _addTr;
        if (isFunction(addFila)){
          return addFila(id,datos,ret);
        }
      }
  };

  modulo.delTr= function(t){
    var tr=$(t).closest('tr');
    var id=$(tr).closest('table').prop('id');
    var idr=$(tr).data('i');
    var i=items[id];
    var n=$(tr).data('new');
    var delFila=i.delTr || _delTr;
    if (isFunction(delFila)){
      if (delFila(tr,idr,n,id)==false){
        alert('No puede Eliminarse esta Fila!!!');
        return false;
      }
    }
    numTabla(id);
    return true;
  };




  modulo.show=function(id,datos,donde){
  var tabla='';
  var i=items[id];
  if (i){
  tabla=$(id);
  
  var head='';
  
  $.each(i.cols,function(j,col){
  head=head+'<th data-id="'+col.id+'" width="'+col.tam+'" data-type="'+col.type+'"  >'+col.label+'</th>';
  });

   if (i.options.indexOf('#')>=0){
      head='<th data-id="_num" width="10" data-type="num" class="cTabla" >#</th>'+head;
   }

     if (i.options.indexOf('options')>=0){
      let optAdd=i.optTableAdd||optTableAdd;
      head=head+'<th data-id="_options" width="50" data-type="icon"  >'+optAdd+'</th>';
      }

  
  //$(id+' thead').html(head);
  //console.log('thead:',head);
  if (!datos){
    var datos=i.getDatos();
  }else{
    if (isFunction(datos)){
      datos=datos(id);
    }
  }

    console.log('datos:',datos)
  var body='';
  $.each(datos,function(j,row){
    let fila=modulo.addTr(id,row,true);
    //console.log('fila:',fila);
    body=body+fila;
  });

  tabla='<table id="'+id+'" class="cTabla striped '+i.classTable+'" '+i.moreAttr+' >'+
    '<thead>'+
    head+
    '</thead>'+
    '<tbody>'+
    body+
    '</tbody>'+
    '</table>';
  }

  //  console.log('tabla:',tabla);
  if (donde){
    $(donde).html(tabla);
    return false;
  }
  return tabla;
};


})(Mk_Tablas);
