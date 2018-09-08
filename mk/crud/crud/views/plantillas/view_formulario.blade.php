@section('js.onready')
$(document).ajaxStop(function(){
    showMensajes();
});

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
	    <h4 class="modal-tit">
			@componente(titulos,'text=Adicionar')
		</h4>

<div class="container">
<!-- ajax: -->
@componente(formulario,'')
<!-- :ajax -->
</div>
