@section('js.files')
<script type="text/javascript" src="js/printarea/printarea.js"></script>
@append 

@section('js.inline')
function printerArea(area){
	$(area).printArea();
}
@append 

<a class="btn-floating  waves-effect waves-light blue" title="Imprimir" onclick="printerArea('[[var:]]areaforprint[[:var]]');"><i class="material-icons">print</i></a>