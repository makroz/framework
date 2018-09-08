<div class="input-field col [[var:]]clase[[:var]]">
<label for="[[var:]]id[[:var]]">
@if( $_action!='ver' )  
  <input type="checkbox" id="[[var:]]id[[:var]]" name='[[var:]]id[[:var]]' class="check $clasver  [[var:]]classForm[[:var]]" value="[[var:]]dataon[[:var]]" @if( ($item[[[var:]]id[[:var]]]=="[[var:]]dataon[[:var]]") )  checked="checked"  @endif  [[var:]]eventos[[:var]]  data-defval='{{$anexos[[[var:]]id[[:var]]][defVal]}}' />
 @endif 
{% else %}
  <input id="[[var:]]id[[:var]]" name="[[var:]]id[[:var]]" type="text" class="alfa {{$clasver}} [[var:]]validate[[:var]]" width="[[var:]]tam[[:var]]" value='<?php if ($item[[[var:]]id[[:var]]]=="[[var:]]dataon[[:var]]"){ $_valor= $anexos[[[var:]]id[[:var]]][labelon]; } else { $_valor=$anexos[[[var:]]id[[:var]]][labeloff];}  ?> {{$_valor}}'  disabled="disabled"  >
 @endif 
<span>{{$anexos[[[var:]]id[[:var]]][labelf]}}</span>
</label>
<div class="error_input">{$errors[[[var:]]id[[:var]]][0]}</div>
</div>
