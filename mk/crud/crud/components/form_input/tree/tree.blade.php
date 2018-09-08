[[unique:]]
@section('style.inline')
.treeg tr td a{
	display:none;
}
.treeg tr:hover td a{
	display:inline-block;
	margin-right:5px;
}


@append 

@section('js.files')
	<link href='js/treegrid/treegrid.css' rel='stylesheet'>
	<script type='text/javascript' src='js/treegrid/treegrid.js'></script>
@append 

@section('js.inline')

function binderNodeTree(){
	$( '.treeg tr td' ).off( "click", "**" );
	 $('.treeg tr td').on('click','i:contains("add")',function(){addNodeTree(this)});
	 $('.treeg tr td').on('click','i:contains("edit")',function(){editNodeTree(this)});
	 $('.treeg tr td').on('click','i:contains("delete")',function(){delNodeTree(this)});
}
var nodedeltree;
function delNodeTree(node){
	node=$(node).closest('tr');
	if (($(node).treegrid('isLeaf'))&&($(node).treegrid('getDepth')>0)){
		nodedeltree=node;
		var t=node.find('td:eq(0)').text();
		$.confirm({
		    title: 'Confirmacion',
		    content: '¿Esta seguro de querer borrar este Nodo?:'+t,
		    type:'red',
		    buttons: {
		        confirm: function () {
		        	var pp1='#'+$(nodedeltree).closest('table').prop('id');
		        	nodedeltree.remove();
        			$(pp1).treegrid();
        			$('#'+$(pp1).attr('for')).val(getNodosTree(pp1));
		        },
		        cancel: function () {
		        }
		    }
		});
	}
}
function editNodeTree(node){
	node=$(node).closest('tr');
	if (($(node).treegrid('isLeaf'))&&($(node).treegrid('getDepth')>0)){
		var id=node.prop('id')
		var t=node.find('td:eq(0)').text();
		var t1 = prompt("Ingrese el Texto para Editar", t);
		if (t1 != null) {
			t1=node.find('td:eq(0)').html().replace(t,t1);
			node.find('td:eq(0)').html(t1);
		}
		var pp='#'+$(node).closest('table').prop('id');
		$('#'+$(pp).attr('for')).val(getNodosTree(pp));
	}
}
function addNodeTree(node){
	node=$(node).closest('tr');
	var id=node.prop('id');
	id=id.replace('node-','');
	var idp=node.treegrid('getParentNodeId')
	var t1 = prompt("Ingrese el Texto para Adicionar", '');
	var n=node.clone();
	var pp='#'+$(node).closest('table').prop('id');
	var nid;
	if (t1 != null) {
		nid=$(pp).find('tr').length+1;
		$(pp).treegrid('getAllNodes').each(function(){
			var oid=$(this).prop('id');
			oid=oid.replace('node-n','');
			if (isNaN(oid)==false){
				if (oid>=nid){
					nid=oid+1;
				}
			}
		});
		$(n).removeClass('treegrid-'+id).removeClass('treegrid-expanded').removeClass('treegrid-parent-'+idp).addClass('treegrid-n'+nid).addClass('treegrid-parent-'+id).prop('id','node-n'+nid);
		n.find('td:eq(0)').html(t1);
		node.after(n);
		$(pp).treegrid();
		binderNodeTree();
		$('#'+$(pp).attr('for')).val(getNodosTree(pp));
		//setNodosTree(pp,$('#'+$(pp).attr('for')).val());
	}
}
@append 

@section('openform')
	 $('.treeg').treegrid();
	 binderNodeTree();
@append

 
[[:unique]]

@section('openform')
	setNodosTree('#tree-[[var:]]id[[:var]]',$('#[[var:]]id[[:var]]').val());
@prependsection


<div class="input-field col [[var:]]clase[[:var]]">
	  <input  id="[[var:]]id[[:var]]" name="[[var:]]id[[:var]]" type="hidden" value='{{$item[[[var:]]id[[:var]]]}}' data-defval='{{$anexos[[[var:]]id[[:var]]][defVal]}}' class=" [[var:]]classForm[[:var]]" >	
      <label class="labeltop" for="[[var:]]id[[:var]]">{{$anexos[[[var:]]id[[:var]]][labelf]}}</label>
      <div class="error_input">{$errors[[[var:]]id[[:var]]][0]}</div>
	
	<table  id="tree-[[var:]]id[[:var]]" name="tree-[[var:]]id[[:var]]" class="treeg" for="[[var:]]id[[:var]]" width="[[var:]]tam[[:var]]">
	{{$nodes}}
	</table>
</div>	
