@section('js.files')
<script type='text/javascript' src='../mk/js/ckeditor/ckeditor.js'></script>
@append 
@section('openform')
	contenidoEditor_[[var:]]id[[:var]]=CKEDITOR.replace( '[[var:]]id[[:var]]',{
     filebrowserBrowseUrl: 'js/ckfinder/ckfinder.html',
     filebrowserImageBrowseUrl: 'js/ckfinder/ckfinder.html?type=Images',
     filebrowserUploadUrl: 'js/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Files',
     filebrowserImageUploadUrl: 'js/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Images'
 } );


contenidoEditor_[[var:]]id[[:var]].on( 'change', function( evt ) {
		$('#[[var:]]id[[:var]]').val(evt.editor.getData());
});
@prependsection

@section('cleanform')
	if (isDefined('contenidoEditor_[[var:]]id[[:var]]')){
		contenidoEditor_[[var:]]id[[:var]].setData('');
	}
@prependsection

<div class="input-field col [[var:]]clase[[:var]]">
	
	<textarea id="[[var:]]id[[:var]]" name="[[var:]]id[[:var]]" class="editor {{$clasver}} [[var:]]validate[[:var]] [[var:]]classForm[[:var]] " width="[[var:]]tam[[:var]]" [[var:]]eventos[[:var]] @if( $_action=='ver' )  disabled="disabled"  @endif  [[var:]]readonly[[:var]] data-defVal='{{$anexos[[[var:]]id[[:var]]][defVal]}}'  >{{$item[[[var:]]id[[:var]]]}}</textarea>

      <label for="[[var:]]id[[:var]]">{{$anexos[[[var:]]id[[:var]]][labelf]}}</label>
      <div class="error_input">{$errors[[[var:]]id[[:var]]][0]}</div>
</div>	