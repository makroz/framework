@section('js.files')
	<link href='js/datedropper/datedropper.css' rel='stylesheet'>
	<script type='text/javascript' src='js/datedropper/datedropper.js'></script>
@append 
	@section('js.inline')
	function _search_campo_change(elem){
		var valor=$(elem).val();
		
		var tipo= $(elem).find('option[value="' + valor + '"]').attr("class");
		//alert(valor+':'+tipo); 
		var fila=$(elem).closest('.row');
		var cond=$(fila).find('.search_cond');
		$(cond).find('option').hide();
		$(cond).find('.'+tipo).show().first().prop("selected","selected").change();;
		//$(cond).find('.'+tipo).
		$(fila).find('._sc').hide();
		$(fila).find('.'+tipo).show();
		if (tipo=='_sc4'){
			$('input.datafecha').dateDropper();
		}
		actualizarUI();
	}

	function _search_addcampo(elem){
		var fila=$(elem).closest('.row');
		if ($(elem).hasClass('blue')){
			var copia=$(fila).clone();
			
			if ($(copia).find('.red').length==0){
				$(elem).clone().removeClass('blue').addClass('red').html('<i class="material-icons">delete</i>').appendTo($(copia).find('.blue').parent());
			}

			$(copia).find('.blue').html('<i class="material-icons">add</i>');
			$(elem).hide().parent().addClass('s1').removeClass('s2');
			$(fila).find('.search_join').show();
			$(fila).find('.isjoin').val(1);

			$(copia).find('input:text').val('');

			var i=$(fila).data('count')+1;
			$(copia).data('count',i);
			$(copia).find('input, select').each(function(){
				$(this).prop('id',$(this).prop('id')+i);
			});

			$(copia).find('label').each(function(){
				$(this).prop('for',$(this).prop('for')+i);
			});

			$(copia).appendTo($(fila).parent());
	
			_search_campo_change($(copia).find('select:first'));
			$('input.datafecha').dateDropper();
		
		}else{
			if ($(fila).next().length>0){
				$(fila).remove();
			}else{
				$(fila).prev().find('.blue').show().parent().addClass('s2').removeClass('s1');;
				$(fila).prev().find('.search_join').hide();
				$(fila).prev().find('.isjoin').val(0);
				$(fila).remove();

			}

		}

	}


	function _search_buscar(clear=false){
		//alert($('form#_searchform').serialize());
		if (clear==true){
			reaction('&no_search=1&_runScriptLoad=initListTable();','','','.listTable');
		}else{
			reaction($('form#_searchform').serialize()+'&_runScriptLoad=initListTable();','','','.listTable');
		}
		
	}
	@append 


	@section('js.onready')
	 $('input.datafecha').dateDropper();
	 _search_campo_change($('#search_campo'));
	@append 


	@section('style.inline')
	.input-field.col label.labeltop{
	left: .75rem;
	position: absolute;
	top: -14px;
	font-size: .8rem;
	color: #9e9e9e;	
	cursor: text;
	transition: .2s ease-out;
	}

	select.browser-default{
		cursor: pointer;
	background-color: transparent;
	border: none;
	border-bottom: 1px solid #9e9e9e;
	outline: none;
	height: 3rem;
	line-height: 3rem;
	width: 100%;
	font-size: 1rem;
	margin: 0 0 20px 0;
	padding: 0;
	display: block;
	}
	@append 


	<div id="mk_buscar" class="modal modal-fixed-footer">
	<h4 class="modal-tit">Busqueda</h4>
	<form id="_searchform" autocomplete="off">
	    <div class="modal-content">
	      

		  

	      <div class="row search1" data-count='0'>


	            <div class="input-field col s3" >
	    <select id="search_campo" name='search_campo[]' class="_search browser-default" onchange="_search_campo_change(this)" autocomplete='false' >

	      [[php:]]opciones[[:php]]

	    </select>
	          <label for="search_campo" class="labeltop">Campo de busqueda</label>
				</div>

	    <div class="input-field col s3" >
	    <select id="search_cond" name='search_cond[]' class="_search browser-default search_cond"   >

	      <option value="1" class="_sc1">contiene</option>
	 	  <option value="2" class="_sc1">no contiene</option>
	      <option value="3" class="_sc1 _sc2 _sc3 _sc4">igual a</option>
	      <option value="4" class="_sc1 _sc2 _sc3 _sc4">diferente de</option>
	      <option value="5" class="_sc2 _sc4">mayor que</option>
	      <option value="6" class="_sc2 _sc4">menor que</option>
	      <option value="7" class="_sc2 _sc4">mayor o igual que</option>
	      <option value="8" class="_sc2 _sc4">menor o igual que</option>
	      <option value="9" class="_sc1">empieza por</option>
	      <option value="10" class="_sc1">no empieza por</option>
	      <option value="11" class="_sc1">termina por</option>
	      <option value="12" class="_sc1">no termina por</option>
		



	    </select>
	          <label for="search_cond"  class="labeltop">Condicion de busqueda</label>
				</div>

				<div class="input-field col s4 _sc  _sc4 oculto" >

	          <input id="search_search_date" name='search_search_date[]' type="text" class="_search datafecha" data-format="d/m/Y"  data-large-mode="true" value=''  >
	          <label for="search_search_date">Criterio de busqueda Fecha</label>

				</div>

	            <div class="input-field col s4 _sc _sc1 _sc2" >

	          <input id="search_search_text" name='search_search_text[]' type="text" class="_search"  value=''>
	          <label for="search_search_text">Criterio de busqueda</label>

				</div>


	            <div class="input-field col s1 oculto search_join" >

	          <select id="search_join" name='search_join[]' class="_search browser-default" >
	      <option value="1">y</option>
	      <option value="2">o</option>

	    </select>
	          <label for="search_join" class="labeltop">union</label>
	          <input type="hidden" name="search_isjoin[]" class="isjoin" value="0">

				</div>

				  <div class="input-field col s2" >
				  <a class="btn-floating  waves-effect waves-light blue search_icon_add" title="Mas criterios" onclick="_search_addcampo(this);"><i class="material-icons">add</i></a>
				</div>

	      </div>

	       

	    


	      
	    </div>
	    <div class="modal-footer">
	      <a href="#!" class="modal-action modal-close waves-effect waves-red btn-flat ">Cancel</a><a href="#!" class="modal-action  modal-close waves-effect waves-green btn-flat " onclick="_search_buscar(this.form);">Buscar</a>
	    </div>
	    </form>
	</div>


	