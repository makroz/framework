<?php
	$nresp=$item['join_[[var:]]id[[:var]]'];
	$idresp= $item[[[var:]]id[[:var]]];
	if ($anexos[[[var:]]id[[:var]]]['funcion']=='useract'){
		if (($_action=='add')||($_action=='index')){
			$nresp=$_loged['user']['nombre'];
			$idresp=$_loged['id'];
		}
	}
?>

<div class="input-field col [[var:]]clase[[:var]]">
	 <input  id="[[var:]]id[[:var]]" name="[[var:]]id[[:var]]" type="hidden"  value='{{$idresp}}'   data-defval='{{$idresp}}' >
      <input id="join_[[var:]]id[[:var]]" name="join_[[var:]]id[[:var]]" type="text" class="alfa $clasver  [[var:]]classForm[[:var]]" width="[[var:]]tam[[:var]]" value='{{$nresp}}' disabled="disabled" data-defVal='{{$nresp}}'>
      <label for="join_[[var:]]id[[:var]]">{{$anexos[[[var:]]id[[:var]]][labelf]}}</label>
      <div class="error_input">{$errors[[[var:]]id[[:var]]][0]}</div>
</div>
