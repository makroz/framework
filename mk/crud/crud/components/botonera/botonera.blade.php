@section('style.inline')
@media screen {
.botonera{
	padding:0.5em;
	display:inline-block;
	width:100%;

}
}
.botonera-panel > a {
	margin-right:0.5em;
	margin-left:0.5em;
}
.botonera-panel {
	padding:0.5em;
	margin-right:0.2em;
	margin-left:0.2em;
float:clear;
}
.separador{
	border-left:1px solid #000;
	width:5px;
}

@append

<div class="botonera z-depth-1 noprinter" >
<div class="botonera-panel z-depth-1 left" >

<a class="btn-floating  waves-effect waves-light green" title="Adicionar" data-action="add" onclick="clicBotonera(this);"><i class="material-icons">add</i></a>

@componente(botonesedittable,'')

</div>
<div class="botonera-panel z-depth-1 left "  >
@if( \Mk\Tools\App::isBuscar()==false )
@componente(button_print,'areaforprint=.listTable')
 @endif
@componente(button_buscar,'')
@if( \Mk\Tools\App::isBuscar()!=false )
<a class="btn-floating  waves-effect waves-light red" title="Enviar Seleccion" data-action="sel" onclick="clicBotonera(this);"><i class="material-icons">check_box</i></a>
 @endif
</div>

[[php:]]filtros[[:php]]


<div class="botonera-panel z-depth-1 right" style="padding:  0px;margin: 0px 3px 0 3px;line-height: 2px;" >

@componente(paginacion,'')
</div>

</div>
