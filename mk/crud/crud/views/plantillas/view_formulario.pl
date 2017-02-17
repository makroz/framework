{% append js.onready %}
$(document).ajaxStop(function(){
    showMensajes();
});

	$("select").material_select();
	showMensajes();

{% /append %}

{% append js.files %}
<link href='js/confirm/confirm.css' rel='stylesheet'>
<script type='text/javascript' src='js/confirm/confirm.js'></script>
{% /append %}


{% append style.inline %}
{% /append %}

{% append js.inline %}
    jconfirm.defaults = {
        title: 'Aviso',
        
        boxWidth: '30%',
        useBootstrap: false
    };

{% /append %}

<div class="listTable">
<!-- ajax: -->

<div class="mk-section">
[[component:]]titulos::text={% echo $modTitulo; %}[[:component]]
</div>

<div class="mk-section">
[[component:]]botonera[[:component]]
</div>

[[component:]]listtable[[:component]]   
<!-- :ajax -->
</div>
