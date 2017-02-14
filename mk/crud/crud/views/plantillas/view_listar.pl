{% append js.onready %}
	$("select").material_select();
	
{% /append %}

{% append js.files %}

{% /append %}


{% append style.inline %}

{% /append %}

{% append js.inline %}

{% /append %}

<div class="mk-section">
[[component:]]titulos::text={% echo $modTitulo; %}[[:component]]
</div>

<div class="listTable">
<!-- ajax: -->

<div class="mk-section">
[[component:]]botonera[[:component]]
</div>

{% if $items != false %}
[[component:]]listtable[[:component]]   
{% /if %}
{% else %}
No ha ningun campo por mostrar
{% /else %}
<!-- :ajax -->
</div>
