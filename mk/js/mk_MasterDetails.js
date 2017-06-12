/*Modulo MasterDetalle*/
/*
function Mk_MasterDetail(options){
  this.type= options.type || 'inline';
  this.master= options.master || '';
  this.slave= options.slave || '';
  this.campos=  options.campos || [];
  this.claseHead=  options.claseHead || false;
  this.claseBody=  options.claseBody || false;
  };
*/  
var Mk_MasterDetails = {};
(function (modulo){
  var items = [];
  var cant=0;
  var isInit=false;

  function Mk_MasterDetail(options){
  this.id= options.id || '0';  
  this.type= options.type || 'inline';
  this.master= options.master || '';
  this.slave= options.slave || '';
  this.campos=  options.campos || [{name:'col1',tam:'100',type:'alfa'}];
  this.claseTable=  options.claseTable || '';
  };
  

  modulo.init=function(donde){
    $(donde).find('table.tDetalle').each(function(){
        var t=this;
        var id=$(this).prop('id'),
        master=$(this).data('tMaster'),
        slave=$(this).data('tSlave'),
        type=$(this).data('type'),
        campos=JSON.parse($(this).data('campos'));
        this.add({id:id,master:master,slave:slave,type:type,campos:campos});
    });
    isInit=true;
    return false;
  };

  modulo.add = function(item){
    if (isInit==false){
      this.init('body');
    }
    if (item.id){
      items[item.id]=new Mk_MasterDetail(item);
    }
  };

  modulo.show = function(id,donde){
    if (isInit==false){
      this.init('body');
    }
    var t ='';
    if((items[id])){
      let i=items[id];
      let td='';
      let col= JSON.stringify(i.campos);
      //console.log('campos:'+col,col);
      t = '<table id="'+id+'" class="tDetalle '+i.claseTable+' striped" data-tMaster="'+i.master+'" data-tSlave="'+i.slave+'" data-campos="'+col+'" data-type="'+i.type+'" >'+
      '  <thead>';
      '    <tr>'+
      $.each(i.campos,function(j,dato){
        t=t+'<th data-tam="'+dato.tam+'" data-type="'+dato.type+'">'+dato.name+'</th>';
        td=td+'<td>'+dato.type+' '+dato.tam+'</td>';
      });
      t=t+'  </thead>'+
      '  <tbody>'+
      '    <tr>'+td+'</tr>'+
      '  </tbody>'+
      '</table>';
    }
    if (!donde){
      return t; 
    }
    $(donde).html(t);
    return false;
  };


  modulo.isEmpty= function(){
    return true;
  }

})(Mk_MasterDetails);
