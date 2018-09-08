<div class="input-field col [[var:]]clase[[:var]]">
	
	<textarea id="[[var:]]id[[:var]]" name="[[var:]]id[[:var]]" class="area {{$clasver}} [[var:]]validate[[:var]] [[var:]]classForm[[:var]] materialize-textarea" width="[[var:]]tam[[:var]]" [[var:]]eventos[[:var]] @if( $_action=='ver' )  disabled="disabled"  @endif  [[var:]]readonly[[:var]] data-defVal='{{$anexos[[[var:]]id[[:var]]][defVal]}}'  >{{$item[[[var:]]id[[:var]]]}}</textarea>

      <label for="[[var:]]id[[:var]]">{{$anexos[[[var:]]id[[:var]]][labelf]}}</label>
      <div class="error_input">{$errors[[[var:]]id[[:var]]][0]}</div>
</div>	