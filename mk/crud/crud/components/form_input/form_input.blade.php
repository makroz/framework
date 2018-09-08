[[compile:]]
[* echo  str_replace('form-config-section componente','',$$campos[[[var:]]id[[:var]]][i_pre]);  *]

[* if '[[var:]]unico[[:var]]'=='1' *]

[% append js.inline %]
var old_[[var:]]id[[:var]]='{{$item[[[var:]]id[[:var]]]}}';
function isUnique_[[var:]]id[[:var]](){
	var dato=$('#[[var:]]id[[:var]]').val();
	if (dato==''){
		$('.btnPrevAjax').show();
		return true;
	}
	if (dato!=old_[[var:]]id[[:var]]){
		$('.btnPrevAjax').hide();
		dataUnique($('#[[var:]]primary[[:var]]').val(),'[[var:]]id[[:var]]',dato,function(msg){
			if (msg!='0'){
				alertfocus('Ese {{$anexos[[[var:]]id[[:var]]][labelf]}} ya existe!!!','#[[var:]]id[[:var]]')
			}else{
				old_[[var:]]id[[:var]]=dato;
				$('.btnPrevAjax').show();
			}
		});
	}
}
[% /append %]


[* /if *]

[[unique:]]<?php if ($_action=='ver'){  $clasver='ver';}else{  $clasver='';}  ?>[[:unique]]

[* php if (('[[var:]]tipo[[:var]]'=='selec')||('[[var:]]tipo[[:var]]'=='selecdb')||('[[var:]]tipo[[:var]]'=='selecdbgrupo')) { $$tipoinput='selec';}else{ $$tipoinput='[[var:]]tipo[[:var]]';} *]


[* echo '@componente(form_input,'.'.$$tipoinput.'::id=[[var:]]id[[:var]]&tipo=[[var:]]tipo[[:var]]&tam=[[var:]]tam[[:var]]&clase=[[var:]]clase[[:var]]&unico=[[var:]]unico[[:var]]&dataon=[[var:]]dataon[[:var]]&decimal=[[var:]]decimal[[:var]]&validate=[[var:]]validate[[:var]]&primary=[[var:]]primary[[:var]]&readonly=[[var:]]readonly[[:var]]&eventos=[[var:]]eventos[[:var]]&classForm=[[var:]]classForm[[:var]]')'; *]

[* echo $$campos[[[var:]]id[[:var]]][i_pos] *]
[[:compile]]
