<div class="input-field col [[var:]]clase[[:var]]">
      <input id="[[var:]]id[[:var]]" name="[[var:]]id[[:var]]" type="password" class="alfa {{$clasver}} [[var:]]validate[[:var]] [[var:]]classForm[[:var]]" width="[[var:]]tam[[:var]]" value='{{$item[[[var:]]id[[:var]]]}}' [[var:]]eventos[[:var]] @if( $_action=='ver' )  disabled="disabled"  @endif  [[var:]]readonly[[:var]] data-defVal='{{$anexos[[[var:]]id[[:var]]][defVal]}}'>
      <label for="[[var:]]id[[:var]]">{{$anexos[[[var:]]id[[:var]]][labelf]}}</label>
      <div class="error_input">{$errors[[[var:]]id[[:var]]][0]}</div>
</div>	