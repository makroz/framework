{% append js.onready %}
$("select").material_select();

$(".tablaLista").colResizable({
    liveDrag:true,
    gripInnerHtml:"<div class='grip'></div>", 
    draggingClass:"dragging",
    disabledColumns:[0,2,3],
    postbackSafe:false,
	partialRefresh:true,
	headerOnly:true
    
  }); 

  $('.sortable').click(function() {
  sortTable(this);
	});

{% /append %}

{% append js.files %}
<link href='js/colresize/colResizable.css' rel='stylesheet'>
<script type='text/javascript' src='js/colresize/colResizable.js'></script>
{% /append %}


{% append style.inline %}
table.highlight > tbody > tr:hover {
    background-color: #BFBFFF;
}


.sortable{
	background-image:url('/components/listatable/img/sort.png');
	background-repeat: no-repeat;
    background-position: left;
	padding-left:19px;
	cursor:pointer;	
}

.sort_desc{
	background-image:url('/components/listatable/img/sort_desc.png');
}

.sort_asc{
	background-image:url('/components/listatable/img/sort_asc.png');
}

.tablaLista th{
	border-right:1px solid #888888;
	border-left:1px solid #888888;
}

.selTR, table.striped > tbody > tr.selTR:nth-child(2n+1), table.striped > tbody > tr.selTR:nth-child(2n+0) {
    background-color: red;
}
{% /append %}

{% append js.inline %}

function sortTable(th){
var options=[];

	if ($(th).hasClass('sort_asc')){
		options['direction']='desc';
	}else{
		if ($(th).hasClass('sort_desc')){
			options['direction']='asc';
		}else{
			options['order']=$(th).data('field');
		}
	}

reaction(options);

}

function serializar(){
var dato='';
$(".list_check:checked").each(function() {
	if (dato==''){dato=dato+this.value;}else{dato=dato+','+this.value;}
 });
 return dato;
 
}

function clicsel(){
$(".list_check").parent().parent().removeClass('selTR');
$(".list_check:checked").each(function () {
      $(this).parent().parent().addClass('selTR');
    });
if (window.selclic){
		selclic($('.list_check:checked').length,$('.list_check:checked').val(),$('.list_check:checked').attr("tag"));
}

}

function chequear(d){
$(".list_check").each(function() {
   this.checked = d;
 });
clicsel();
}

function clicChecked(id){
	if (id==0){
		//$('.list_check').attr('checked',$('#list_check_all').is(':checked')); 
		chequear($('#list_check_all').is(':checked'));
	}else{
	//alert('presono id:'+id+' '+$('#list_check_'+id).is(':checked'));
	$('#list_check_'+id).attr('checked',!$('#list_check_'+id).is(':checked')); 
	clicsel();
	}
  //$('#'+id).attr('checked',!$('#'+id).is(':checked')); 
  //return false;
}

{% /append %}

<div class="mk-section">
[[component:]]titulos::text={% echo $modTitulo; %}[[:component]]
[[component:]]titulos[[:component]]
</div>


<div class="mk-section">
[[component:]]botonera[[:component]]
</div>
[[component:]]botonera[[:component]]

{% if $items != false %}



<table class="striped bordered highlight tablaLista">
        <thead class="red">
          <tr>
          	 <th  width="5%" class="center" > 

      <input type="checkbox" id="{% echo 'list_check_all'; %}" name="{% echo 'list_check_all'; %}"  data-type="{% echo 'check'; %}" data-on="{% echo '1'; %}" data-off="{% echo '0'; %}" onclick="clicChecked('0');" />
      <label for="{% echo 'list_check_all'; %}"></label>

          	 </th>
              <th data-field="pk" width="20%" class="sortable {% if ($order=='pk') %} sort_{% echo $direction; %} {% /if %}" >Codigo</th>
              <th data-field="nombre" width="80%" class="sortable {% if ($order=='nombre') %} sort_{% echo $direction; %} {% /if %}" >Nombre</th>
              <th data-field="status" width="5%" class="sortable {% if ($order=='status') %} sort_{% echo $direction; %} {% /if %}" >St</th>
              <th data-field="act" width="20%">Accion</th>
          </tr>
        </thead>

        <tbody>
    {% php $nr=0; %}
	{% foreach $row in $items %}
	{% php $nr=$nr+1; %}
	<tr>
		<td class="center" > 
 <input type="checkbox" id="list_check_{% echo $row[pk]; %}" name="list_check_{% echo $row[pk]; %}"  class="list_check" onclick="clicChecked('{% echo $row[pk]; %}');" value="{% echo $row[pk] %}" />
      <label for="list_check_{% echo $row[pk]; %}"></label>
		 </td>	
		<td > {% echo $row[pk] %} </td>
		<td > {% echo $row[nombre] %} </td>
		<td > {% echo $row[status] %} </td>
		<td style="overflow: visible;"> 
<div style="position: relative;">
<div class="fixed-action-btn horizontal click-to-toggle" style="position: absolute; display: inline-block;top: -18px;">
    <a class="btn-floating btn-medium red">
      <i class="large material-icons">menu</i>
    </a>
    <ul style="top: -14px;right: 30px;" data-cod='{% echo $row[pk] %}'>
      [[component:]]botonesedittable[[:component]]
    </ul>
  </div>
</div>
		</td>

	</tr>
	{% /foreach %}

	{% foreach $_i in range($nr, $limit-1) %}
		<tr>
		<td >&nbsp; </td>
		<td >&nbsp; </td>
		<td > </td>
		<td > </td>
		<td > </td>
		</tr>
	{% /foreach %}
  </tbody>
      </table>



	

	
       

{% /if %}