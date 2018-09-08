@section('js.files')
	<link href='js/datedropper/datedropper.css' rel='stylesheet'>
	<script type='text/javascript' src='js/datedropper/datedropper.js'></script>
@append

@section('openform')
	$('.datefecha').dateDropper();
@append


<?php $valor=\Mk\Tools\Form::dbToDate($item[[[var:]]id[[:var]]]);  ?>
<div class="input-field col [[var:]]clase[[:var]]">
      <input id="[[var:]]id[[:var]]" name="[[var:]]id[[:var]]" type="text" class="alfa $clasver datefecha [[var:]]validate[[:var]] [[var:]]classForm[[:var]]" width="[[var:]]tam[[:var]]" value='{{$valor}}' [[var:]]eventos[[:var]] @if( $_action=='ver' )  disabled="disabled"  @endif  [[var:]]readonly[[:var]]  data-format="{{$_param->fecha->formato}}" data-init-set="false"  data-modal="true" data-large-default="true" data-large-mode="true"  data-default-date="{{date('m-d-Y')}}" data-defval='@if( ($anexos[[[var:]]id[[:var]]][defVal]=="hoy") )  {{\Mk\Tools\Form::dbToDate(date("Ymd"))}} {% /if  %}' >
      <label for="[[var:]]id[[:var]]">{{$anexos[[[var:]]id[[:var]]][labelf]}}</label>
      <div class="error_input">{$errors[[[var:]]id[[:var]]][0]}</div>
</div>
