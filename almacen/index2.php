<?php 
if (is_array($_data) && sizeof($_data))
		extract($_data); $_text = array();$_text[] = "
 <!DOCTYPE html>
  <html>
    <head>
		<meta charset=\"utf-8\">
		<meta title=\"";$_text[] =  $_appTit; ;$_text[] = "asdad\">
		<meta name=\"viewport\" content=\"width=device-width, initial-scale=1.0\"/>
		";$_text[] = "";$_text[] = "

		";$_text[] = "

		";$_text[] = "

";$_text[] = "	        

		";$_text[] = "
			<script type=\"text/javascript\" src=\"js/jquery/jquery.js\"></script>
			<link type=\"text/css\" rel=\"stylesheet\" href=\"js/materialize/materializeicon.css\"/>
			<link type=\"text/css\" rel=\"stylesheet\" href=\"js/materialize/materialize.min.css\"/>
			<script type=\"text/javascript\" src=\"js/materialize/materialize.min.js\"></script>
			<link type=\"text/css\" rel=\"stylesheet\" href=\"../mk/js/mk.css\"/>
			<link type=\"text/css\" rel=\"stylesheet\" href=\"../mk/js/mkprint.css\" media=\"print\" />
			<script type=\"text/javascript\" src=\"../mk/js/mk.js\"></script>
			<link type=\"text/css\" rel=\"stylesheet\" href=\"css/css.css\" />
		";$_text[] = "
		";$_text[] = "
		";$_text[] = "

		<style>
			";$_text[] = "



.botonera{
	padding:1em;
}
.botonera-panel > a {
	margin-right:0.5em;
	margin-left:0.5em;
}
.botonera-panel {
	padding:1em;
	display:inline-block;
	margin-right:0.2em;
	margin-left:0.2em;
}
.separador{
	border-left:1px solid #000;
	width:5px;
}
.botonera li{
display: inline-block;
margin: 0 0 0 0;
list-style-type: none;
margin-right:0.5em;
margin-left:0.5em;
}


	.input-field.col label.labeltop{
	left: .75rem;
	position: absolute;
	top: -14px;
	font-size: .8rem;
	color: #9e9e9e;
	cursor: text;
	transition: .2s ease-out;
	}
	select.browser-default{
		cursor: pointer;
	background-color: transparent;
	border: none;
	border-bottom: 1px solid #9e9e9e;
	outline: none;
	height: 3rem;
	line-height: 3rem;
	width: 100%;
	font-size: 1rem;
	margin: 0 0 20px 0;
	padding: 0;
	display: block;
	}
	

