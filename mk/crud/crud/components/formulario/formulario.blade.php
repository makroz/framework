@section('js.inline')

function grabado(msg){
if (msg=='ok'){
	if (GrabarSeguir==true){
		cleanForm('#frmEdit','.grabarSeguir');
		$('.grabarSeguir:visible:first').focus();
		GrabarSeguir=false;
	}else{
		$('#mk_formulario').modal('close');

	}
	reaction('','','','.listTable');	
}else{
	var error=JSON.parse(msg);
	$.each(error, function(i, item) {
		$('#'+i).parent().find('.error_input').html(item);
	});
}	
return -1;
}

[[php:]]codejs[[:php]]

@append 
<div class="errorList"></div>
<form id="frmEdit" data-_action='{$_action}' enctype="multipart/form-data" action="reaction('','save','',true);"  method="post" data-target='' class="$_action"  >
<div class="row">
[[php:]]inputs[[:php]]
</div>
<input type="hidden" name="_save_" id="_save_" value="{{$_action}}">
</form>
<!-- notajax: -->
@if( ('[[var:]]mostrar[[:var]]'!='1') ) 
<div class="modal-footer" >
<div class="pag white-text" style="float: left;"></div>
				<a href="#!" class=" modal-action modal-close waves-effect waves-red btn-flat " >Volver</a>
				<a href="#!" id="btnSave" class=" modal-action  waves-effect waves-green btn-flat btnPrevAjax" onclick="_sendForm('#frmEdit',0,grabado);" >Grabar</a>
				@if( ($_action=='add') ) 
				<a href="#!" id="btnSaveNext" class=" modal-action  waves-effect waves-green btn-flat btnPrevAjax" onclick="_sendForm('#frmEdit',0,grabado,true);" >Grabar y Seguir</a>
				 @endif 
				@if( ($_action=='ver') ) 
				<a href="#!" id="btnPrint" class=" modal-action  waves-effect waves-blue btn-flat " onclick="printerArea('#mk_formulario .modal-content');" >Imprimir</a>
				 @endif 

        </div>
 @endif         
<!-- :notajax -->

		
        


