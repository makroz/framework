

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

/*modulo tablas*/
var Mk_Tablas ={};
(function (modulo){
   var items = [];
   var optionsTable='<a class="btn-floating  waves-effect waves-light green" onclick="Mk_Tablas.addTr(this);" >'+
      '<i class="material-icons">add</i>'+
      '</a>';

  function Mk_Tabla(options){
  this.id= options.id || '0';
  this.classTable=  options.classTable || '';
  this.type=  options.type || 0;
  this.moreAttr=  options.moreAttr || '';
  this.cant=  options.cant || 0;
  this.cols = options.cols || [{id:'id',label:'label',type:'text',tam:'',clase:''}];
  this.addTr = options.addTr || false;
  this.delTr = options.delTr || false;
  this.getDatos = options.getDatos || function(){return [];};
  this.optionsTable= options.optionsTable || false;
  
  }

  function numTabla(id,col){
    if (!col){
      var col=0;
    }
    var nrow=0;
    $('#'+id+' tbody tr').each(function(i,fila){
        $(this).find('td:eq('+col+')').html(i+1);
    });


  }

  function _addTr(id,datos){
    var i=items[id];
    var fila='';
    $.each(i.cols,function(j,col){
          let d='';
          if (datos){
            d=datos[j];
          }
          if (col.type=='text'){
            fila=fila+'<td>'+d+'</td>';    
          }
        
    });

     if (i.type==1){
          //let nrow=$('#'+id+' tbody tr').length+1;
          fila='<td class="cTabla">.</th>'+fila;
          fila=fila+'<td class="_rowOptions" >options</td>';
      }
    fila='<tr>'+fila+'</tr>';
    $('#'+id+' tbody').append(fila);
    numTabla(id);
  }


  modulo.add = function(item){
    if (item.id){
      items[item.id]=new Mk_Tabla(item);
    }
  };

 modulo.addTr= function(t,datos){
      id=$(t).closest('table').prop('id');
      //console.log('tablaid:',id);
      if (id!=undefined){
        var i=items[id];
        let addFila=i.addTr || _addTr;
        if (isFunction(addFila)){
          addFila(id,datos);
        }
      }
  };

  modulo.show=function(id,datos,donde){
  var tabla='';
  var i=items[id];
  if (i){
  tabla=$(id);
  //console.log('tabla:',i.getDatos);
  
  
  var head='';
  
  $.each(i.cols,function(j,col){
  head=head+'<th data-id="'+col.id+'" width="'+col.tam+'" data-type="'+col.type+'"  >'+col.label+'</th>';
  });

  if (i.type==1){
      var nrow=0;
      let opt=i.optionsTable||optionsTable;
      head='<th data-id="_num" width="10" data-type="num" class="cTabla" >#</th>'+head;
      head=head+'<th data-id="_options" width="50" data-type="icon"  >'+opt+'</th>';
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
    i.cant=j+1;
    let fila='';
    $.each(i.cols,function(n,col){
      fila=fila+'<td  >'+row+'</td>';
    });


      if (i.type==1){
            nrow++;
          fila='<td class="cTabla">'+nrow+'</th>'+fila;
          fila=fila+'<td class="_rowOptions" >options</td>';
      }

    fila='<tr data-i="'+j+'">'+fila+'</tr>';
    body=body+fila;
  });

  tabla='<table id="'+id+'" class="cTabla" '+i.classTable+'" '+i.moreAttr+' >'+
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