table.highlight > tbody > tr:hover {
    background-color: #BFBFFF;
}
.sortable{
	background-image:url(\'img/sort.png\');
	background-repeat: no-repeat;
    background-position: left;
	padding-left:19px;
	cursor:pointer;
}
.sort_desc{
	background-image:url(\'img/sort_desc.png\');
}
.sort_asc{
	background-image:url(\'img/sort_asc.png\');
}
.tablaLista th{
	border-right:1px solid #888888;
	border-left:1px solid #888888;
}
.selTR, table.striped > tbody > tr.selTR:nth-child(2n+1), table.striped > tbody > tr.selTR:nth-child(2n+0) {
    background-color: red;
}


.treeg tr td a{
	display:none;
}
.treeg tr:hover td a{
	display:inline-block;
	margin-right:5px;
}
";$_text[] = "
		</style>

	</head>

	<body>
	<div id=\"loader-wrapper\">
      <div id=\"loader\"></div>
      <div class=\"loader-section section-left\"></div>
      <div class=\"loader-section section-right\"></div>
    </div>
    ";if (\Mk\Tools\App::isBuscar()==false ) {$_text[] = "
		<header class=\"noprinter\">
			";function anon_navigation0($_data){
				if (is_array($_data) && sizeof($_data))
		extract($_data); $_text = array();$_text[] = "<div class=\"navbar-fixed\">
	<ul id=\"submodulos\" class=\"dropdown-content\">
 			";

					$path = APP_PATH . "/application/modulos";
					$mmm='';
					$iterator = new DirectoryIterator($path);
					foreach ($iterator as $item)
					{
						if (!$item->isDot() && $item->isDir())
						{
							$file=$item->getFilename();
							$mmm=$mmm.'<li><a href = "index.php?url='.$file.'" >'.$file.'</a></li>';
						}
					}
				;$_text[] = "
				";$_text[] =  $mmm; ;$_text[] = "
		</ul>
	<nav>
		<div class=\"nav-wrapper\">
			<a href=\"#debug\" class=\"\" >Logo</a>
			";if (isset($_loged) ) {$_text[] = "
				(";$_text[] =  $_loged['id'].':'.$_loged['user']['nombre'] ;$_text[] = ")
			";}$_text[] = "

	        <ul class=\"right hide-on-med-and-down\">
				<li><a href=\"/\" > home</a></li>
				<li><a class=\"dropdown-trigger\" href=\"#!\" data-target=\"submodulos\" >Modulos<i class=\"material-icons right\">arrow_drop_down</i></a></li>
				<li><a href = \"index.php?url=resp/logout\" >logout</a></li>
				<li><a href = \"index.php?url=resp/login\" > login</a></li>
				";$_text[] = "
			</ul>
		</div>
	</nav>
</div>

";return implode($_text);
			};$_text[] = anon_navigation0($_data);$_text[] = "
		</header>
	";}$_text[] = "
		<main>
			";$_text[] =  $template ;$_text[] = "
		</main>

		<footer>
		</footer>
		";$_text[] = "";$_text[] = "
		";$_text[] = "<link type=\'text/css\' rel=\'stylesheet\' href=\'js/confirm/confirm.css\'/>
<link type=\'text/css\' rel=\'stylesheet\' href=\'js/datedropper/datedropper.css\'/>
<link type=\'text/css\' rel=\'stylesheet\' href=\'js/treegrid/treegrid.css\'/>
<script type=\'text/javascript\' src=\'js/confirm/confirm.js\'></script>
<script type=\'text/javascript\' src=\'js/printarea/printarea.js\'></script>
<script type=\'text/javascript\' src=\'js/datedropper/datedropper.js\'></script>
<script type=\'text/javascript\' src=\'js/loadingoverlay/loadingoverlay.min.js\'></script>
<script type=\'text/javascript\' src=\'js/treegrid/treegrid.js\'></script>
";$_text[] = "

		<script>
		$(window).on(\'load\', function() {
		    setTimeout(function() {
		      $(\'body\').addClass(\'loaded\');
		    }, 200);
		  });
			$(document).ready(function(){
				";$_text[] = "

$(document).ajaxStop(function(){
    showMensajes();
});
	$(\'#mk_formulario\').modal();
	$(\"select\").formSelect();
	showMensajes();


$(\'#mk_buscar\').modal();


	 $(\'input.datafecha\').dateDropper();
	 _search_campo_change($(\'#search_campo\'));
	

initListTable();
$_text[] = \"

$(\\\'.dropdown-trigger\\\').dropdown();

\";";$_text[] = "
			});
			";$_text[] = "     

    jconfirm.defaults = {
        title: \'Aviso\',
        boxWidth: \'30%\',
        useBootstrap: false
    };


function _fillForm(msg){
if (msg==\'error\'){
	$(\'#mk_formulario\').modal(\'close\');
	alert(\'error\');
}else{
	var datos=JSON.parse(msg);
	$.each(datos, function(i, item) {
		var type=$(\'#\'+i).prop(\"tagName\");
		if (type==\'INPUT\'){
			var type2=$(\'#\'+i).prop(\"type\");
			if (type2==\'checkbox\'){
				if (item==1){
					item=true;
				}else{
					item=false;
				}
				$(\'#\'+i).prop(\'checked\', item);
			}else{
				$(\'#\'+i).val(item);
			}
		}
		if (type==\'SELECT\'){
			$(\'#\'+i).find(\'option[value=\"\'+item+\'\"]\').prop(\'selected\', true);
		}
		//alert(i+\' es :\'+$(\'#\'+i).prop(\"tagName\"));
	});
	$(\"select\").formSelect();
}
return -1;
}
function initOpenForm(_respond,noejecutar){
if (!noejecutar){


	if ($(\'#_save_\').val()==\'edit\'){
	$(\'#estado option[value=\"A\"]\').prop(\'disabled\',true);
}else{
	$(\'#estado option[value=\"A\"]\').prop(\'disabled\',false);
}
[[printvar:openform]]
}
return \'001\';
}
function _openForm(f, idAction,tit){
		if ($(f).data(\'ultAction\')==undefined){
			$(f).data(\'ultAction\',\'ver\');
		}
		$(f).find(\'select\').each(function(index){
			var def=$(this).data(\'defval\');
			if (def==undefined){
				def=\'\';
			}
			if (def==\'\'){
				$(this).find(\'option:eq(0)\').prop(\'selected\', true);
			}else{
				$(this).val(def);
			}
		});
		$(f).find(\'input\').each(function(index){
			var def=$(this).data(\'defval\');
			if (def==undefined){
				def=\'\';
			}
			$(this).val(def);
		});
		$(f).find(\'.check\').each(function(index){
			var def=$(this).data(\'defval\');
			if (def==undefined){
				def=\'\';
			}
			if (def==\'\'){
				$(f).find(\'.check\').prop(\'checked\', false);
			}else{
				if (def==\'1\'){
					$(f).find(\'.check\').prop(\'checked\', true);
				}
			}
		});
		$(f).find(\'.error_input\').html(\'\');
		$(f).find(\'#_save_\').val(idAction);
		$(f).find(\'h4.modal-tit\').html(tit);
		if (idAction==\'ver\'){
			$(\'#btnSave\').hide();
			$(\'#btnPrint\').show();
			$(f).data(\'ultAction\',idAction);
		}else{
			$(\'#btnPrint\').hide();
			$(\'#btnSave\').show();
			$(\'#mk_formulario  .modal-footer\').find(\'.pag\').html(\'\');
			if (((idAction==\'add\')&&($(f).data(\'ultAction\')==\'ver\'))||(\'\'==\'1\')){
				reaction(\'\',idAction,\'\',\'#mk_formulario .modal-content\',initOpenForm);
			}else{
				
				
				
				
				
				
				
				
				
				
				
				
				
				
				
				
				
				
				
				
				
				
				
				if (idAction==\'add\'){
					initOpenForm();
				}
			}
			$(f).data(\'ultAction\',idAction);
		}
		actualizarUI();
		$(f).modal(\'open\');
}
function verItem(id){
	$(\'.mk_pag\').removeClass(\'active\');
	$(\'.mk_pag:contains(\"\'+id+\'\")\').addClass(\'active\');
	reaction(\'cod=\'+id,\'ver\',\'\',\'#mk_formulario .modal-content\');
}
function clicBotonera(boton){
var idSel = $(boton).parent().parent().data(\'cod\');
var idAction = $(boton).data(\'action\');
var selCount = 1;
var div=\'\'
if (idSel==undefined){
	idSel = serializar();
	selCount = $(\".list_check:checked\").length;
}
var options=[];
	options[\'cod\']=idSel;
	if (idAction==\'add\'){
		options=[];
		_openForm(\'#mk_formulario\',idAction,\'Adicionar Almacen\');
		//reaction(options,idAction,\'\',\'#mk_formulario .modal-content\');
		return false;
	}
	if (idAction==\'edit\'){
		if (selCount!=1){
		$.alert({ content:\'Debe escoger 1 fila y solo 1\',type: \'blue\'});
		return false;
		}
		_openForm(\'#mk_formulario\',idAction,\'Editar Almacen\');
		//reaction(options,\'getItem\',\'\',\'#mk_formulario .modal-content\',_fillForm,\'POST\');
		reaction(options,idAction,\'\',\'#mk_formulario .modal-content\',initOpenForm);
		return false;
	}
	if (idAction==\'del\'){
		if (selCount==0){
		$.alert({ content:\'Debe escoger al menos 1 fila\',type: \'blue\'});
		return false;
		}
		idAction=\'\';
		$.confirm({
		    title: \'Confirmacion\',
		    content: \'¿Esta seguro de querer borrar los registros marcados?\',
		    type:\'red\',
		    buttons: {
		        confirm: function () {
		            options[\'_del\']=\'del\';
					idAction=\'listar\';
					div=\'.listTable\';
					reaction(options,idAction,\'\',div);
		        },
		        cancel: function () {
		        }
		    }
		});
	}
	if (idAction==\'ver\'){
		if (selCount==0){
		$.alert({ content:\'Debe escoger al menos 1 fila\',type: \'blue\'});
		return false;
		}
		var pag=\'\';
		if (selCount>1){
			var cods=idSel.split(\',\');
			$.each(cods,function(i,item){
				pag=pag+\'<span class=\"mk_pag\" onclick=\"verItem(\'+item+\');\" >\'+item+\'</span>\';
			});
		}
		$(\'#mk_formulario  .modal-footer\').find(\'.pag\').html(pag);
		_openForm(\'#mk_formulario\',idAction,\'Ver Almacen\',true);
		reaction(options,idAction,\'\',\'#mk_formulario .modal-content\');
		return false;
	}
	if (idAction!=\'\'){
	reaction(options,idAction,\'\',div);
	//alert(\'Action Seleccionada: \'+idAction);
	}
	return false;
}


function printerArea(area){
	$(area).printArea();
}


	function _search_campo_change(elem){
		var valor=$(elem).val();
		var tipo= $(elem).find(\'option[value=\"\' + valor + \'\"]\').attr(\"class\");
		//alert(valor+\':\'+tipo);
		var fila=$(elem).closest(\'.row\');
		var cond=$(fila).find(\'.search_cond\');
		$(cond).find(\'option\').hide();
		$(cond).find(\'.\'+tipo).show().first().prop(\"selected\",\"selected\").change();;
		//$(cond).find(\'.\'+tipo).
		$(fila).find(\'._sc\').hide();
		$(fila).find(\'.\'+tipo).show();
	}
	function _search_addcampo(elem){
		var fila=$(elem).closest(\'.row\');
		if ($(elem).hasClass(\'blue\')){
			var copia=$(fila).clone();
			if ($(copia).find(\'.red\').length==0){
				$(elem).clone().removeClass(\'blue\').addClass(\'red\').html(\'<i class=\"material-icons\">delete</i>\').appendTo($(copia).find(\'.blue\').parent());
			}
			$(copia).find(\'.blue\').html(\'<i class=\"material-icons\">add</i>\');
			$(elem).hide().parent().addClass(\'s1\').removeClass(\'s2\');
			$(fila).find(\'.search_join\').show();
			$(fila).find(\'.isjoin\').val(1);
			$(copia).find(\'input:text\').val(\'\');
			var i=$(fila).data(\'count\')+1;
			$(copia).data(\'count\',i);
			$(copia).find(\'input, select\').each(function(){
				$(this).prop(\'id\',$(this).prop(\'id\')+i);
			});
			$(copia).find(\'label\').each(function(){
				$(this).prop(\'for\',$(this).prop(\'for\')+i);
			});
			$(copia).appendTo($(fila).parent());
			_search_campo_change($(copia).find(\'select:first\'));
			$(\'input.datafecha\').dateDropper();
		}else{
			if ($(fila).next().length>0){
				$(fila).remove();
			}else{
				$(fila).prev().find(\'.blue\').show().parent().addClass(\'s2\').removeClass(\'s1\');;
				$(fila).prev().find(\'.search_join\').hide();
				$(fila).prev().find(\'.isjoin\').val(0);
				$(fila).remove();
			}
		}
	}
	function _search_buscar(clear=false){
		//alert($(\'form#_searchform\').serialize());
		if (clear==true){
			reaction(\'&no_search=1&_runScriptLoad=initListTable();\',\'\',\'\',\'.listTable\');
		}else{
			reaction($(\'form#_searchform\').serialize()+\'&_runScriptLoad=initListTable();\',\'\',\'\',\'.listTable\');
		}
	}
	

function sortTable(th){
var options=[];
	if ($(th).hasClass(\'sort_asc\')){
		options[\'direction\']=\'desc\';
	}else{
		if ($(th).hasClass(\'sort_desc\')){
			options[\'direction\']=\'asc\';
		}else{
			options[\'order\']=$(th).data(\'field\');
		}
	}
reaction(options,\'\',\'\',\'.listTable\');
}
function initListTable(){
  $(\'.sortable\').click(function() {
	  sortTable(this);
	});
	$(\'#mk_buscar\').modal();
}


function serializar(){
var dato=\'\';
$(\".list_check:checked\").each(function() {
	if (dato==\'\'){dato=dato+this.value;}else{dato=dato+\',\'+this.value;}
 });
 return dato;
}
function clicsel(){
$(\".list_check\").parent().parent().removeClass(\'selTR\');
$(\".list_check:checked\").each(function () {
      $(this).parent().parent().addClass(\'selTR\');
    });
if (window.selclic){
		selclic($(\'.list_check:checked\').length,$(\'.list_check:checked\').val(),$(\'.list_check:checked\').attr(\"tag\"));
}
}
function chequear(d){
$(\".list_check\").each(function() {
   this.checked = d;
 });
clicsel();
}
function clicChecked(id){
	if (id==0){
		chequear($(\'#list_check_all\').is(\':checked\'));
	}else{
	$(\'#list_check_\'+id).attr(\'checked\',!$(\'#list_check_\'+id).is(\':checked\'));
	clicsel();
	}
}


function cambiarStatus(item){
var pk=$(item).data(\'pk\');
var status=$(item).data(\'status\');
var options=[];
	options[\'pk\']=pk;
	options[\'campos[status]\']=status;
var link=reaction(options,\'setData\',\'\',true);
getAjax(link,\'GET\',{ },item, function(msg){
     if (msg>=0){
     	var newstatus=\'0\';
     	var icon=\'E\';
     	if (status==\'0\'){
     		newstatus=\'1\'
     		icon=\'X\';
     	}
     	$(item).data(\'status\',newstatus).attr(\'src\',\'img/\'+icon+\'.png\');
     }
   });
}


function grabado(msg){
if (msg==\'ok\'){
	$(\'#mk_formulario\').modal(\'close\');
	reaction(\'\',\'\',\'\',\'.listTable\');
}else{
	var error=JSON.parse(msg);
	$.each(error, function(i, item) {
		$(\'#\'+i).parent().find(\'.error_input\').html(item);
	});
}
return -1;
}


function binderNodeTree(){
	$( \'.treeg tr td\' ).off( \"click\", \"**\" );
	 $(\'.treeg tr td\').on(\'click\',\'i:contains(\"add\")\',function(){addNodeTree(this)});
	 $(\'.treeg tr td\').on(\'click\',\'i:contains(\"edit\")\',function(){editNodeTree(this)});
	 $(\'.treeg tr td\').on(\'click\',\'i:contains(\"delete\")\',function(){delNodeTree(this)});
}
var nodedeltree;
function delNodeTree(node){
	node=$(node).closest(\'tr\');
	if (($(node).treegrid(\'isLeaf\'))&&($(node).treegrid(\'getDepth\')>0)){
		nodedeltree=node;
		var t=node.find(\'td:eq(0)\').text();
		$.confirm({
		    title: \'Confirmacion\',
		    content: \'¿Esta seguro de querer borrar este Nodo?:\'+t,
		    type:\'red\',
		    buttons: {
		        confirm: function () {
		        	var pp1=\'#\'+$(nodedeltree).closest(\'table\').prop(\'id\');
		        	nodedeltree.remove();
        			$(pp1).treegrid();
        			$(\'#\'+$(pp1).attr(\'for\')).val(getNodosTree(pp1));
		        },
		        cancel: function () {
		        }
		    }
		});
	}
}
function editNodeTree(node){
	node=$(node).closest(\'tr\');
	if (($(node).treegrid(\'isLeaf\'))&&($(node).treegrid(\'getDepth\')>0)){
		var id=node.prop(\'id\')
		var t=node.find(\'td:eq(0)\').text();
		var t1 = prompt(\"Ingrese el Texto para Editar\", t);
		if (t1 != null) {
			t1=node.find(\'td:eq(0)\').html().replace(t,t1);
			node.find(\'td:eq(0)\').html(t1);
		}
		var pp=\'#\'+$(node).closest(\'table\').prop(\'id\');
		$(\'#\'+$(pp).attr(\'for\')).val(getNodosTree(pp));
	}
}
function addNodeTree(node){
	node=$(node).closest(\'tr\');
	var id=node.prop(\'id\');
	id=id.replace(\'node-\',\'\');
	var idp=node.treegrid(\'getParentNodeId\')
	var t1 = prompt(\"Ingrese el Texto para Adicionar\", \'\');
	var n=node.clone();
	var pp=\'#\'+$(node).closest(\'table\').prop(\'id\');
	var nid;
	if (t1 != null) {
		nid=$(pp).find(\'tr\').length+1;
		$(pp).treegrid(\'getAllNodes\').each(function(){
			var oid=$(this).prop(\'id\');
			oid=oid.replace(\'node-n\',\'\');
			if (isNaN(oid)==false){
				if (oid>=nid){
					nid=oid+1;
				}
			}
		});
		$(n).removeClass(\'treegrid-\'+id).removeClass(\'treegrid-expanded\').removeClass(\'treegrid-parent-\'+idp).addClass(\'treegrid-n\'+nid).addClass(\'treegrid-parent-\'+id).prop(\'id\',\'node-n\'+nid);
		n.find(\'td:eq(0)\').html(t1);
		node.after(n);
		$(pp).treegrid();
		binderNodeTree();
		$(\'#\'+$(pp).attr(\'for\')).val(getNodosTree(pp));
		//setNodosTree(pp,$(\'#\'+$(pp).attr(\'for\')).val());
	}
}
";$_text[] = "
		</script>
	</body>
</html>";return implode($_text);
?>