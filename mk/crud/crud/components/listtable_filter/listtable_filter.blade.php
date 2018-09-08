[[unique:]]
@section('js.inline')
function _changeFilter(f){
	reaction($('#frmFilter').serialize(),'','','.listTable');
}
@append 
[[:unique]]

<?php $options=\Mk\Tools\Form::getOptions($anexos[[[var:]]id[[:var]]][options],$_filter[[[var:]]id[[:var]]],'Todos '.$anexos[[[var:]]id[[:var]]][labelf],$anexos[[[var:]]id[[:var]]][join][grupo]);  ?>
<li>
	<select id="filter-[[var:]]id[[:var]]" name="_filter[[[var:]]id[[:var]]]"  class="browser-default listafilter" style="height: 40px;margin: 0;display: inline-block;" onchange="_changeFilter(this);" >
	{{$options}}
	</select>
</li>