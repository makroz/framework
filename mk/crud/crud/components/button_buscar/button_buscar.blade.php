@section('js.onready')
$('#mk_buscar').modal();
@append

<a class="btn-floating  waves-effect waves-light blue" title="Buscar" onclick="$('#mk_buscar').modal('open');"><i class="material-icons">search</i></a>
@if( ($searchMsg!='') ) {{$searchMsg}} <i class="tiny material-icons red white-text" title="Limpiar busqueda" onclick="_search_buscar(true);">close</i> @endif
@componente(listtable_buscar,'')
