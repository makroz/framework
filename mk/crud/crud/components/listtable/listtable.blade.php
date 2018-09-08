@section('js.onready')
initListTable();
@append 

@section('js.files')
<script type='text/javascript' src='js/loadingoverlay/loadingoverlay.min.js'></script>
@append 

@section('style.inline')
table.highlight > tbody > tr:hover {
    background-color: #BFBFFF;
}

.sortable{
	background-image:url('img/sort.png');
	background-repeat: no-repeat;
    background-position: left;
	padding-left:19px;
	cursor:pointer;	
}

.sort_desc{
	background-image:url('img/sort_desc.png');
}

.sort_asc{
	background-image:url('img/sort_asc.png');
}

.tablaLista th{
	border-right:1px solid #888888;
	border-left:1px solid #888888;
}

.selTR, table.striped > tbody > tr.selTR:nth-child(2n+1), table.striped > tbody > tr.selTR:nth-child(2n+0) {
    background-color: red;
}
@append 

@section('js.inline')

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


reaction(options,'','','.listTable');

}

function initListTable(){

  $('.sortable').click(function() {
	  sortTable(this);
	});

	$('#mk_buscar').modal();
}

@append 


<table class="striped bordered highlight tablaLista">
	<thead class="red">
		<tr>
			<th  width="30" class="center noprinter" > 
				@componente(listtable_checkall,'')
			</th>
			[[php:]]encabezados[[:php]]

			@if( ($anexos['listAction']=='show') ) 
			<th data-field="act" width="290" class=" noprinter">Accion</th>
			 @endif 
		</tr>
	</thead>

	<tbody>
		<?php $nr=0;  ?>
		@foreach($items as $row_i=>$row)
		<?php $nr=$nr+1;  ?>
		<tr>


			<td class="center noprinter" > 
				@componente(listtable_checkrow,'')
			</td>	
			[[php:]]filas[[:php]]

			@if( ($anexos['listAction']=='show') ) 
			<td style="overflow: visible;" class="noprinter"> 
				<div style="position: relative;">
					<div class="fixed-action-btn horizontal click-to-toggle" style="position: absolute; display: inline-block;top: -18px;">
						<a class="btn-floating btn-medium red">
							<i class="large material-icons">menu</i>
						</a>
						<ul style="top: -14px;right: 30px;" data-cod='{{$row[pk]}}'>
							@componente(botonesedittable,'')
						</ul>
					</div>
				</div>
			</td>
			 @endif 
		</tr>
		@endforeach 
		@if( $nr<$limit ) 
		@foreach(range($nr+1, $limit) as $_i_i=>$_i)
		<tr class="noprinter">

			<td class="noprinter" >&nbsp; </td>
			[[php:]]filasvacias[[:php]]
			@if( ($anexos['listAction']=='show') ) 
			<td class="noprinter" > </td>
			 @endif 
		</tr>
		@endforeach 
		 @endif 
	</tbody>
</table>
<!-- onlyajax: -->
<script type="text/javascript">
	initListTable();
</script>
<!-- :onlyajax --> 
