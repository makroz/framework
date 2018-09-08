@section('js.onready')
$(document).ajaxStop(function(){
    showMensajes();
});

	$('#mk_formulario').modal();
	$("select").formSelect();
	showMensajes();




@append

@section('js.files')
<link href='js/confirm/confirm.css' rel='stylesheet'>
<script type='text/javascript' src='js/confirm/confirm.js'></script>
@append


@section('style.inline')
@append

@section('js.inline')
    jconfirm.defaults = {
        title: 'Aviso',

        boxWidth: '30%',
        useBootstrap: false
    };




@append

<div class="mk-section">
@componente(titulos,'text={{$modTitulo}}')
</div>

<div class="listTable">
<!-- ajax: -->

<div class="mk-section">
@componente(botonera,'')
</div>

@componente(listtable,'')

<!-- :ajax -->
</div>

	<div id="mk_formulario" class="modal modal-fixed-footer">
	    <h4 class="modal-tit">
			Adicionar
		</h4>

	    <div class="modal-content">
	@componente(formulario,'mostrar=1')
	    </div>


<div class="modal-footer" >
<div class="pag white-text" style="float: left;"></div>
				<a href="#!" class=" modal-action modal-close waves-effect waves-red btn-flat " >Volver</a>
				<a href="#!" id="btnSave" class=" modal-action  waves-effect waves-green btn-flat btnPrevAjax " onclick="_sendForm('#frmEdit',1,grabado);" >Grabar</a>
				<a href="#!" id="btnSaveNext" class=" modal-action  waves-effect waves-green btn-flat btnPrevAjax " onclick="_sendForm('#frmEdit',1,grabado,true);" >Grabar y Seguir</a>
				<a href="#!" id="btnPrint" class=" modal-action  waves-effect waves-blue btn-flat " onclick="printerArea('#mk_formulario .modal-content');" >Imprimir</a>
        </div>

	</div>
