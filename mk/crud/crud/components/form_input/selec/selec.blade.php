<?php $options=\Mk\Tools\Form::getOptions($anexos[[[var:]]id[[:var]]][options],$item[[[var:]]id[[:var]]],'Seleccione '.$anexos[[[var:]]id[[:var]]][labelf],$anexos[[[var:]]id[[:var]]][join][grupo]);  ?>
	<div class="input-field col [[var:]]clase[[:var]]">
	 @if( $_action!='ver' )  
	<select id="[[var:]]id[[:var]]" name="[[var:]]id[[:var]]" class="select {{$clasver}} [[var:]]validate[[:var]] [[var:]]classForm[[:var]]"  [[var:]]eventos[[:var]] data-defval='{{$anexos[[[var:]]id[[:var]]][defVal]}}' width="[[var:]]tam[[:var]]" >
  {{$options}}
</select>
  @endif 
 {% else %}
    <?php if (isset($anexos[[[var:]]id[[:var]]][options][$item[[[var:]]id[[:var]]]][text])){$valor=$anexos[[[var:]]id[[:var]]][options][$item[[[var:]]id[[:var]]]][text];}else{$valor=$anexos[[[var:]]id[[:var]]][options][$item[[[var:]]id[[:var]]]];}   ?>
    <?php if (trim($valor)==''){$valor=$item[join_[[var:]]id[[:var]]];}   ?>
 <input id="[[var:]]id[[:var]]" name="[[var:]]id[[:var]]" type="text" class="alfa {{$clasver}}" width="[[var:]]tam[[:var]]" value='{{$valor}}'  disabled="disabled"  >
  @endif 
	          <label for="[[var:]]id[[:var]]">{{$anexos[[[var:]]id[[:var]]][labelf]}}</label>
	          <div class="error_input">{$errors[[[var:]]id[[:var]]][0]}</div>
	</div>	
