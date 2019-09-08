<script>console.log('PHP: 2018/03/29 21:16:07 Inicio initTime()');</script><hr> usof selec DB:almacenes|nombre|0|||<hr><hr> usof selec DB:prod|nom|0||fk_unidades|left join unidades on (fk_unidades=unidades.pk)<hr><hr> usof selec DB:unidades|nombre|0|(tipo='%s')|tipo|<hr><hr>C|Compra||*I|Inventario Inicial||*T|Traspaso||*D|Devolucion||*A|Ajuste||*<hr><hr>F|Factura||*R|Recibo||*X|Ninguno||*<hr><h1>Inicia proceso de Vista:</h1><h2>view_listar.html</h2><hr>nuevos componentes primera vez<hr><pre>Array
(
    [titulos] => Array
        (
            [0] => text={% echo $modTitulo; %}
        )

    [botonera] => Array
        (
            [0] => 
        )

    [listtable] => Array
        (
            [0] => 
        )

    [formulario] => Array
        (
            [0] => mostrar=1
        )

)
</pre><br>Procesado el Componente: titulos<br>---Renderizado Componente: titulos::text={% echo $modTitulo; %}<br>Procesado el Componente: botonera<br>---Renderizado Componente: botonera<br>Se copia el archivo para el componente:sort.png<br>Se copia el archivo para el componente:sort_asc.png<br>Se copia el archivo para el componente:sort_desc.png<br>Procesado el Componente: listtable<br>EL php encabezados es: <th data-field="pk" width="60px" class="sortable {% if ($order=='pk') %} sort_{% echo $direction; %} {% /if %}" > {% echo $anexos[pk][label] %} </th><th data-field="fecha" width="120px" class="sortable {% if ($order=='fecha') %} sort_{% echo $direction; %} {% /if %}" > {% echo $anexos[fecha][label] %} </th><th data-field="join_fk_almacenes" width="217px" class="sortable {% if ($order=='join_fk_almacenes') %} sort_{% echo $direction; %} {% /if %}" > {% echo $anexos[fk_almacenes][label] %} </th><th data-field="join_fk_prod" width="" class="sortable {% if ($order=='join_fk_prod') %} sort_{% echo $direction; %} {% /if %}" > {% echo $anexos[fk_prod][label] %} </th><th data-field="cant" width="113px" class="sortable {% if ($order=='cant') %} sort_{% echo $direction; %} {% /if %}" > {% echo $anexos[cant][label] %} </th><th data-field="join_fk_unidades" width="163px" class="sortable {% if ($order=='join_fk_unidades') %} sort_{% echo $direction; %} {% /if %}" > {% echo $anexos[fk_unidades][label] %} </th><th data-field="tipo" width="228px" class="sortable {% if ($order=='tipo') %} sort_{% echo $direction; %} {% /if %}" > {% echo $anexos[tipo][label] %} </th><th data-field="tipodoc" width="108px" class="sortable {% if ($order=='tipodoc') %} sort_{% echo $direction; %} {% /if %}" > {% echo $anexos[tipodoc][label] %} </th><th data-field="nfac" width="201px" class="sortable {% if ($order=='nfac') %} sort_{% echo $direction; %} {% /if %}" > {% echo $anexos[nfac][label] %} </th><th data-field="join_fk_resp" width="124px" class="sortable {% if ($order=='join_fk_resp') %} sort_{% echo $direction; %} {% /if %}" > {% echo $anexos[fk_resp][label] %} </th><th data-field="status" width="45px" class="sortable {% if ($order=='status') %} sort_{% echo $direction; %} {% /if %}" > {% echo $anexos[status][label] %} </th><br>EL php filas es: [[component:]]listtable_col::tipo=default&key=pk[[:component]][[component:]]listtable_col::tipo=date&key=fecha[[:component]][[component:]]listtable_col::tipo=join&key=fk_almacenes[[:component]][[component:]]listtable_col::tipo=join&key=fk_prod[[:component]][[component:]]listtable_col::tipo=default&key=cant[[:component]][[component:]]listtable_col::tipo=join&key=fk_unidades[[:component]][[component:]]listtable_col::tipo=lista&key=tipo[[:component]][[component:]]listtable_col::tipo=lista&key=tipodoc[[:component]][[component:]]listtable_col::tipo=default&key=nfac[[:component]][[component:]]listtable_col::tipo=join&key=fk_resp[[:component]][[component:]]listtable_col::tipo=status&status=1&key=status[[:component]]<br>EL php filasvacias es: <td > </td><td > </td><td > </td><td > </td><td > </td><td > </td><td > </td><td > </td><td > </td><td > </td><td > </td><br>---Renderizado Componente: listtable<br>Se copia el archivo para el componente:sort.png<br>Se copia el archivo para el componente:sort_asc.png<br>Se copia el archivo para el componente:sort_desc.png<br>Procesado el Componente: formulario<br>EL php codejs es: function onChangeProd(){
  var dato=$('#fk_prod').val();
    sel=$('#fk_prod').data('tag');
    if (sel>0){
      reaction('campo=fk_unidades&arg1=tipo&sel='+sel,'getListFor','','#fk_unidades',actualizarUI);
    }
}<br>EL php inputs es: [[component:]]form_input::id=fecha&tipo=date&tam=&clase=s3&validate= required [[:component]] [[component:]]form_input::id=pk&tipo=oculto&tam=&clase=s12&validate=numerico&eventos= onkeypress=\' return soloNum(event,this);\' [[:component]] [[component:]]form_input::id=tipo&tipo=selec&tam=&clase=s3&validate=[[:component]] [[component:]]form_input::id=fk_almacenes&tipo=selecdb&tam=&clase=s6&validate=numerico required &eventos= onkeypress=\' return soloNum(event,this);\' [[:component]] [[component:]]form_input::id=fk_prod&tipo=buscardb&tam=&clase=s9&validate=numerico required &eventos= onkeypress=\' return soloNum(event,this);\'  onblur=\'onChangeProd(); _buscarNomDb(this);\' [[:component]] [[component:]]form_input::id=cant&tipo=float&tam=&clase=s2&decimal=2&validate=numerico required &eventos= onkeypress=\' return soloNum(event,this);\'  onblur=\' _refreshFloat(this);\' [[:component]] [[component:]]form_input::id=fk_unidades&tipo=selecdb&tam=&clase=s1&validate=numerico required &eventos= onkeypress=\' return soloNum(event,this);\' [[:component]] [[component:]]form_input::id=costo&tipo=float&tam=&clase=s4&decimal=2&validate=numerico required &eventos= onkeypress=\' return soloNum(event,this);\'  onblur=\' _refreshFloat(this);\' [[:component]] [[component:]]form_input::id=tipodoc&tipo=selec&tam=&clase=s4&validate=[[:component]] [[component:]]form_input::id=nfac&tipo=alfa&tam=&clase=s4&validate=[[:component]] [[component:]]form_input::id=serial&tipo=alfa&tam=&clase=s6&validate=[[:component]] [[component:]]form_input::id=fecven&tipo=date&tam=&clase=s6&validate=[[:component]] [[component:]]form_input::id=fk_resp&tipo=join&tam=&clase=s12&validate=numerico required &eventos= onkeypress=\' return soloNum(event,this);\' [[:component]] <br>---Renderizado Componente: formulario::mostrar=1<hr>nuevos componentes<hr><pre>Array
(
    [botonesedittable] => Array
        (
            [0] => 
            [1] => 
        )

    [button_print] => Array
        (
            [0] => areaforprint=.listTable
        )

    [button_buscar] => Array
        (
            [0] => 
        )

    [paginacion] => Array
        (
            [0] => 
        )

    [listtable_checkall] => Array
        (
            [0] => 
        )

    [listtable_checkrow] => Array
        (
            [0] => 
        )

    [listtable_col] => Array
        (
            [0] => tipo=default&key=pk
            [1] => tipo=date&key=fecha
            [2] => tipo=join&key=fk_almacenes
            [3] => tipo=join&key=fk_prod
            [4] => tipo=default&key=cant
            [5] => tipo=join&key=fk_unidades
            [6] => tipo=lista&key=tipo
            [7] => tipo=lista&key=tipodoc
            [8] => tipo=default&key=nfac
            [9] => tipo=join&key=fk_resp
            [10] => tipo=status&status=1&key=status
        )

    [form_input] => Array
        (
            [0] => id=fecha&tipo=date&tam=&clase=s3&validate= required 
            [1] => id=pk&tipo=oculto&tam=&clase=s12&validate=numerico&eventos= onkeypress=\' return soloNum(event,this);\' 
            [2] => id=tipo&tipo=selec&tam=&clase=s3&validate=
            [3] => id=fk_almacenes&tipo=selecdb&tam=&clase=s6&validate=numerico required &eventos= onkeypress=\' return soloNum(event,this);\' 
            [4] => id=fk_prod&tipo=buscardb&tam=&clase=s9&validate=numerico required &eventos= onkeypress=\' return soloNum(event,this);\'  onblur=\'onChangeProd(); _buscarNomDb(this);\' 
            [5] => id=cant&tipo=float&tam=&clase=s2&decimal=2&validate=numerico required &eventos= onkeypress=\' return soloNum(event,this);\'  onblur=\' _refreshFloat(this);\' 
            [6] => id=fk_unidades&tipo=selecdb&tam=&clase=s1&validate=numerico required &eventos= onkeypress=\' return soloNum(event,this);\' 
            [7] => id=costo&tipo=float&tam=&clase=s4&decimal=2&validate=numerico required &eventos= onkeypress=\' return soloNum(event,this);\'  onblur=\' _refreshFloat(this);\' 
            [8] => id=tipodoc&tipo=selec&tam=&clase=s4&validate=
            [9] => id=nfac&tipo=alfa&tam=&clase=s4&validate=
            [10] => id=serial&tipo=alfa&tam=&clase=s6&validate=
            [11] => id=fecven&tipo=date&tam=&clase=s6&validate=
            [12] => id=fk_resp&tipo=join&tam=&clase=s12&validate=numerico required &eventos= onkeypress=\' return soloNum(event,this);\' 
        )

)
</pre><br>Procesado el Componente: botonesedittable<strong style="color:red"><hr>Copilacion de: <hr>

	$variables[codejsopenform]
<hr><hr></strong><strong style="color:blue"><hr>Copilacion de: <hr>

	onChangeProd();
<hr><hr></strong><br><span style='color:red;'><code>

	onChangeProd();
</code> Compilado </span><br>---Renderizado Componente: botonesedittable<br>Procesado el Componente: button_print<br>---Renderizado Componente: button_print::areaforprint=.listTable<br>Procesado el Componente: button_buscar<br>---Renderizado Componente: button_buscar<br>code unique
{% php $maxpage=ceil($count / $limit); $minpage=$page-3; if ($minpage<=0){ $minpage=1; } $lastpage=$minpage+4;if($lastpage>$maxpage){ $lastpage=$maxpage;}  %} POsicion: 8357<br>Procesado el Componente: paginacion<br>---Renderizado Componente: paginacion<br>Procesado el Componente: listtable_checkall<br>---Renderizado Componente: listtable_checkall<br>Procesado el Componente: listtable_checkrow<br>---Renderizado Componente: listtable_checkrow<br>Procesado el Componente: listtable_col<strong style="color:red"><hr>Copilacion de: <hr>



{% if 'default'=='status' %}

[% append js.inline %]

function cambiarStatus(item){
var pk=[[]](item).data('pk');
var status=[[]](item).data('status');

var options=[];

	options['pk']=pk;
	options['campos[status]']=status;
var link=reaction(options,'setData','',true);

getAjax(link,'GET',{ },item, function(msg){
     if (msg>=0){
     	var newstatus='0';
     	var icon='E';
     	if (status=='0'){
     		newstatus='[[var:]]status[[:var]]'
     		icon='X';
     	}
     	
     	[[]](item).data('status',newstatus).attr('src','img/'+icon+'.png');

     }
   });

}

[% /append %]

<td >

     [% if ([[]]row[pk]=="[[var:]]status[[:var]]") %]
          <img src="img/E.png" title="Click para cambiar" data-status='0' data-pk='[[]]row[pk]' id='img_status_[[]]row[pk]' onclick="cambiarStatus(this);" >
     [% /if %]
     [% else %]
          <img src="img/X.png" title="Click para cambiar" data-status='[[var:]]status[[:var]]' data-pk='[[]]row[pk]' id='img_status_[[]]row[pk]' onclick="cambiarStatus(this);" >
     [% /else %]
</td>

{% /if %}

{% if 'default'=='check' %}
<td > 
     [% if ([[]]anexos[pk]['dataon']==[[]]row[pk]) %] 
          [% echo [[]]anexos[pk]['labelon']; %]
     [% /if %]
     [% else %]
          [% echo [[]]anexos[pk]['labeloff']; %]
     [% /else %]
</td>

{% /if %}

{% if 'default'=='lista' %}

<td > 
     [% echo [[]]anexos[pk]['options'][[[]]row[pk]]; %]
</td>

{% /if %}

{% if 'default'=='join' %}

<td > 
     [% echo [[]]row[join_pk];  %]
</td>

{% /if %}

{% if 'default'=='date' %}

<td > 

     [% echo \\Mk\\Tools\\Form::dbToDate([[]]row[pk]); %]
</td>

{% /if %}


{% if 'default'=='default' %}

<td > 
     [% echo [[]]row[pk]; %]
</td>

{% /if %}

<hr><hr></strong><strong style="color:blue"><hr>Copilacion de: <hr>
















<td > 
     [% echo [[]]row[pk]; %]
</td>



<hr><hr></strong><br><span style='color:red;'><code>
















<td > 
     {% echo $row[pk]; %}
</td>



</code> Compilado </span><br>---Renderizado Componente: listtable_col::tipo=default&key=pk<strong style="color:red"><hr>Copilacion de: <hr>



{% if 'date'=='status' %}

[% append js.inline %]

function cambiarStatus(item){
var pk=[[]](item).data('pk');
var status=[[]](item).data('status');

var options=[];
	options['pk']=pk;
	options['campos[status]']=status;
var link=reaction(options,'setData','',true);

getAjax(link,'GET',{ },item, function(msg){
     if (msg>=0){
     	var newstatus='0';
     	var icon='E';
     	if (status=='0'){
     		newstatus='[[var:]]status[[:var]]'
     		icon='X';
     	}
     	
     	[[]](item).data('status',newstatus).attr('src','img/'+icon+'.png');

     }
   });

}

[% /append %]

<td >

     [% if ([[]]row[fecha]=="[[var:]]status[[:var]]") %]
          <img src="img/E.png" title="Click para cambiar" data-status='0' data-pk='[[]]row[pk]' id='img_status_[[]]row[pk]' onclick="cambiarStatus(this);" >
     [% /if %]
     [% else %]
          <img src="img/X.png" title="Click para cambiar" data-status='[[var:]]status[[:var]]' data-pk='[[]]row[pk]' id='img_status_[[]]row[pk]' onclick="cambiarStatus(this);" >
     [% /else %]
</td>

{% /if %}

{% if 'date'=='check' %}
<td > 
     [% if ([[]]anexos[fecha]['dataon']==[[]]row[fecha]) %] 
          [% echo [[]]anexos[fecha]['labelon']; %]
     [% /if %]
     [% else %]
          [% echo [[]]anexos[fecha]['labeloff']; %]
     [% /else %]
</td>

{% /if %}

{% if 'date'=='lista' %}

<td > 
     [% echo [[]]anexos[fecha]['options'][[[]]row[fecha]]; %]
</td>

{% /if %}

{% if 'date'=='join' %}

<td > 
     [% echo [[]]row[join_fecha];  %]
</td>

{% /if %}

{% if 'date'=='date' %}

<td > 

     [% echo \\Mk\\Tools\\Form::dbToDate([[]]row[fecha]); %]
</td>

{% /if %}


{% if 'date'=='default' %}

<td > 
     [% echo [[]]row[fecha]; %]
</td>

{% /if %}

<hr><hr></strong><strong style="color:blue"><hr>Copilacion de: <hr>













<td > 

     [% echo \\Mk\\Tools\\Form::dbToDate([[]]row[fecha]); %]
</td>






<hr><hr></strong><br><span style='color:red;'><code>













<td > 

     {% echo \\Mk\\Tools\\Form::dbToDate($row[fecha]); %}
</td>






</code> Compilado </span><br>---Renderizado Componente: listtable_col::tipo=date&key=fecha<strong style="color:red"><hr>Copilacion de: <hr>



{% if 'join'=='status' %}

[% append js.inline %]

function cambiarStatus(item){
var pk=[[]](item).data('pk');
var status=[[]](item).data('status');

var options=[];
	options['pk']=pk;
	options['campos[status]']=status;
var link=reaction(options,'setData','',true);

getAjax(link,'GET',{ },item, function(msg){
     if (msg>=0){
     	var newstatus='0';
     	var icon='E';
     	if (status=='0'){
     		newstatus='[[var:]]status[[:var]]'
     		icon='X';
     	}
     	
     	[[]](item).data('status',newstatus).attr('src','img/'+icon+'.png');

     }
   });

}

[% /append %]

<td >

     [% if ([[]]row[fk_almacenes]=="[[var:]]status[[:var]]") %]
          <img src="img/E.png" title="Click para cambiar" data-status='0' data-pk='[[]]row[pk]' id='img_status_[[]]row[pk]' onclick="cambiarStatus(this);" >
     [% /if %]
     [% else %]
          <img src="img/X.png" title="Click para cambiar" data-status='[[var:]]status[[:var]]' data-pk='[[]]row[pk]' id='img_status_[[]]row[pk]' onclick="cambiarStatus(this);" >
     [% /else %]
</td>

{% /if %}

{% if 'join'=='check' %}
<td > 
     [% if ([[]]anexos[fk_almacenes]['dataon']==[[]]row[fk_almacenes]) %] 
          [% echo [[]]anexos[fk_almacenes]['labelon']; %]
     [% /if %]
     [% else %]
          [% echo [[]]anexos[fk_almacenes]['labeloff']; %]
     [% /else %]
</td>

{% /if %}

{% if 'join'=='lista' %}

<td > 
     [% echo [[]]anexos[fk_almacenes]['options'][[[]]row[fk_almacenes]]; %]
</td>

{% /if %}

{% if 'join'=='join' %}

<td > 
     [% echo [[]]row[join_fk_almacenes];  %]
</td>

{% /if %}

{% if 'join'=='date' %}

<td > 

     [% echo \\Mk\\Tools\\Form::dbToDate([[]]row[fk_almacenes]); %]
</td>

{% /if %}


{% if 'join'=='default' %}

<td > 
     [% echo [[]]row[fk_almacenes]; %]
</td>

{% /if %}

<hr><hr></strong><strong style="color:blue"><hr>Copilacion de: <hr>











<td > 
     [% echo [[]]row[join_fk_almacenes];  %]
</td>








<hr><hr></strong><br><span style='color:red;'><code>











<td > 
     {% echo $row[join_fk_almacenes];  %}
</td>








</code> Compilado </span><br>---Renderizado Componente: listtable_col::tipo=join&key=fk_almacenes<strong style="color:red"><hr>Copilacion de: <hr>



{% if 'join'=='status' %}

[% append js.inline %]

function cambiarStatus(item){
var pk=[[]](item).data('pk');
var status=[[]](item).data('status');

var options=[];
	options['pk']=pk;
	options['campos[status]']=status;
var link=reaction(options,'setData','',true);

getAjax(link,'GET',{ },item, function(msg){
     if (msg>=0){
     	var newstatus='0';
     	var icon='E';
     	if (status=='0'){
     		newstatus='[[var:]]status[[:var]]'
     		icon='X';
     	}
     	
     	[[]](item).data('status',newstatus).attr('src','img/'+icon+'.png');

     }
   });

}

[% /append %]

<td >

     [% if ([[]]row[fk_prod]=="[[var:]]status[[:var]]") %]
          <img src="img/E.png" title="Click para cambiar" data-status='0' data-pk='[[]]row[pk]' id='img_status_[[]]row[pk]' onclick="cambiarStatus(this);" >
     [% /if %]
     [% else %]
          <img src="img/X.png" title="Click para cambiar" data-status='[[var:]]status[[:var]]' data-pk='[[]]row[pk]' id='img_status_[[]]row[pk]' onclick="cambiarStatus(this);" >
     [% /else %]
</td>

{% /if %}

{% if 'join'=='check' %}
<td > 
     [% if ([[]]anexos[fk_prod]['dataon']==[[]]row[fk_prod]) %] 
          [% echo [[]]anexos[fk_prod]['labelon']; %]
     [% /if %]
     [% else %]
          [% echo [[]]anexos[fk_prod]['labeloff']; %]
     [% /else %]
</td>

{% /if %}

{% if 'join'=='lista' %}

<td > 
     [% echo [[]]anexos[fk_prod]['options'][[[]]row[fk_prod]]; %]
</td>

{% /if %}

{% if 'join'=='join' %}

<td > 
     [% echo [[]]row[join_fk_prod];  %]
</td>

{% /if %}

{% if 'join'=='date' %}

<td > 

     [% echo \\Mk\\Tools\\Form::dbToDate([[]]row[fk_prod]); %]
</td>

{% /if %}


{% if 'join'=='default' %}

<td > 
     [% echo [[]]row[fk_prod]; %]
</td>

{% /if %}

<hr><hr></strong><strong style="color:blue"><hr>Copilacion de: <hr>











<td > 
     [% echo [[]]row[join_fk_prod];  %]
</td>








<hr><hr></strong><br><span style='color:red;'><code>











<td > 
     {% echo $row[join_fk_prod];  %}
</td>








</code> Compilado </span><br>---Renderizado Componente: listtable_col::tipo=join&key=fk_prod<strong style="color:red"><hr>Copilacion de: <hr>



{% if 'default'=='status' %}

[% append js.inline %]

function cambiarStatus(item){
var pk=[[]](item).data('pk');
var status=[[]](item).data('status');

var options=[];
	options['pk']=pk;
	options['campos[status]']=status;
var link=reaction(options,'setData','',true);

getAjax(link,'GET',{ },item, function(msg){
     if (msg>=0){
     	var newstatus='0';
     	var icon='E';
     	if (status=='0'){
     		newstatus='[[var:]]status[[:var]]'
     		icon='X';
     	}
     	
     	[[]](item).data('status',newstatus).attr('src','img/'+icon+'.png');

     }
   });

}

[% /append %]

<td >

     [% if ([[]]row[cant]=="[[var:]]status[[:var]]") %]
          <img src="img/E.png" title="Click para cambiar" data-status='0' data-pk='[[]]row[pk]' id='img_status_[[]]row[pk]' onclick="cambiarStatus(this);" >
     [% /if %]
     [% else %]
          <img src="img/X.png" title="Click para cambiar" data-status='[[var:]]status[[:var]]' data-pk='[[]]row[pk]' id='img_status_[[]]row[pk]' onclick="cambiarStatus(this);" >
     [% /else %]
</td>

{% /if %}

{% if 'default'=='check' %}
<td > 
     [% if ([[]]anexos[cant]['dataon']==[[]]row[cant]) %] 
          [% echo [[]]anexos[cant]['labelon']; %]
     [% /if %]
     [% else %]
          [% echo [[]]anexos[cant]['labeloff']; %]
     [% /else %]
</td>

{% /if %}

{% if 'default'=='lista' %}

<td > 
     [% echo [[]]anexos[cant]['options'][[[]]row[cant]]; %]
</td>

{% /if %}

{% if 'default'=='join' %}

<td > 
     [% echo [[]]row[join_cant];  %]
</td>

{% /if %}

{% if 'default'=='date' %}

<td > 

     [% echo \\Mk\\Tools\\Form::dbToDate([[]]row[cant]); %]
</td>

{% /if %}


{% if 'default'=='default' %}

<td > 
     [% echo [[]]row[cant]; %]
</td>

{% /if %}

<hr><hr></strong><strong style="color:blue"><hr>Copilacion de: <hr>
















<td > 
     [% echo [[]]row[cant]; %]
</td>



<hr><hr></strong><br><span style='color:red;'><code>
















<td > 
     {% echo $row[cant]; %}
</td>



</code> Compilado </span><br>---Renderizado Componente: listtable_col::tipo=default&key=cant<strong style="color:red"><hr>Copilacion de: <hr>



{% if 'join'=='status' %}

[% append js.inline %]

function cambiarStatus(item){
var pk=[[]](item).data('pk');
var status=[[]](item).data('status');

var options=[];
	options['pk']=pk;
	options['campos[status]']=status;
var link=reaction(options,'setData','',true);

getAjax(link,'GET',{ },item, function(msg){
     if (msg>=0){
     	var newstatus='0';
     	var icon='E';
     	if (status=='0'){
     		newstatus='[[var:]]status[[:var]]'
     		icon='X';
     	}
     	
     	[[]](item).data('status',newstatus).attr('src','img/'+icon+'.png');

     }
   });

}

[% /append %]

<td >

     [% if ([[]]row[fk_unidades]=="[[var:]]status[[:var]]") %]
          <img src="img/E.png" title="Click para cambiar" data-status='0' data-pk='[[]]row[pk]' id='img_status_[[]]row[pk]' onclick="cambiarStatus(this);" >
     [% /if %]
     [% else %]
          <img src="img/X.png" title="Click para cambiar" data-status='[[var:]]status[[:var]]' data-pk='[[]]row[pk]' id='img_status_[[]]row[pk]' onclick="cambiarStatus(this);" >
     [% /else %]
</td>

{% /if %}

{% if 'join'=='check' %}
<td > 
     [% if ([[]]anexos[fk_unidades]['dataon']==[[]]row[fk_unidades]) %] 
          [% echo [[]]anexos[fk_unidades]['labelon']; %]
     [% /if %]
     [% else %]
          [% echo [[]]anexos[fk_unidades]['labeloff']; %]
     [% /else %]
</td>

{% /if %}

{% if 'join'=='lista' %}

<td > 
     [% echo [[]]anexos[fk_unidades]['options'][[[]]row[fk_unidades]]; %]
</td>

{% /if %}

{% if 'join'=='join' %}

<td > 
     [% echo [[]]row[join_fk_unidades];  %]
</td>

{% /if %}

{% if 'join'=='date' %}

<td > 

     [% echo \\Mk\\Tools\\Form::dbToDate([[]]row[fk_unidades]); %]
</td>

{% /if %}


{% if 'join'=='default' %}

<td > 
     [% echo [[]]row[fk_unidades]; %]
</td>

{% /if %}

<hr><hr></strong><strong style="color:blue"><hr>Copilacion de: <hr>











<td > 
     [% echo [[]]row[join_fk_unidades];  %]
</td>








<hr><hr></strong><br><span style='color:red;'><code>











<td > 
     {% echo $row[join_fk_unidades];  %}
</td>








</code> Compilado </span><br>---Renderizado Componente: listtable_col::tipo=join&key=fk_unidades<strong style="color:red"><hr>Copilacion de: <hr>



{% if 'lista'=='status' %}

[% append js.inline %]

function cambiarStatus(item){
var pk=[[]](item).data('pk');
var status=[[]](item).data('status');

var options=[];
	options['pk']=pk;
	options['campos[status]']=status;
var link=reaction(options,'setData','',true);

getAjax(link,'GET',{ },item, function(msg){
     if (msg>=0){
     	var newstatus='0';
     	var icon='E';
     	if (status=='0'){
     		newstatus='[[var:]]status[[:var]]'
     		icon='X';
     	}
     	
     	[[]](item).data('status',newstatus).attr('src','img/'+icon+'.png');

     }
   });

}

[% /append %]

<td >

     [% if ([[]]row[tipo]=="[[var:]]status[[:var]]") %]
          <img src="img/E.png" title="Click para cambiar" data-status='0' data-pk='[[]]row[pk]' id='img_status_[[]]row[pk]' onclick="cambiarStatus(this);" >
     [% /if %]
     [% else %]
          <img src="img/X.png" title="Click para cambiar" data-status='[[var:]]status[[:var]]' data-pk='[[]]row[pk]' id='img_status_[[]]row[pk]' onclick="cambiarStatus(this);" >
     [% /else %]
</td>

{% /if %}

{% if 'lista'=='check' %}
<td > 
     [% if ([[]]anexos[tipo]['dataon']==[[]]row[tipo]) %] 
          [% echo [[]]anexos[tipo]['labelon']; %]
     [% /if %]
     [% else %]
          [% echo [[]]anexos[tipo]['labeloff']; %]
     [% /else %]
</td>

{% /if %}

{% if 'lista'=='lista' %}

<td > 
     [% echo [[]]anexos[tipo]['options'][[[]]row[tipo]]; %]
</td>

{% /if %}

{% if 'lista'=='join' %}

<td > 
     [% echo [[]]row[join_tipo];  %]
</td>

{% /if %}

{% if 'lista'=='date' %}

<td > 

     [% echo \\Mk\\Tools\\Form::dbToDate([[]]row[tipo]); %]
</td>

{% /if %}


{% if 'lista'=='default' %}

<td > 
     [% echo [[]]row[tipo]; %]
</td>

{% /if %}

<hr><hr></strong><strong style="color:blue"><hr>Copilacion de: <hr>









<td > 
     [% echo [[]]anexos[tipo][\'options\'][[[]]row[tipo]]; %]
</td>










<hr><hr></strong><br><span style='color:red;'><code>









<td > 
     {% echo $anexos[tipo][\'options\'][$row[tipo]]; %}
</td>










</code> Compilado </span><br>---Renderizado Componente: listtable_col::tipo=lista&key=tipo<strong style="color:red"><hr>Copilacion de: <hr>



{% if 'lista'=='status' %}

[% append js.inline %]

function cambiarStatus(item){
var pk=[[]](item).data('pk');
var status=[[]](item).data('status');

var options=[];
	options['pk']=pk;
	options['campos[status]']=status;
var link=reaction(options,'setData','',true);

getAjax(link,'GET',{ },item, function(msg){
     if (msg>=0){
     	var newstatus='0';
     	var icon='E';
     	if (status=='0'){
     		newstatus='[[var:]]status[[:var]]'
     		icon='X';
     	}
     	
     	[[]](item).data('status',newstatus).attr('src','img/'+icon+'.png');

     }
   });

}

[% /append %]

<td >

     [% if ([[]]row[tipodoc]=="[[var:]]status[[:var]]") %]
          <img src="img/E.png" title="Click para cambiar" data-status='0' data-pk='[[]]row[pk]' id='img_status_[[]]row[pk]' onclick="cambiarStatus(this);" >
     [% /if %]
     [% else %]
          <img src="img/X.png" title="Click para cambiar" data-status='[[var:]]status[[:var]]' data-pk='[[]]row[pk]' id='img_status_[[]]row[pk]' onclick="cambiarStatus(this);" >
     [% /else %]
</td>

{% /if %}

{% if 'lista'=='check' %}
<td > 
     [% if ([[]]anexos[tipodoc]['dataon']==[[]]row[tipodoc]) %] 
          [% echo [[]]anexos[tipodoc]['labelon']; %]
     [% /if %]
     [% else %]
          [% echo [[]]anexos[tipodoc]['labeloff']; %]
     [% /else %]
</td>

{% /if %}

{% if 'lista'=='lista' %}

<td > 
     [% echo [[]]anexos[tipodoc]['options'][[[]]row[tipodoc]]; %]
</td>

{% /if %}

{% if 'lista'=='join' %}

<td > 
     [% echo [[]]row[join_tipodoc];  %]
</td>

{% /if %}

{% if 'lista'=='date' %}

<td > 

     [% echo \\Mk\\Tools\\Form::dbToDate([[]]row[tipodoc]); %]
</td>

{% /if %}


{% if 'lista'=='default' %}

<td > 
     [% echo [[]]row[tipodoc]; %]
</td>

{% /if %}

<hr><hr></strong><strong style="color:blue"><hr>Copilacion de: <hr>









<td > 
     [% echo [[]]anexos[tipodoc][\'options\'][[[]]row[tipodoc]]; %]
</td>










<hr><hr></strong><br><span style='color:red;'><code>









<td > 
     {% echo $anexos[tipodoc][\'options\'][$row[tipodoc]]; %}
</td>










</code> Compilado </span><br>---Renderizado Componente: listtable_col::tipo=lista&key=tipodoc<strong style="color:red"><hr>Copilacion de: <hr>



{% if 'default'=='status' %}

[% append js.inline %]

function cambiarStatus(item){
var pk=[[]](item).data('pk');
var status=[[]](item).data('status');

var options=[];
	options['pk']=pk;
	options['campos[status]']=status;
var link=reaction(options,'setData','',true);

getAjax(link,'GET',{ },item, function(msg){
     if (msg>=0){
     	var newstatus='0';
     	var icon='E';
     	if (status=='0'){
     		newstatus='[[var:]]status[[:var]]'
     		icon='X';
     	}
     	
     	[[]](item).data('status',newstatus).attr('src','img/'+icon+'.png');

     }
   });

}

[% /append %]

<td >

     [% if ([[]]row[nfac]=="[[var:]]status[[:var]]") %]
          <img src="img/E.png" title="Click para cambiar" data-status='0' data-pk='[[]]row[pk]' id='img_status_[[]]row[pk]' onclick="cambiarStatus(this);" >
     [% /if %]
     [% else %]
          <img src="img/X.png" title="Click para cambiar" data-status='[[var:]]status[[:var]]' data-pk='[[]]row[pk]' id='img_status_[[]]row[pk]' onclick="cambiarStatus(this);" >
     [% /else %]
</td>

{% /if %}

{% if 'default'=='check' %}
<td > 
     [% if ([[]]anexos[nfac]['dataon']==[[]]row[nfac]) %] 
          [% echo [[]]anexos[nfac]['labelon']; %]
     [% /if %]
     [% else %]
          [% echo [[]]anexos[nfac]['labeloff']; %]
     [% /else %]
</td>

{% /if %}

{% if 'default'=='lista' %}

<td > 
     [% echo [[]]anexos[nfac]['options'][[[]]row[nfac]]; %]
</td>

{% /if %}

{% if 'default'=='join' %}

<td > 
     [% echo [[]]row[join_nfac];  %]
</td>

{% /if %}

{% if 'default'=='date' %}

<td > 

     [% echo \\Mk\\Tools\\Form::dbToDate([[]]row[nfac]); %]
</td>

{% /if %}


{% if 'default'=='default' %}

<td > 
     [% echo [[]]row[nfac]; %]
</td>

{% /if %}

<hr><hr></strong><strong style="color:blue"><hr>Copilacion de: <hr>
















<td > 
     [% echo [[]]row[nfac]; %]
</td>



<hr><hr></strong><br><span style='color:red;'><code>
















<td > 
     {% echo $row[nfac]; %}
</td>



</code> Compilado </span><br>---Renderizado Componente: listtable_col::tipo=default&key=nfac<strong style="color:red"><hr>Copilacion de: <hr>



{% if 'join'=='status' %}

[% append js.inline %]

function cambiarStatus(item){
var pk=[[]](item).data('pk');
var status=[[]](item).data('status');

var options=[];
	options['pk']=pk;
	options['campos[status]']=status;
var link=reaction(options,'setData','',true);

getAjax(link,'GET',{ },item, function(msg){
     if (msg>=0){
     	var newstatus='0';
     	var icon='E';
     	if (status=='0'){
     		newstatus='[[var:]]status[[:var]]'
     		icon='X';
     	}
     	
     	[[]](item).data('status',newstatus).attr('src','img/'+icon+'.png');

     }
   });

}

[% /append %]

<td >

     [% if ([[]]row[fk_resp]=="[[var:]]status[[:var]]") %]
          <img src="img/E.png" title="Click para cambiar" data-status='0' data-pk='[[]]row[pk]' id='img_status_[[]]row[pk]' onclick="cambiarStatus(this);" >
     [% /if %]
     [% else %]
          <img src="img/X.png" title="Click para cambiar" data-status='[[var:]]status[[:var]]' data-pk='[[]]row[pk]' id='img_status_[[]]row[pk]' onclick="cambiarStatus(this);" >
     [% /else %]
</td>

{% /if %}

{% if 'join'=='check' %}
<td > 
     [% if ([[]]anexos[fk_resp]['dataon']==[[]]row[fk_resp]) %] 
          [% echo [[]]anexos[fk_resp]['labelon']; %]
     [% /if %]
     [% else %]
          [% echo [[]]anexos[fk_resp]['labeloff']; %]
     [% /else %]
</td>

{% /if %}

{% if 'join'=='lista' %}

<td > 
     [% echo [[]]anexos[fk_resp]['options'][[[]]row[fk_resp]]; %]
</td>

{% /if %}

{% if 'join'=='join' %}

<td > 
     [% echo [[]]row[join_fk_resp];  %]
</td>

{% /if %}

{% if 'join'=='date' %}

<td > 

     [% echo \\Mk\\Tools\\Form::dbToDate([[]]row[fk_resp]); %]
</td>

{% /if %}


{% if 'join'=='default' %}

<td > 
     [% echo [[]]row[fk_resp]; %]
</td>

{% /if %}

<hr><hr></strong><strong style="color:blue"><hr>Copilacion de: <hr>











<td > 
     [% echo [[]]row[join_fk_resp];  %]
</td>








<hr><hr></strong><br><span style='color:red;'><code>











<td > 
     {% echo $row[join_fk_resp];  %}
</td>








</code> Compilado </span><br>---Renderizado Componente: listtable_col::tipo=join&key=fk_resp<strong style="color:red"><hr>Copilacion de: <hr>



{% if 'status'=='status' %}

[% append js.inline %]

function cambiarStatus(item){
var pk=[[]](item).data('pk');
var status=[[]](item).data('status');

var options=[];
	options['pk']=pk;
	options['campos[status]']=status;
var link=reaction(options,'setData','',true);

getAjax(link,'GET',{ },item, function(msg){
     if (msg>=0){
     	var newstatus='0';
     	var icon='E';
     	if (status=='0'){
     		newstatus='1'
     		icon='X';
     	}
     	
     	[[]](item).data('status',newstatus).attr('src','img/'+icon+'.png');

     }
   });

}

[% /append %]

<td >

     [% if ([[]]row[status]=="1") %]
          <img src="img/E.png" title="Click para cambiar" data-status='0' data-pk='[[]]row[pk]' id='img_status_[[]]row[pk]' onclick="cambiarStatus(this);" >
     [% /if %]
     [% else %]
          <img src="img/X.png" title="Click para cambiar" data-status='1' data-pk='[[]]row[pk]' id='img_status_[[]]row[pk]' onclick="cambiarStatus(this);" >
     [% /else %]
</td>

{% /if %}

{% if 'status'=='check' %}
<td > 
     [% if ([[]]anexos[status]['dataon']==[[]]row[status]) %] 
          [% echo [[]]anexos[status]['labelon']; %]
     [% /if %]
     [% else %]
          [% echo [[]]anexos[status]['labeloff']; %]
     [% /else %]
</td>

{% /if %}

{% if 'status'=='lista' %}

<td > 
     [% echo [[]]anexos[status]['options'][[[]]row[status]]; %]
</td>

{% /if %}

{% if 'status'=='join' %}

<td > 
     [% echo [[]]row[join_status];  %]
</td>

{% /if %}

{% if 'status'=='date' %}

<td > 

     [% echo \\Mk\\Tools\\Form::dbToDate([[]]row[status]); %]
</td>

{% /if %}


{% if 'status'=='default' %}

<td > 
     [% echo [[]]row[status]; %]
</td>

{% /if %}

<hr><hr></strong><strong style="color:blue"><hr>Copilacion de: <hr>





[% append js.inline %]

function cambiarStatus(item){
var pk=[[]](item).data(\'pk\');
var status=[[]](item).data(\'status\');

var options=[];
	options[\'pk\']=pk;
	options[\'campos[status]\']=status;
var link=reaction(options,\'setData\',\'\',true);

getAjax(link,\'GET\',{ },item, function(msg){
     if (msg>=0){
     	var newstatus=\'0\';
     	var icon=\'E\';
     	if (status==\'0\'){
     		newstatus=\'1\'
     		icon=\'X\';
     	}
     	
     	[[]](item).data(\'status\',newstatus).attr(\'src\',\'img/\'+icon+\'.png\');

     }
   });

}

[% /append %]

<td >

     [% if ([[]]row[status]=="1") %]
          <img src="img/E.png" title="Click para cambiar" data-status=\'0\' data-pk=\'[[]]row[pk]\' id=\'img_status_[[]]row[pk]\' onclick="cambiarStatus(this);" >
     [% /if %]
     [% else %]
          <img src="img/X.png" title="Click para cambiar" data-status=\'1\' data-pk=\'[[]]row[pk]\' id=\'img_status_[[]]row[pk]\' onclick="cambiarStatus(this);" >
     [% /else %]
</td>














<hr><hr></strong><br><span style='color:red;'><code>





{% append js.inline %}

function cambiarStatus(item){
var pk=$(item).data(\'pk\');
var status=$(item).data(\'status\');

var options=[];
	options[\'pk\']=pk;
	options[\'campos[status]\']=status;
var link=reaction(options,\'setData\',\'\',true);

getAjax(link,\'GET\',{ },item, function(msg){
     if (msg>=0){
     	var newstatus=\'0\';
     	var icon=\'E\';
     	if (status==\'0\'){
     		newstatus=\'1\'
     		icon=\'X\';
     	}
     	
     	$(item).data(\'status\',newstatus).attr(\'src\',\'img/\'+icon+\'.png\');

     }
   });

}

{% /append %}

<td >

     {% if ($row[status]=="1") %}
          <img src="img/E.png" title="Click para cambiar" data-status=\'0\' data-pk=\'$row[pk]\' id=\'img_status_$row[pk]\' onclick="cambiarStatus(this);" >
     {% /if %}
     {% else %}
          <img src="img/X.png" title="Click para cambiar" data-status=\'1\' data-pk=\'$row[pk]\' id=\'img_status_$row[pk]\' onclick="cambiarStatus(this);" >
     {% /else %}
</td>














</code> Compilado </span><br>---Renderizado Componente: listtable_col::tipo=status&status=1&key=status<br>Se copia el archivo para el componente:sort.png<br>Se copia el archivo para el componente:sort_asc.png<br>Se copia el archivo para el componente:sort_desc.png<br>code unique
{% php if ($_action=='ver'){  $clasver='ver';}else{  $clasver='';} %} POsicion: 25243<br>Procesado el Componente: form_input<strong style="color:red"><hr>Copilacion de: <hr>

{% echo  str_replace('form-config-section componente','',$campos[fecha][i_pre]);  %}

{% if '[[var:]]unico[[:var]]'=='1' %}

[% append js.inline %]
var old_fecha='[% echo [[]]item[fecha]; %]';
function isUnique_fecha(){
	var dato=[[]]('#fecha').val();
	if (dato==''){
		[[]]('.btnPrevAjax').show();
		return true;
	}
	if (dato!=old_fecha){
		[[]]('.btnPrevAjax').hide();
		dataUnique([[]]('#[[var:]]primary[[:var]]').val(),'fecha',dato,function(msg){
			if (msg!='0'){
				alertfocus('Ese [% echo [[]]anexos[fecha][labelf] %] ya existe!!!','#fecha')
			}else{
				old_fecha=dato;
				[[]]('.btnPrevAjax').show();
			}
		});
	}
}
[% /append %]


{% /if %}

 

{% php if (('date'=='selec')||('date'=='selecdb')||('date'=='selecdbgrupo')) { $tipoinput='selec';}else{ $tipoinput='date';} %}


{% echo '[[component:]]form_input.'.$tipoinput.'::id=fecha&tipo=date&tam=&clase=s3&unico=[[var:]]unico[[:var]]&dataon=[[var:]]dataon[[:var]]&decimal=[[var:]]decimal[[:var]]&validate= required &primary=[[var:]]primary[[:var]]&readonly=[[var:]]readonly[[:var]]&eventos=[[var:]]eventos[[:var]][[:component]]'; %}

{% echo $campos[fecha][i_pos] %}
<hr><hr></strong><strong style="color:blue"><hr>Copilacion de: <hr>

<div class="row  i_c-section bindered" id="c-section-0" data-campo="c-section-0" data-type="c-section"> <div class="dropin row               ">



 




[[component:]]form_input.date::id=fecha&tipo=date&tam=&clase=s3&unico=[[var:]]unico[[:var]]&dataon=[[var:]]dataon[[:var]]&decimal=[[var:]]decimal[[:var]]&validate= required &primary=[[var:]]primary[[:var]]&readonly=[[var:]]readonly[[:var]]&eventos=[[var:]]eventos[[:var]][[:component]]


<hr><hr></strong><br><span style='color:red;'><code>

<div class="row  i_c-section bindered" id="c-section-0" data-campo="c-section-0" data-type="c-section"> <div class="dropin row               ">



 




[[component:]]form_input.date::id=fecha&tipo=date&tam=&clase=s3&unico=[[var:]]unico[[:var]]&dataon=[[var:]]dataon[[:var]]&decimal=[[var:]]decimal[[:var]]&validate= required &primary=[[var:]]primary[[:var]]&readonly=[[var:]]readonly[[:var]]&eventos=[[var:]]eventos[[:var]][[:component]]


</code> Compilado </span><br>---Renderizado Componente: form_input::id=fecha&tipo=date&tam=&clase=s3&validate= required <strong style="color:red"><hr>Copilacion de: <hr>

{% echo  str_replace('form-config-section componente','',$campos[pk][i_pre]);  %}

{% if '[[var:]]unico[[:var]]'=='1' %}

[% append js.inline %]
var old_pk='[% echo [[]]item[pk]; %]';
function isUnique_pk(){
	var dato=[[]]('#pk').val();
	if (dato==''){
		[[]]('.btnPrevAjax').show();
		return true;
	}
	if (dato!=old_pk){
		[[]]('.btnPrevAjax').hide();
		dataUnique([[]]('#[[var:]]primary[[:var]]').val(),'pk',dato,function(msg){
			if (msg!='0'){
				alertfocus('Ese [% echo [[]]anexos[pk][labelf] %] ya existe!!!','#pk')
			}else{
				old_pk=dato;
				[[]]('.btnPrevAjax').show();
			}
		});
	}
}
[% /append %]


{% /if %}

 

{% php if (('oculto'=='selec')||('oculto'=='selecdb')||('oculto'=='selecdbgrupo')) { $tipoinput='selec';}else{ $tipoinput='oculto';} %}


{% echo '[[component:]]form_input.'.$tipoinput.'::id=pk&tipo=oculto&tam=&clase=s12&unico=[[var:]]unico[[:var]]&dataon=[[var:]]dataon[[:var]]&decimal=[[var:]]decimal[[:var]]&validate=numerico&primary=[[var:]]primary[[:var]]&readonly=[[var:]]readonly[[:var]]&eventos= onkeypress=\' return soloNum(event,this);\' [[:component]]'; %}

{% echo $campos[pk][i_pos] %}
<hr><hr></strong><strong style="color:blue"><hr>Copilacion de: <hr>





 




[[component:]]form_input.oculto::id=pk&tipo=oculto&tam=&clase=s12&unico=[[var:]]unico[[:var]]&dataon=[[var:]]dataon[[:var]]&decimal=[[var:]]decimal[[:var]]&validate=numerico&primary=[[var:]]primary[[:var]]&readonly=[[var:]]readonly[[:var]]&eventos= onkeypress=' return soloNum(event,this);' [[:component]]


<hr><hr></strong><br><span style='color:red;'><code>





 




[[component:]]form_input.oculto::id=pk&tipo=oculto&tam=&clase=s12&unico=[[var:]]unico[[:var]]&dataon=[[var:]]dataon[[:var]]&decimal=[[var:]]decimal[[:var]]&validate=numerico&primary=[[var:]]primary[[:var]]&readonly=[[var:]]readonly[[:var]]&eventos= onkeypress=' return soloNum(event,this);' [[:component]]


</code> Compilado </span><br>---Renderizado Componente: form_input::id=pk&tipo=oculto&tam=&clase=s12&validate=numerico&eventos= onkeypress=\' return soloNum(event,this);\' <strong style="color:red"><hr>Copilacion de: <hr>

{% echo  str_replace('form-config-section componente','',$campos[tipo][i_pre]);  %}

{% if '[[var:]]unico[[:var]]'=='1' %}

[% append js.inline %]
var old_tipo='[% echo [[]]item[tipo]; %]';
function isUnique_tipo(){
	var dato=[[]]('#tipo').val();
	if (dato==''){
		[[]]('.btnPrevAjax').show();
		return true;
	}
	if (dato!=old_tipo){
		[[]]('.btnPrevAjax').hide();
		dataUnique([[]]('#[[var:]]primary[[:var]]').val(),'tipo',dato,function(msg){
			if (msg!='0'){
				alertfocus('Ese [% echo [[]]anexos[tipo][labelf] %] ya existe!!!','#tipo')
			}else{
				old_tipo=dato;
				[[]]('.btnPrevAjax').show();
			}
		});
	}
}
[% /append %]


{% /if %}

 

{% php if (('selec'=='selec')||('selec'=='selecdb')||('selec'=='selecdbgrupo')) { $tipoinput='selec';}else{ $tipoinput='selec';} %}


{% echo '[[component:]]form_input.'.$tipoinput.'::id=tipo&tipo=selec&tam=&clase=s3&unico=[[var:]]unico[[:var]]&dataon=[[var:]]dataon[[:var]]&decimal=[[var:]]decimal[[:var]]&validate=&primary=[[var:]]primary[[:var]]&readonly=[[var:]]readonly[[:var]]&eventos=[[var:]]eventos[[:var]][[:component]]'; %}

{% echo $campos[tipo][i_pos] %}
<hr><hr></strong><strong style="color:blue"><hr>Copilacion de: <hr>





 




[[component:]]form_input.selec::id=tipo&tipo=selec&tam=&clase=s3&unico=[[var:]]unico[[:var]]&dataon=[[var:]]dataon[[:var]]&decimal=[[var:]]decimal[[:var]]&validate=&primary=[[var:]]primary[[:var]]&readonly=[[var:]]readonly[[:var]]&eventos=[[var:]]eventos[[:var]][[:component]]


<hr><hr></strong><br><span style='color:red;'><code>





 




[[component:]]form_input.selec::id=tipo&tipo=selec&tam=&clase=s3&unico=[[var:]]unico[[:var]]&dataon=[[var:]]dataon[[:var]]&decimal=[[var:]]decimal[[:var]]&validate=&primary=[[var:]]primary[[:var]]&readonly=[[var:]]readonly[[:var]]&eventos=[[var:]]eventos[[:var]][[:component]]


</code> Compilado </span><br>---Renderizado Componente: form_input::id=tipo&tipo=selec&tam=&clase=s3&validate=<strong style="color:red"><hr>Copilacion de: <hr>

{% echo  str_replace('form-config-section componente','',$campos[fk_almacenes][i_pre]);  %}

{% if '[[var:]]unico[[:var]]'=='1' %}

[% append js.inline %]
var old_fk_almacenes='[% echo [[]]item[fk_almacenes]; %]';
function isUnique_fk_almacenes(){
	var dato=[[]]('#fk_almacenes').val();
	if (dato==''){
		[[]]('.btnPrevAjax').show();
		return true;
	}
	if (dato!=old_fk_almacenes){
		[[]]('.btnPrevAjax').hide();
		dataUnique([[]]('#[[var:]]primary[[:var]]').val(),'fk_almacenes',dato,function(msg){
			if (msg!='0'){
				alertfocus('Ese [% echo [[]]anexos[fk_almacenes][labelf] %] ya existe!!!','#fk_almacenes')
			}else{
				old_fk_almacenes=dato;
				[[]]('.btnPrevAjax').show();
			}
		});
	}
}
[% /append %]


{% /if %}

 

{% php if (('selecdb'=='selec')||('selecdb'=='selecdb')||('selecdb'=='selecdbgrupo')) { $tipoinput='selec';}else{ $tipoinput='selecdb';} %}


{% echo '[[component:]]form_input.'.$tipoinput.'::id=fk_almacenes&tipo=selecdb&tam=&clase=s6&unico=[[var:]]unico[[:var]]&dataon=[[var:]]dataon[[:var]]&decimal=[[var:]]decimal[[:var]]&validate=numerico required &primary=[[var:]]primary[[:var]]&readonly=[[var:]]readonly[[:var]]&eventos= onkeypress=\' return soloNum(event,this);\' [[:component]]'; %}

{% echo $campos[fk_almacenes][i_pos] %}
<hr><hr></strong><strong style="color:blue"><hr>Copilacion de: <hr>





 




[[component:]]form_input.selec::id=fk_almacenes&tipo=selecdb&tam=&clase=s6&unico=[[var:]]unico[[:var]]&dataon=[[var:]]dataon[[:var]]&decimal=[[var:]]decimal[[:var]]&validate=numerico required &primary=[[var:]]primary[[:var]]&readonly=[[var:]]readonly[[:var]]&eventos= onkeypress=' return soloNum(event,this);' [[:component]]


<hr><hr></strong><br><span style='color:red;'><code>





 




[[component:]]form_input.selec::id=fk_almacenes&tipo=selecdb&tam=&clase=s6&unico=[[var:]]unico[[:var]]&dataon=[[var:]]dataon[[:var]]&decimal=[[var:]]decimal[[:var]]&validate=numerico required &primary=[[var:]]primary[[:var]]&readonly=[[var:]]readonly[[:var]]&eventos= onkeypress=' return soloNum(event,this);' [[:component]]


</code> Compilado </span><br>---Renderizado Componente: form_input::id=fk_almacenes&tipo=selecdb&tam=&clase=s6&validate=numerico required &eventos= onkeypress=\' return soloNum(event,this);\' <strong style="color:red"><hr>Copilacion de: <hr>

{% echo  str_replace('form-config-section componente','',$campos[fk_prod][i_pre]);  %}

{% if '[[var:]]unico[[:var]]'=='1' %}

[% append js.inline %]
var old_fk_prod='[% echo [[]]item[fk_prod]; %]';
function isUnique_fk_prod(){
	var dato=[[]]('#fk_prod').val();
	if (dato==''){
		[[]]('.btnPrevAjax').show();
		return true;
	}
	if (dato!=old_fk_prod){
		[[]]('.btnPrevAjax').hide();
		dataUnique([[]]('#[[var:]]primary[[:var]]').val(),'fk_prod',dato,function(msg){
			if (msg!='0'){
				alertfocus('Ese [% echo [[]]anexos[fk_prod][labelf] %] ya existe!!!','#fk_prod')
			}else{
				old_fk_prod=dato;
				[[]]('.btnPrevAjax').show();
			}
		});
	}
}
[% /append %]


{% /if %}

 

{% php if (('buscardb'=='selec')||('buscardb'=='selecdb')||('buscardb'=='selecdbgrupo')) { $tipoinput='selec';}else{ $tipoinput='buscardb';} %}


{% echo '[[component:]]form_input.'.$tipoinput.'::id=fk_prod&tipo=buscardb&tam=&clase=s9&unico=[[var:]]unico[[:var]]&dataon=[[var:]]dataon[[:var]]&decimal=[[var:]]decimal[[:var]]&validate=numerico required &primary=[[var:]]primary[[:var]]&readonly=[[var:]]readonly[[:var]]&eventos= onkeypress=\' return soloNum(event,this);\'  onblur=\'onChangeProd(); _buscarNomDb(this);\' [[:component]]'; %}

{% echo $campos[fk_prod][i_pos] %}
<hr><hr></strong><strong style="color:blue"><hr>Copilacion de: <hr>





 




[[component:]]form_input.buscardb::id=fk_prod&tipo=buscardb&tam=&clase=s9&unico=[[var:]]unico[[:var]]&dataon=[[var:]]dataon[[:var]]&decimal=[[var:]]decimal[[:var]]&validate=numerico required &primary=[[var:]]primary[[:var]]&readonly=[[var:]]readonly[[:var]]&eventos= onkeypress=' return soloNum(event,this);'  onblur='onChangeProd(); _buscarNomDb(this);' [[:component]]


<hr><hr></strong><br><span style='color:red;'><code>





 




[[component:]]form_input.buscardb::id=fk_prod&tipo=buscardb&tam=&clase=s9&unico=[[var:]]unico[[:var]]&dataon=[[var:]]dataon[[:var]]&decimal=[[var:]]decimal[[:var]]&validate=numerico required &primary=[[var:]]primary[[:var]]&readonly=[[var:]]readonly[[:var]]&eventos= onkeypress=' return soloNum(event,this);'  onblur='onChangeProd(); _buscarNomDb(this);' [[:component]]


</code> Compilado </span><br>---Renderizado Componente: form_input::id=fk_prod&tipo=buscardb&tam=&clase=s9&validate=numerico required &eventos= onkeypress=\' return soloNum(event,this);\'  onblur=\'onChangeProd(); _buscarNomDb(this);\' <strong style="color:red"><hr>Copilacion de: <hr>

{% echo  str_replace('form-config-section componente','',$campos[cant][i_pre]);  %}

{% if '[[var:]]unico[[:var]]'=='1' %}

[% append js.inline %]
var old_cant='[% echo [[]]item[cant]; %]';
function isUnique_cant(){
	var dato=[[]]('#cant').val();
	if (dato==''){
		[[]]('.btnPrevAjax').show();
		return true;
	}
	if (dato!=old_cant){
		[[]]('.btnPrevAjax').hide();
		dataUnique([[]]('#[[var:]]primary[[:var]]').val(),'cant',dato,function(msg){
			if (msg!='0'){
				alertfocus('Ese [% echo [[]]anexos[cant][labelf] %] ya existe!!!','#cant')
			}else{
				old_cant=dato;
				[[]]('.btnPrevAjax').show();
			}
		});
	}
}
[% /append %]


{% /if %}

 

{% php if (('float'=='selec')||('float'=='selecdb')||('float'=='selecdbgrupo')) { $tipoinput='selec';}else{ $tipoinput='float';} %}


{% echo '[[component:]]form_input.'.$tipoinput.'::id=cant&tipo=float&tam=&clase=s2&unico=[[var:]]unico[[:var]]&dataon=[[var:]]dataon[[:var]]&decimal=2&validate=numerico required &primary=[[var:]]primary[[:var]]&readonly=[[var:]]readonly[[:var]]&eventos= onkeypress=\' return soloNum(event,this);\'  onblur=\' _refreshFloat(this);\' [[:component]]'; %}

{% echo $campos[cant][i_pos] %}
<hr><hr></strong><strong style="color:blue"><hr>Copilacion de: <hr>





 




[[component:]]form_input.float::id=cant&tipo=float&tam=&clase=s2&unico=[[var:]]unico[[:var]]&dataon=[[var:]]dataon[[:var]]&decimal=2&validate=numerico required &primary=[[var:]]primary[[:var]]&readonly=[[var:]]readonly[[:var]]&eventos= onkeypress=' return soloNum(event,this);'  onblur=' _refreshFloat(this);' [[:component]]


<hr><hr></strong><br><span style='color:red;'><code>





 




[[component:]]form_input.float::id=cant&tipo=float&tam=&clase=s2&unico=[[var:]]unico[[:var]]&dataon=[[var:]]dataon[[:var]]&decimal=2&validate=numerico required &primary=[[var:]]primary[[:var]]&readonly=[[var:]]readonly[[:var]]&eventos= onkeypress=' return soloNum(event,this);'  onblur=' _refreshFloat(this);' [[:component]]


</code> Compilado </span><br>---Renderizado Componente: form_input::id=cant&tipo=float&tam=&clase=s2&decimal=2&validate=numerico required &eventos= onkeypress=\' return soloNum(event,this);\'  onblur=\' _refreshFloat(this);\' <strong style="color:red"><hr>Copilacion de: <hr>

{% echo  str_replace('form-config-section componente','',$campos[fk_unidades][i_pre]);  %}

{% if '[[var:]]unico[[:var]]'=='1' %}

[% append js.inline %]
var old_fk_unidades='[% echo [[]]item[fk_unidades]; %]';
function isUnique_fk_unidades(){
	var dato=[[]]('#fk_unidades').val();
	if (dato==''){
		[[]]('.btnPrevAjax').show();
		return true;
	}
	if (dato!=old_fk_unidades){
		[[]]('.btnPrevAjax').hide();
		dataUnique([[]]('#[[var:]]primary[[:var]]').val(),'fk_unidades',dato,function(msg){
			if (msg!='0'){
				alertfocus('Ese [% echo [[]]anexos[fk_unidades][labelf] %] ya existe!!!','#fk_unidades')
			}else{
				old_fk_unidades=dato;
				[[]]('.btnPrevAjax').show();
			}
		});
	}
}
[% /append %]


{% /if %}

 

{% php if (('selecdb'=='selec')||('selecdb'=='selecdb')||('selecdb'=='selecdbgrupo')) { $tipoinput='selec';}else{ $tipoinput='selecdb';} %}


{% echo '[[component:]]form_input.'.$tipoinput.'::id=fk_unidades&tipo=selecdb&tam=&clase=s1&unico=[[var:]]unico[[:var]]&dataon=[[var:]]dataon[[:var]]&decimal=[[var:]]decimal[[:var]]&validate=numerico required &primary=[[var:]]primary[[:var]]&readonly=[[var:]]readonly[[:var]]&eventos= onkeypress=\' return soloNum(event,this);\' [[:component]]'; %}

{% echo $campos[fk_unidades][i_pos] %}
<hr><hr></strong><strong style="color:blue"><hr>Copilacion de: <hr>





 




[[component:]]form_input.selec::id=fk_unidades&tipo=selecdb&tam=&clase=s1&unico=[[var:]]unico[[:var]]&dataon=[[var:]]dataon[[:var]]&decimal=[[var:]]decimal[[:var]]&validate=numerico required &primary=[[var:]]primary[[:var]]&readonly=[[var:]]readonly[[:var]]&eventos= onkeypress=' return soloNum(event,this);' [[:component]]


<hr><hr></strong><br><span style='color:red;'><code>





 




[[component:]]form_input.selec::id=fk_unidades&tipo=selecdb&tam=&clase=s1&unico=[[var:]]unico[[:var]]&dataon=[[var:]]dataon[[:var]]&decimal=[[var:]]decimal[[:var]]&validate=numerico required &primary=[[var:]]primary[[:var]]&readonly=[[var:]]readonly[[:var]]&eventos= onkeypress=' return soloNum(event,this);' [[:component]]


</code> Compilado </span><br>---Renderizado Componente: form_input::id=fk_unidades&tipo=selecdb&tam=&clase=s1&validate=numerico required &eventos= onkeypress=\' return soloNum(event,this);\' <strong style="color:red"><hr>Copilacion de: <hr>

{% echo  str_replace('form-config-section componente','',$campos[costo][i_pre]);  %}

{% if '[[var:]]unico[[:var]]'=='1' %}

[% append js.inline %]
var old_costo='[% echo [[]]item[costo]; %]';
function isUnique_costo(){
	var dato=[[]]('#costo').val();
	if (dato==''){
		[[]]('.btnPrevAjax').show();
		return true;
	}
	if (dato!=old_costo){
		[[]]('.btnPrevAjax').hide();
		dataUnique([[]]('#[[var:]]primary[[:var]]').val(),'costo',dato,function(msg){
			if (msg!='0'){
				alertfocus('Ese [% echo [[]]anexos[costo][labelf] %] ya existe!!!','#costo')
			}else{
				old_costo=dato;
				[[]]('.btnPrevAjax').show();
			}
		});
	}
}
[% /append %]


{% /if %}

 

{% php if (('float'=='selec')||('float'=='selecdb')||('float'=='selecdbgrupo')) { $tipoinput='selec';}else{ $tipoinput='float';} %}


{% echo '[[component:]]form_input.'.$tipoinput.'::id=costo&tipo=float&tam=&clase=s4&unico=[[var:]]unico[[:var]]&dataon=[[var:]]dataon[[:var]]&decimal=2&validate=numerico required &primary=[[var:]]primary[[:var]]&readonly=[[var:]]readonly[[:var]]&eventos= onkeypress=\' return soloNum(event,this);\'  onblur=\' _refreshFloat(this);\' [[:component]]'; %}

{% echo $campos[costo][i_pos] %}
<hr><hr></strong><strong style="color:blue"><hr>Copilacion de: <hr>





 




[[component:]]form_input.float::id=costo&tipo=float&tam=&clase=s4&unico=[[var:]]unico[[:var]]&dataon=[[var:]]dataon[[:var]]&decimal=2&validate=numerico required &primary=[[var:]]primary[[:var]]&readonly=[[var:]]readonly[[:var]]&eventos= onkeypress=' return soloNum(event,this);'  onblur=' _refreshFloat(this);' [[:component]]


<hr><hr></strong><br><span style='color:red;'><code>





 




[[component:]]form_input.float::id=costo&tipo=float&tam=&clase=s4&unico=[[var:]]unico[[:var]]&dataon=[[var:]]dataon[[:var]]&decimal=2&validate=numerico required &primary=[[var:]]primary[[:var]]&readonly=[[var:]]readonly[[:var]]&eventos= onkeypress=' return soloNum(event,this);'  onblur=' _refreshFloat(this);' [[:component]]


</code> Compilado </span><br>---Renderizado Componente: form_input::id=costo&tipo=float&tam=&clase=s4&decimal=2&validate=numerico required &eventos= onkeypress=\' return soloNum(event,this);\'  onblur=\' _refreshFloat(this);\' <strong style="color:red"><hr>Copilacion de: <hr>

{% echo  str_replace('form-config-section componente','',$campos[tipodoc][i_pre]);  %}

{% if '[[var:]]unico[[:var]]'=='1' %}

[% append js.inline %]
var old_tipodoc='[% echo [[]]item[tipodoc]; %]';
function isUnique_tipodoc(){
	var dato=[[]]('#tipodoc').val();
	if (dato==''){
		[[]]('.btnPrevAjax').show();
		return true;
	}
	if (dato!=old_tipodoc){
		[[]]('.btnPrevAjax').hide();
		dataUnique([[]]('#[[var:]]primary[[:var]]').val(),'tipodoc',dato,function(msg){
			if (msg!='0'){
				alertfocus('Ese [% echo [[]]anexos[tipodoc][labelf] %] ya existe!!!','#tipodoc')
			}else{
				old_tipodoc=dato;
				[[]]('.btnPrevAjax').show();
			}
		});
	}
}
[% /append %]


{% /if %}

 

{% php if (('selec'=='selec')||('selec'=='selecdb')||('selec'=='selecdbgrupo')) { $tipoinput='selec';}else{ $tipoinput='selec';} %}


{% echo '[[component:]]form_input.'.$tipoinput.'::id=tipodoc&tipo=selec&tam=&clase=s4&unico=[[var:]]unico[[:var]]&dataon=[[var:]]dataon[[:var]]&decimal=[[var:]]decimal[[:var]]&validate=&primary=[[var:]]primary[[:var]]&readonly=[[var:]]readonly[[:var]]&eventos=[[var:]]eventos[[:var]][[:component]]'; %}

{% echo $campos[tipodoc][i_pos] %}
<hr><hr></strong><strong style="color:blue"><hr>Copilacion de: <hr>





 




[[component:]]form_input.selec::id=tipodoc&tipo=selec&tam=&clase=s4&unico=[[var:]]unico[[:var]]&dataon=[[var:]]dataon[[:var]]&decimal=[[var:]]decimal[[:var]]&validate=&primary=[[var:]]primary[[:var]]&readonly=[[var:]]readonly[[:var]]&eventos=[[var:]]eventos[[:var]][[:component]]


<hr><hr></strong><br><span style='color:red;'><code>





 




[[component:]]form_input.selec::id=tipodoc&tipo=selec&tam=&clase=s4&unico=[[var:]]unico[[:var]]&dataon=[[var:]]dataon[[:var]]&decimal=[[var:]]decimal[[:var]]&validate=&primary=[[var:]]primary[[:var]]&readonly=[[var:]]readonly[[:var]]&eventos=[[var:]]eventos[[:var]][[:component]]


</code> Compilado </span><br>---Renderizado Componente: form_input::id=tipodoc&tipo=selec&tam=&clase=s4&validate=<strong style="color:red"><hr>Copilacion de: <hr>

{% echo  str_replace('form-config-section componente','',$campos[nfac][i_pre]);  %}

{% if '[[var:]]unico[[:var]]'=='1' %}

[% append js.inline %]
var old_nfac='[% echo [[]]item[nfac]; %]';
function isUnique_nfac(){
	var dato=[[]]('#nfac').val();
	if (dato==''){
		[[]]('.btnPrevAjax').show();
		return true;
	}
	if (dato!=old_nfac){
		[[]]('.btnPrevAjax').hide();
		dataUnique([[]]('#[[var:]]primary[[:var]]').val(),'nfac',dato,function(msg){
			if (msg!='0'){
				alertfocus('Ese [% echo [[]]anexos[nfac][labelf] %] ya existe!!!','#nfac')
			}else{
				old_nfac=dato;
				[[]]('.btnPrevAjax').show();
			}
		});
	}
}
[% /append %]


{% /if %}

 

{% php if (('alfa'=='selec')||('alfa'=='selecdb')||('alfa'=='selecdbgrupo')) { $tipoinput='selec';}else{ $tipoinput='alfa';} %}


{% echo '[[component:]]form_input.'.$tipoinput.'::id=nfac&tipo=alfa&tam=&clase=s4&unico=[[var:]]unico[[:var]]&dataon=[[var:]]dataon[[:var]]&decimal=[[var:]]decimal[[:var]]&validate=&primary=[[var:]]primary[[:var]]&readonly=[[var:]]readonly[[:var]]&eventos=[[var:]]eventos[[:var]][[:component]]'; %}

{% echo $campos[nfac][i_pos] %}
<hr><hr></strong><strong style="color:blue"><hr>Copilacion de: <hr>





 




[[component:]]form_input.alfa::id=nfac&tipo=alfa&tam=&clase=s4&unico=[[var:]]unico[[:var]]&dataon=[[var:]]dataon[[:var]]&decimal=[[var:]]decimal[[:var]]&validate=&primary=[[var:]]primary[[:var]]&readonly=[[var:]]readonly[[:var]]&eventos=[[var:]]eventos[[:var]][[:component]]


<hr><hr></strong><br><span style='color:red;'><code>





 




[[component:]]form_input.alfa::id=nfac&tipo=alfa&tam=&clase=s4&unico=[[var:]]unico[[:var]]&dataon=[[var:]]dataon[[:var]]&decimal=[[var:]]decimal[[:var]]&validate=&primary=[[var:]]primary[[:var]]&readonly=[[var:]]readonly[[:var]]&eventos=[[var:]]eventos[[:var]][[:component]]


</code> Compilado </span><br>---Renderizado Componente: form_input::id=nfac&tipo=alfa&tam=&clase=s4&validate=<strong style="color:red"><hr>Copilacion de: <hr>

{% echo  str_replace('form-config-section componente','',$campos[serial][i_pre]);  %}

{% if '[[var:]]unico[[:var]]'=='1' %}

[% append js.inline %]
var old_serial='[% echo [[]]item[serial]; %]';
function isUnique_serial(){
	var dato=[[]]('#serial').val();
	if (dato==''){
		[[]]('.btnPrevAjax').show();
		return true;
	}
	if (dato!=old_serial){
		[[]]('.btnPrevAjax').hide();
		dataUnique([[]]('#[[var:]]primary[[:var]]').val(),'serial',dato,function(msg){
			if (msg!='0'){
				alertfocus('Ese [% echo [[]]anexos[serial][labelf] %] ya existe!!!','#serial')
			}else{
				old_serial=dato;
				[[]]('.btnPrevAjax').show();
			}
		});
	}
}
[% /append %]


{% /if %}

 

{% php if (('alfa'=='selec')||('alfa'=='selecdb')||('alfa'=='selecdbgrupo')) { $tipoinput='selec';}else{ $tipoinput='alfa';} %}


{% echo '[[component:]]form_input.'.$tipoinput.'::id=serial&tipo=alfa&tam=&clase=s6&unico=[[var:]]unico[[:var]]&dataon=[[var:]]dataon[[:var]]&decimal=[[var:]]decimal[[:var]]&validate=&primary=[[var:]]primary[[:var]]&readonly=[[var:]]readonly[[:var]]&eventos=[[var:]]eventos[[:var]][[:component]]'; %}

{% echo $campos[serial][i_pos] %}
<hr><hr></strong><strong style="color:blue"><hr>Copilacion de: <hr>





 




[[component:]]form_input.alfa::id=serial&tipo=alfa&tam=&clase=s6&unico=[[var:]]unico[[:var]]&dataon=[[var:]]dataon[[:var]]&decimal=[[var:]]decimal[[:var]]&validate=&primary=[[var:]]primary[[:var]]&readonly=[[var:]]readonly[[:var]]&eventos=[[var:]]eventos[[:var]][[:component]]


<hr><hr></strong><br><span style='color:red;'><code>





 




[[component:]]form_input.alfa::id=serial&tipo=alfa&tam=&clase=s6&unico=[[var:]]unico[[:var]]&dataon=[[var:]]dataon[[:var]]&decimal=[[var:]]decimal[[:var]]&validate=&primary=[[var:]]primary[[:var]]&readonly=[[var:]]readonly[[:var]]&eventos=[[var:]]eventos[[:var]][[:component]]


</code> Compilado </span><br>---Renderizado Componente: form_input::id=serial&tipo=alfa&tam=&clase=s6&validate=<strong style="color:red"><hr>Copilacion de: <hr>

{% echo  str_replace('form-config-section componente','',$campos[fecven][i_pre]);  %}

{% if '[[var:]]unico[[:var]]'=='1' %}

[% append js.inline %]
var old_fecven='[% echo [[]]item[fecven]; %]';
function isUnique_fecven(){
	var dato=[[]]('#fecven').val();
	if (dato==''){
		[[]]('.btnPrevAjax').show();
		return true;
	}
	if (dato!=old_fecven){
		[[]]('.btnPrevAjax').hide();
		dataUnique([[]]('#[[var:]]primary[[:var]]').val(),'fecven',dato,function(msg){
			if (msg!='0'){
				alertfocus('Ese [% echo [[]]anexos[fecven][labelf] %] ya existe!!!','#fecven')
			}else{
				old_fecven=dato;
				[[]]('.btnPrevAjax').show();
			}
		});
	}
}
[% /append %]


{% /if %}

 

{% php if (('date'=='selec')||('date'=='selecdb')||('date'=='selecdbgrupo')) { $tipoinput='selec';}else{ $tipoinput='date';} %}


{% echo '[[component:]]form_input.'.$tipoinput.'::id=fecven&tipo=date&tam=&clase=s6&unico=[[var:]]unico[[:var]]&dataon=[[var:]]dataon[[:var]]&decimal=[[var:]]decimal[[:var]]&validate=&primary=[[var:]]primary[[:var]]&readonly=[[var:]]readonly[[:var]]&eventos=[[var:]]eventos[[:var]][[:component]]'; %}

{% echo $campos[fecven][i_pos] %}
<hr><hr></strong><strong style="color:blue"><hr>Copilacion de: <hr>





 




[[component:]]form_input.date::id=fecven&tipo=date&tam=&clase=s6&unico=[[var:]]unico[[:var]]&dataon=[[var:]]dataon[[:var]]&decimal=[[var:]]decimal[[:var]]&validate=&primary=[[var:]]primary[[:var]]&readonly=[[var:]]readonly[[:var]]&eventos=[[var:]]eventos[[:var]][[:component]]


<hr><hr></strong><br><span style='color:red;'><code>





 




[[component:]]form_input.date::id=fecven&tipo=date&tam=&clase=s6&unico=[[var:]]unico[[:var]]&dataon=[[var:]]dataon[[:var]]&decimal=[[var:]]decimal[[:var]]&validate=&primary=[[var:]]primary[[:var]]&readonly=[[var:]]readonly[[:var]]&eventos=[[var:]]eventos[[:var]][[:component]]


</code> Compilado </span><br>---Renderizado Componente: form_input::id=fecven&tipo=date&tam=&clase=s6&validate=<strong style="color:red"><hr>Copilacion de: <hr>

{% echo  str_replace('form-config-section componente','',$campos[fk_resp][i_pre]);  %}

{% if '[[var:]]unico[[:var]]'=='1' %}

[% append js.inline %]
var old_fk_resp='[% echo [[]]item[fk_resp]; %]';
function isUnique_fk_resp(){
	var dato=[[]]('#fk_resp').val();
	if (dato==''){
		[[]]('.btnPrevAjax').show();
		return true;
	}
	if (dato!=old_fk_resp){
		[[]]('.btnPrevAjax').hide();
		dataUnique([[]]('#[[var:]]primary[[:var]]').val(),'fk_resp',dato,function(msg){
			if (msg!='0'){
				alertfocus('Ese [% echo [[]]anexos[fk_resp][labelf] %] ya existe!!!','#fk_resp')
			}else{
				old_fk_resp=dato;
				[[]]('.btnPrevAjax').show();
			}
		});
	}
}
[% /append %]


{% /if %}

 

{% php if (('join'=='selec')||('join'=='selecdb')||('join'=='selecdbgrupo')) { $tipoinput='selec';}else{ $tipoinput='join';} %}


{% echo '[[component:]]form_input.'.$tipoinput.'::id=fk_resp&tipo=join&tam=&clase=s12&unico=[[var:]]unico[[:var]]&dataon=[[var:]]dataon[[:var]]&decimal=[[var:]]decimal[[:var]]&validate=numerico required &primary=[[var:]]primary[[:var]]&readonly=[[var:]]readonly[[:var]]&eventos= onkeypress=\' return soloNum(event,this);\' [[:component]]'; %}

{% echo $campos[fk_resp][i_pos] %}
<hr><hr></strong><strong style="color:blue"><hr>Copilacion de: <hr>





 




[[component:]]form_input.join::id=fk_resp&tipo=join&tam=&clase=s12&unico=[[var:]]unico[[:var]]&dataon=[[var:]]dataon[[:var]]&decimal=[[var:]]decimal[[:var]]&validate=numerico required &primary=[[var:]]primary[[:var]]&readonly=[[var:]]readonly[[:var]]&eventos= onkeypress=' return soloNum(event,this);' [[:component]]

</div></div>
<hr><hr></strong><br><span style='color:red;'><code>





 




[[component:]]form_input.join::id=fk_resp&tipo=join&tam=&clase=s12&unico=[[var:]]unico[[:var]]&dataon=[[var:]]dataon[[:var]]&decimal=[[var:]]decimal[[:var]]&validate=numerico required &primary=[[var:]]primary[[:var]]&readonly=[[var:]]readonly[[:var]]&eventos= onkeypress=' return soloNum(event,this);' [[:component]]

</div></div>
</code> Compilado </span><br>---Renderizado Componente: form_input::id=fk_resp&tipo=join&tam=&clase=s12&validate=numerico required &eventos= onkeypress=\' return soloNum(event,this);\' <hr>nuevos componentes<hr><pre>Array
(
    [listtable_buscar] => Array
        (
            [0] => 
        )

    [form_input.date] => Array
        (
            [0] => id=fecha&tipo=date&tam=&clase=s3&unico=[[var:]]unico[[:var]]&dataon=[[var:]]dataon[[:var]]&decimal=[[var:]]decimal[[:var]]&validate= required &primary=[[var:]]primary[[:var]]&readonly=[[var:]]readonly[[:var]]&eventos=[[var:]]eventos[[:var]]
            [1] => id=fecven&tipo=date&tam=&clase=s6&unico=[[var:]]unico[[:var]]&dataon=[[var:]]dataon[[:var]]&decimal=[[var:]]decimal[[:var]]&validate=&primary=[[var:]]primary[[:var]]&readonly=[[var:]]readonly[[:var]]&eventos=[[var:]]eventos[[:var]]
        )

    [form_input.oculto] => Array
        (
            [0] => id=pk&tipo=oculto&tam=&clase=s12&unico=[[var:]]unico[[:var]]&dataon=[[var:]]dataon[[:var]]&decimal=[[var:]]decimal[[:var]]&validate=numerico&primary=[[var:]]primary[[:var]]&readonly=[[var:]]readonly[[:var]]&eventos= onkeypress=' return soloNum(event,this);' 
        )

    [form_input.selec] => Array
        (
            [0] => id=tipo&tipo=selec&tam=&clase=s3&unico=[[var:]]unico[[:var]]&dataon=[[var:]]dataon[[:var]]&decimal=[[var:]]decimal[[:var]]&validate=&primary=[[var:]]primary[[:var]]&readonly=[[var:]]readonly[[:var]]&eventos=[[var:]]eventos[[:var]]
            [1] => id=fk_almacenes&tipo=selecdb&tam=&clase=s6&unico=[[var:]]unico[[:var]]&dataon=[[var:]]dataon[[:var]]&decimal=[[var:]]decimal[[:var]]&validate=numerico required &primary=[[var:]]primary[[:var]]&readonly=[[var:]]readonly[[:var]]&eventos= onkeypress=' return soloNum(event,this);' 
            [2] => id=fk_unidades&tipo=selecdb&tam=&clase=s1&unico=[[var:]]unico[[:var]]&dataon=[[var:]]dataon[[:var]]&decimal=[[var:]]decimal[[:var]]&validate=numerico required &primary=[[var:]]primary[[:var]]&readonly=[[var:]]readonly[[:var]]&eventos= onkeypress=' return soloNum(event,this);' 
            [3] => id=tipodoc&tipo=selec&tam=&clase=s4&unico=[[var:]]unico[[:var]]&dataon=[[var:]]dataon[[:var]]&decimal=[[var:]]decimal[[:var]]&validate=&primary=[[var:]]primary[[:var]]&readonly=[[var:]]readonly[[:var]]&eventos=[[var:]]eventos[[:var]]
        )

    [form_input.buscardb] => Array
        (
            [0] => id=fk_prod&tipo=buscardb&tam=&clase=s9&unico=[[var:]]unico[[:var]]&dataon=[[var:]]dataon[[:var]]&decimal=[[var:]]decimal[[:var]]&validate=numerico required &primary=[[var:]]primary[[:var]]&readonly=[[var:]]readonly[[:var]]&eventos= onkeypress=' return soloNum(event,this);'  onblur='onChangeProd(); _buscarNomDb(this);' 
        )

    [form_input.float] => Array
        (
            [0] => id=cant&tipo=float&tam=&clase=s2&unico=[[var:]]unico[[:var]]&dataon=[[var:]]dataon[[:var]]&decimal=2&validate=numerico required &primary=[[var:]]primary[[:var]]&readonly=[[var:]]readonly[[:var]]&eventos= onkeypress=' return soloNum(event,this);'  onblur=' _refreshFloat(this);' 
            [1] => id=costo&tipo=float&tam=&clase=s4&unico=[[var:]]unico[[:var]]&dataon=[[var:]]dataon[[:var]]&decimal=2&validate=numerico required &primary=[[var:]]primary[[:var]]&readonly=[[var:]]readonly[[:var]]&eventos= onkeypress=' return soloNum(event,this);'  onblur=' _refreshFloat(this);' 
        )

    [form_input.alfa] => Array
        (
            [0] => id=nfac&tipo=alfa&tam=&clase=s4&unico=[[var:]]unico[[:var]]&dataon=[[var:]]dataon[[:var]]&decimal=[[var:]]decimal[[:var]]&validate=&primary=[[var:]]primary[[:var]]&readonly=[[var:]]readonly[[:var]]&eventos=[[var:]]eventos[[:var]]
            [1] => id=serial&tipo=alfa&tam=&clase=s6&unico=[[var:]]unico[[:var]]&dataon=[[var:]]dataon[[:var]]&decimal=[[var:]]decimal[[:var]]&validate=&primary=[[var:]]primary[[:var]]&readonly=[[var:]]readonly[[:var]]&eventos=[[var:]]eventos[[:var]]
        )

    [form_input.join] => Array
        (
            [0] => id=fk_resp&tipo=join&tam=&clase=s12&unico=[[var:]]unico[[:var]]&dataon=[[var:]]dataon[[:var]]&decimal=[[var:]]decimal[[:var]]&validate=numerico required &primary=[[var:]]primary[[:var]]&readonly=[[var:]]readonly[[:var]]&eventos= onkeypress=' return soloNum(event,this);' 
        )

)
</pre><br>Procesado el Componente: listtable_buscar<br>EL php opciones es: <option value="pk" class="_sc2">Id</option><option value="fecha" class="">Fecha</option><option value="fk_almacenes" class="">Almacen</option><option value="fk_prod" class="">Producto</option><option value="cant" class="_sc2">Cant</option><option value="costo" class="_sc2">Costo</option><option value="fk_unidades" class="">Unidad</option><option value="tipo" class="_sc1">Tipo</option><option value="tipodoc" class="_sc1">Tipo Doc.</option><option value="nfac" class="_sc1">Doc</option><option value="fecven" class="">Vence</option><option value="serial" class="_sc1">Serial</option><option value="fk_resp" class="">Resp</option><option value="created_" class="_sc4">Created_</option><option value="modified_" class="_sc4">Modified_</option><br>---Renderizado Componente: listtable_buscar<br>code unique

{% append js.files %}
	<link href='js/datedropper/datedropper.css' rel='stylesheet'>
	<script type='text/javascript' src='js/datedropper/datedropper.js'></script>
{% /append %}

[[setvar: openform]]
	$('input.datafecha').dateDropper();
[[:setvar]]

 POsicion: <br>Procesado el Componente: date<br>---Renderizado Componente: form_input.date::id=fecha&tipo=date&tam=&clase=s3&unico=[[var:]]unico[[:var]]&dataon=[[var:]]dataon[[:var]]&decimal=[[var:]]decimal[[:var]]&validate= required &primary=[[var:]]primary[[:var]]&readonly=[[var:]]readonly[[:var]]&eventos=[[var:]]eventos[[:var]]<br>---Renderizado Componente: form_input.date::id=fecven&tipo=date&tam=&clase=s6&unico=[[var:]]unico[[:var]]&dataon=[[var:]]dataon[[:var]]&decimal=[[var:]]decimal[[:var]]&validate=&primary=[[var:]]primary[[:var]]&readonly=[[var:]]readonly[[:var]]&eventos=[[var:]]eventos[[:var]]<br>Procesado el Componente: oculto<br>---Renderizado Componente: form_input.oculto::id=pk&tipo=oculto&tam=&clase=s12&unico=[[var:]]unico[[:var]]&dataon=[[var:]]dataon[[:var]]&decimal=[[var:]]decimal[[:var]]&validate=numerico&primary=[[var:]]primary[[:var]]&readonly=[[var:]]readonly[[:var]]&eventos= onkeypress=' return soloNum(event,this);' <br>Procesado el Componente: selec<br>---Renderizado Componente: form_input.selec::id=tipo&tipo=selec&tam=&clase=s3&unico=[[var:]]unico[[:var]]&dataon=[[var:]]dataon[[:var]]&decimal=[[var:]]decimal[[:var]]&validate=&primary=[[var:]]primary[[:var]]&readonly=[[var:]]readonly[[:var]]&eventos=[[var:]]eventos[[:var]]<br>---Renderizado Componente: form_input.selec::id=fk_almacenes&tipo=selecdb&tam=&clase=s6&unico=[[var:]]unico[[:var]]&dataon=[[var:]]dataon[[:var]]&decimal=[[var:]]decimal[[:var]]&validate=numerico required &primary=[[var:]]primary[[:var]]&readonly=[[var:]]readonly[[:var]]&eventos= onkeypress=' return soloNum(event,this);' <br>---Renderizado Componente: form_input.selec::id=fk_unidades&tipo=selecdb&tam=&clase=s1&unico=[[var:]]unico[[:var]]&dataon=[[var:]]dataon[[:var]]&decimal=[[var:]]decimal[[:var]]&validate=numerico required &primary=[[var:]]primary[[:var]]&readonly=[[var:]]readonly[[:var]]&eventos= onkeypress=' return soloNum(event,this);' <br>---Renderizado Componente: form_input.selec::id=tipodoc&tipo=selec&tam=&clase=s4&unico=[[var:]]unico[[:var]]&dataon=[[var:]]dataon[[:var]]&decimal=[[var:]]decimal[[:var]]&validate=&primary=[[var:]]primary[[:var]]&readonly=[[var:]]readonly[[:var]]&eventos=[[var:]]eventos[[:var]]<br>Procesado el Componente: buscardb<br>---Renderizado Componente: form_input.buscardb::id=fk_prod&tipo=buscardb&tam=&clase=s9&unico=[[var:]]unico[[:var]]&dataon=[[var:]]dataon[[:var]]&decimal=[[var:]]decimal[[:var]]&validate=numerico required &primary=[[var:]]primary[[:var]]&readonly=[[var:]]readonly[[:var]]&eventos= onkeypress=' return soloNum(event,this);'  onblur='onChangeProd(); _buscarNomDb(this);' <br>Procesado el Componente: float<br>---Renderizado Componente: form_input.float::id=cant&tipo=float&tam=&clase=s2&unico=[[var:]]unico[[:var]]&dataon=[[var:]]dataon[[:var]]&decimal=2&validate=numerico required &primary=[[var:]]primary[[:var]]&readonly=[[var:]]readonly[[:var]]&eventos= onkeypress=' return soloNum(event,this);'  onblur=' _refreshFloat(this);' <br>---Renderizado Componente: form_input.float::id=costo&tipo=float&tam=&clase=s4&unico=[[var:]]unico[[:var]]&dataon=[[var:]]dataon[[:var]]&decimal=2&validate=numerico required &primary=[[var:]]primary[[:var]]&readonly=[[var:]]readonly[[:var]]&eventos= onkeypress=' return soloNum(event,this);'  onblur=' _refreshFloat(this);' <br>Procesado el Componente: alfa<br>---Renderizado Componente: form_input.alfa::id=nfac&tipo=alfa&tam=&clase=s4&unico=[[var:]]unico[[:var]]&dataon=[[var:]]dataon[[:var]]&decimal=[[var:]]decimal[[:var]]&validate=&primary=[[var:]]primary[[:var]]&readonly=[[var:]]readonly[[:var]]&eventos=[[var:]]eventos[[:var]]<br>---Renderizado Componente: form_input.alfa::id=serial&tipo=alfa&tam=&clase=s6&unico=[[var:]]unico[[:var]]&dataon=[[var:]]dataon[[:var]]&decimal=[[var:]]decimal[[:var]]&validate=&primary=[[var:]]primary[[:var]]&readonly=[[var:]]readonly[[:var]]&eventos=[[var:]]eventos[[:var]]<br>Procesado el Componente: join<br>---Renderizado Componente: form_input.join::id=fk_resp&tipo=join&tam=&clase=s12&unico=[[var:]]unico[[:var]]&dataon=[[var:]]dataon[[:var]]&decimal=[[var:]]decimal[[:var]]&validate=numerico required &primary=[[var:]]primary[[:var]]&readonly=[[var:]]readonly[[:var]]&eventos= onkeypress=' return soloNum(event,this);' <hr>nuevos componentes<hr><pre>Array
(
)
</pre><br>Grabado Vista:D:\AppServ\www\framework\almacen\application\modulos\ingalm\\views\listar.html<h1>Inicia proceso de Vista:</h1><h2>view_formulario.html</h2><hr>nuevos componentes primera vez<hr><pre>Array
(
    [titulos] => Array
        (
            [0] => text=Adicionar
        )

    [formulario] => Array
        (
            [0] => 
        )

)
</pre><br>Procesado el Componente: titulos<br>---Renderizado Componente: titulos::text=Adicionar<br>Se copia el archivo para el componente:sort.png<br>Se copia el archivo para el componente:sort_asc.png<br>Se copia el archivo para el componente:sort_desc.png<br>Procesado el Componente: formulario<br>EL php codejs es: function onChangeProd(){
  var dato=$('#fk_prod').val();
    sel=$('#fk_prod').data('tag');
    if (sel>0){
      reaction('campo=fk_unidades&arg1=tipo&sel='+sel,'getListFor','','#fk_unidades',actualizarUI);
    }
}<br>EL php inputs es: [[component:]]form_input::id=fecha&tipo=date&tam=&clase=s3&validate= required [[:component]] [[component:]]form_input::id=pk&tipo=oculto&tam=&clase=s12&validate=numerico&eventos= onkeypress=\' return soloNum(event,this);\' [[:component]] [[component:]]form_input::id=tipo&tipo=selec&tam=&clase=s3&validate=[[:component]] [[component:]]form_input::id=fk_almacenes&tipo=selecdb&tam=&clase=s6&validate=numerico required &eventos= onkeypress=\' return soloNum(event,this);\' [[:component]] [[component:]]form_input::id=fk_prod&tipo=buscardb&tam=&clase=s9&validate=numerico required &eventos= onkeypress=\' return soloNum(event,this);\'  onblur=\'onChangeProd(); _buscarNomDb(this);\' [[:component]] [[component:]]form_input::id=cant&tipo=float&tam=&clase=s2&decimal=2&validate=numerico required &eventos= onkeypress=\' return soloNum(event,this);\'  onblur=\' _refreshFloat(this);\' [[:component]] [[component:]]form_input::id=fk_unidades&tipo=selecdb&tam=&clase=s1&validate=numerico required &eventos= onkeypress=\' return soloNum(event,this);\' [[:component]] [[component:]]form_input::id=costo&tipo=float&tam=&clase=s4&decimal=2&validate=numerico required &eventos= onkeypress=\' return soloNum(event,this);\'  onblur=\' _refreshFloat(this);\' [[:component]] [[component:]]form_input::id=tipodoc&tipo=selec&tam=&clase=s4&validate=[[:component]] [[component:]]form_input::id=nfac&tipo=alfa&tam=&clase=s4&validate=[[:component]] [[component:]]form_input::id=serial&tipo=alfa&tam=&clase=s6&validate=[[:component]] [[component:]]form_input::id=fecven&tipo=date&tam=&clase=s6&validate=[[:component]] [[component:]]form_input::id=fk_resp&tipo=join&tam=&clase=s12&validate=numerico required &eventos= onkeypress=\' return soloNum(event,this);\' [[:component]] <br>---Renderizado Componente: formulario<hr>nuevos componentes<hr><pre>Array
(
    [form_input] => Array
        (
            [0] => id=fecha&tipo=date&tam=&clase=s3&validate= required 
            [1] => id=pk&tipo=oculto&tam=&clase=s12&validate=numerico&eventos= onkeypress=\' return soloNum(event,this);\' 
            [2] => id=tipo&tipo=selec&tam=&clase=s3&validate=
            [3] => id=fk_almacenes&tipo=selecdb&tam=&clase=s6&validate=numerico required &eventos= onkeypress=\' return soloNum(event,this);\' 
            [4] => id=fk_prod&tipo=buscardb&tam=&clase=s9&validate=numerico required &eventos= onkeypress=\' return soloNum(event,this);\'  onblur=\'onChangeProd(); _buscarNomDb(this);\' 
            [5] => id=cant&tipo=float&tam=&clase=s2&decimal=2&validate=numerico required &eventos= onkeypress=\' return soloNum(event,this);\'  onblur=\' _refreshFloat(this);\' 
            [6] => id=fk_unidades&tipo=selecdb&tam=&clase=s1&validate=numerico required &eventos= onkeypress=\' return soloNum(event,this);\' 
            [7] => id=costo&tipo=float&tam=&clase=s4&decimal=2&validate=numerico required &eventos= onkeypress=\' return soloNum(event,this);\'  onblur=\' _refreshFloat(this);\' 
            [8] => id=tipodoc&tipo=selec&tam=&clase=s4&validate=
            [9] => id=nfac&tipo=alfa&tam=&clase=s4&validate=
            [10] => id=serial&tipo=alfa&tam=&clase=s6&validate=
            [11] => id=fecven&tipo=date&tam=&clase=s6&validate=
            [12] => id=fk_resp&tipo=join&tam=&clase=s12&validate=numerico required &eventos= onkeypress=\' return soloNum(event,this);\' 
        )

)
</pre><br>Se copia el archivo para el componente:sort.png<br>Se copia el archivo para el componente:sort_asc.png<br>Se copia el archivo para el componente:sort_desc.png<br>code unique
{% php if ($_action=='ver'){  $clasver='ver';}else{  $clasver='';} %} POsicion: 1362<br>Procesado el Componente: form_input<strong style="color:red"><hr>Copilacion de: <hr>

{% echo  str_replace('form-config-section componente','',$campos[fecha][i_pre]);  %}

{% if '[[var:]]unico[[:var]]'=='1' %}

[% append js.inline %]
var old_fecha='[% echo [[]]item[fecha]; %]';
function isUnique_fecha(){
	var dato=[[]]('#fecha').val();
	if (dato==''){
		[[]]('.btnPrevAjax').show();
		return true;
	}
	if (dato!=old_fecha){
		[[]]('.btnPrevAjax').hide();
		dataUnique([[]]('#[[var:]]primary[[:var]]').val(),'fecha',dato,function(msg){
			if (msg!='0'){
				alertfocus('Ese [% echo [[]]anexos[fecha][labelf] %] ya existe!!!','#fecha')
			}else{
				old_fecha=dato;
				[[]]('.btnPrevAjax').show();
			}
		});
	}
}
[% /append %]


{% /if %}

 

{% php if (('date'=='selec')||('date'=='selecdb')||('date'=='selecdbgrupo')) { $tipoinput='selec';}else{ $tipoinput='date';} %}


{% echo '[[component:]]form_input.'.$tipoinput.'::id=fecha&tipo=date&tam=&clase=s3&unico=[[var:]]unico[[:var]]&dataon=[[var:]]dataon[[:var]]&decimal=[[var:]]decimal[[:var]]&validate= required &primary=[[var:]]primary[[:var]]&readonly=[[var:]]readonly[[:var]]&eventos=[[var:]]eventos[[:var]][[:component]]'; %}

{% echo $campos[fecha][i_pos] %}
<hr><hr></strong><strong style="color:blue"><hr>Copilacion de: <hr>

<div class="row  i_c-section bindered" id="c-section-0" data-campo="c-section-0" data-type="c-section"> <div class="dropin row               ">



 




[[component:]]form_input.date::id=fecha&tipo=date&tam=&clase=s3&unico=[[var:]]unico[[:var]]&dataon=[[var:]]dataon[[:var]]&decimal=[[var:]]decimal[[:var]]&validate= required &primary=[[var:]]primary[[:var]]&readonly=[[var:]]readonly[[:var]]&eventos=[[var:]]eventos[[:var]][[:component]]


<hr><hr></strong><br><span style='color:red;'><code>

<div class="row  i_c-section bindered" id="c-section-0" data-campo="c-section-0" data-type="c-section"> <div class="dropin row               ">



 




[[component:]]form_input.date::id=fecha&tipo=date&tam=&clase=s3&unico=[[var:]]unico[[:var]]&dataon=[[var:]]dataon[[:var]]&decimal=[[var:]]decimal[[:var]]&validate= required &primary=[[var:]]primary[[:var]]&readonly=[[var:]]readonly[[:var]]&eventos=[[var:]]eventos[[:var]][[:component]]


</code> Compilado </span><br>---Renderizado Componente: form_input::id=fecha&tipo=date&tam=&clase=s3&validate= required <strong style="color:red"><hr>Copilacion de: <hr>

{% echo  str_replace('form-config-section componente','',$campos[pk][i_pre]);  %}

{% if '[[var:]]unico[[:var]]'=='1' %}

[% append js.inline %]
var old_pk='[% echo [[]]item[pk]; %]';
function isUnique_pk(){
	var dato=[[]]('#pk').val();
	if (dato==''){
		[[]]('.btnPrevAjax').show();
		return true;
	}
	if (dato!=old_pk){
		[[]]('.btnPrevAjax').hide();
		dataUnique([[]]('#[[var:]]primary[[:var]]').val(),'pk',dato,function(msg){
			if (msg!='0'){
				alertfocus('Ese [% echo [[]]anexos[pk][labelf] %] ya existe!!!','#pk')
			}else{
				old_pk=dato;
				[[]]('.btnPrevAjax').show();
			}
		});
	}
}
[% /append %]


{% /if %}

 

{% php if (('oculto'=='selec')||('oculto'=='selecdb')||('oculto'=='selecdbgrupo')) { $tipoinput='selec';}else{ $tipoinput='oculto';} %}


{% echo '[[component:]]form_input.'.$tipoinput.'::id=pk&tipo=oculto&tam=&clase=s12&unico=[[var:]]unico[[:var]]&dataon=[[var:]]dataon[[:var]]&decimal=[[var:]]decimal[[:var]]&validate=numerico&primary=[[var:]]primary[[:var]]&readonly=[[var:]]readonly[[:var]]&eventos= onkeypress=\' return soloNum(event,this);\' [[:component]]'; %}

{% echo $campos[pk][i_pos] %}
<hr><hr></strong><strong style="color:blue"><hr>Copilacion de: <hr>





 




[[component:]]form_input.oculto::id=pk&tipo=oculto&tam=&clase=s12&unico=[[var:]]unico[[:var]]&dataon=[[var:]]dataon[[:var]]&decimal=[[var:]]decimal[[:var]]&validate=numerico&primary=[[var:]]primary[[:var]]&readonly=[[var:]]readonly[[:var]]&eventos= onkeypress=' return soloNum(event,this);' [[:component]]


<hr><hr></strong><br><span style='color:red;'><code>





 




[[component:]]form_input.oculto::id=pk&tipo=oculto&tam=&clase=s12&unico=[[var:]]unico[[:var]]&dataon=[[var:]]dataon[[:var]]&decimal=[[var:]]decimal[[:var]]&validate=numerico&primary=[[var:]]primary[[:var]]&readonly=[[var:]]readonly[[:var]]&eventos= onkeypress=' return soloNum(event,this);' [[:component]]


</code> Compilado </span><br>---Renderizado Componente: form_input::id=pk&tipo=oculto&tam=&clase=s12&validate=numerico&eventos= onkeypress=\' return soloNum(event,this);\' <strong style="color:red"><hr>Copilacion de: <hr>

{% echo  str_replace('form-config-section componente','',$campos[tipo][i_pre]);  %}

{% if '[[var:]]unico[[:var]]'=='1' %}

[% append js.inline %]
var old_tipo='[% echo [[]]item[tipo]; %]';
function isUnique_tipo(){
	var dato=[[]]('#tipo').val();
	if (dato==''){
		[[]]('.btnPrevAjax').show();
		return true;
	}
	if (dato!=old_tipo){
		[[]]('.btnPrevAjax').hide();
		dataUnique([[]]('#[[var:]]primary[[:var]]').val(),'tipo',dato,function(msg){
			if (msg!='0'){
				alertfocus('Ese [% echo [[]]anexos[tipo][labelf] %] ya existe!!!','#tipo')
			}else{
				old_tipo=dato;
				[[]]('.btnPrevAjax').show();
			}
		});
	}
}
[% /append %]


{% /if %}

 

{% php if (('selec'=='selec')||('selec'=='selecdb')||('selec'=='selecdbgrupo')) { $tipoinput='selec';}else{ $tipoinput='selec';} %}


{% echo '[[component:]]form_input.'.$tipoinput.'::id=tipo&tipo=selec&tam=&clase=s3&unico=[[var:]]unico[[:var]]&dataon=[[var:]]dataon[[:var]]&decimal=[[var:]]decimal[[:var]]&validate=&primary=[[var:]]primary[[:var]]&readonly=[[var:]]readonly[[:var]]&eventos=[[var:]]eventos[[:var]][[:component]]'; %}

{% echo $campos[tipo][i_pos] %}
<hr><hr></strong><strong style="color:blue"><hr>Copilacion de: <hr>





 




[[component:]]form_input.selec::id=tipo&tipo=selec&tam=&clase=s3&unico=[[var:]]unico[[:var]]&dataon=[[var:]]dataon[[:var]]&decimal=[[var:]]decimal[[:var]]&validate=&primary=[[var:]]primary[[:var]]&readonly=[[var:]]readonly[[:var]]&eventos=[[var:]]eventos[[:var]][[:component]]


<hr><hr></strong><br><span style='color:red;'><code>





 




[[component:]]form_input.selec::id=tipo&tipo=selec&tam=&clase=s3&unico=[[var:]]unico[[:var]]&dataon=[[var:]]dataon[[:var]]&decimal=[[var:]]decimal[[:var]]&validate=&primary=[[var:]]primary[[:var]]&readonly=[[var:]]readonly[[:var]]&eventos=[[var:]]eventos[[:var]][[:component]]


</code> Compilado </span><br>---Renderizado Componente: form_input::id=tipo&tipo=selec&tam=&clase=s3&validate=<strong style="color:red"><hr>Copilacion de: <hr>

{% echo  str_replace('form-config-section componente','',$campos[fk_almacenes][i_pre]);  %}

{% if '[[var:]]unico[[:var]]'=='1' %}

[% append js.inline %]
var old_fk_almacenes='[% echo [[]]item[fk_almacenes]; %]';
function isUnique_fk_almacenes(){
	var dato=[[]]('#fk_almacenes').val();
	if (dato==''){
		[[]]('.btnPrevAjax').show();
		return true;
	}
	if (dato!=old_fk_almacenes){
		[[]]('.btnPrevAjax').hide();
		dataUnique([[]]('#[[var:]]primary[[:var]]').val(),'fk_almacenes',dato,function(msg){
			if (msg!='0'){
				alertfocus('Ese [% echo [[]]anexos[fk_almacenes][labelf] %] ya existe!!!','#fk_almacenes')
			}else{
				old_fk_almacenes=dato;
				[[]]('.btnPrevAjax').show();
			}
		});
	}
}
[% /append %]


{% /if %}

 

{% php if (('selecdb'=='selec')||('selecdb'=='selecdb')||('selecdb'=='selecdbgrupo')) { $tipoinput='selec';}else{ $tipoinput='selecdb';} %}


{% echo '[[component:]]form_input.'.$tipoinput.'::id=fk_almacenes&tipo=selecdb&tam=&clase=s6&unico=[[var:]]unico[[:var]]&dataon=[[var:]]dataon[[:var]]&decimal=[[var:]]decimal[[:var]]&validate=numerico required &primary=[[var:]]primary[[:var]]&readonly=[[var:]]readonly[[:var]]&eventos= onkeypress=\' return soloNum(event,this);\' [[:component]]'; %}

{% echo $campos[fk_almacenes][i_pos] %}
<hr><hr></strong><strong style="color:blue"><hr>Copilacion de: <hr>





 




[[component:]]form_input.selec::id=fk_almacenes&tipo=selecdb&tam=&clase=s6&unico=[[var:]]unico[[:var]]&dataon=[[var:]]dataon[[:var]]&decimal=[[var:]]decimal[[:var]]&validate=numerico required &primary=[[var:]]primary[[:var]]&readonly=[[var:]]readonly[[:var]]&eventos= onkeypress=' return soloNum(event,this);' [[:component]]


<hr><hr></strong><br><span style='color:red;'><code>





 




[[component:]]form_input.selec::id=fk_almacenes&tipo=selecdb&tam=&clase=s6&unico=[[var:]]unico[[:var]]&dataon=[[var:]]dataon[[:var]]&decimal=[[var:]]decimal[[:var]]&validate=numerico required &primary=[[var:]]primary[[:var]]&readonly=[[var:]]readonly[[:var]]&eventos= onkeypress=' return soloNum(event,this);' [[:component]]


</code> Compilado </span><br>---Renderizado Componente: form_input::id=fk_almacenes&tipo=selecdb&tam=&clase=s6&validate=numerico required &eventos= onkeypress=\' return soloNum(event,this);\' <strong style="color:red"><hr>Copilacion de: <hr>

{% echo  str_replace('form-config-section componente','',$campos[fk_prod][i_pre]);  %}

{% if '[[var:]]unico[[:var]]'=='1' %}

[% append js.inline %]
var old_fk_prod='[% echo [[]]item[fk_prod]; %]';
function isUnique_fk_prod(){
	var dato=[[]]('#fk_prod').val();
	if (dato==''){
		[[]]('.btnPrevAjax').show();
		return true;
	}
	if (dato!=old_fk_prod){
		[[]]('.btnPrevAjax').hide();
		dataUnique([[]]('#[[var:]]primary[[:var]]').val(),'fk_prod',dato,function(msg){
			if (msg!='0'){
				alertfocus('Ese [% echo [[]]anexos[fk_prod][labelf] %] ya existe!!!','#fk_prod')
			}else{
				old_fk_prod=dato;
				[[]]('.btnPrevAjax').show();
			}
		});
	}
}
[% /append %]


{% /if %}

 

{% php if (('buscardb'=='selec')||('buscardb'=='selecdb')||('buscardb'=='selecdbgrupo')) { $tipoinput='selec';}else{ $tipoinput='buscardb';} %}


{% echo '[[component:]]form_input.'.$tipoinput.'::id=fk_prod&tipo=buscardb&tam=&clase=s9&unico=[[var:]]unico[[:var]]&dataon=[[var:]]dataon[[:var]]&decimal=[[var:]]decimal[[:var]]&validate=numerico required &primary=[[var:]]primary[[:var]]&readonly=[[var:]]readonly[[:var]]&eventos= onkeypress=\' return soloNum(event,this);\'  onblur=\'onChangeProd(); _buscarNomDb(this);\' [[:component]]'; %}

{% echo $campos[fk_prod][i_pos] %}
<hr><hr></strong><strong style="color:blue"><hr>Copilacion de: <hr>





 




[[component:]]form_input.buscardb::id=fk_prod&tipo=buscardb&tam=&clase=s9&unico=[[var:]]unico[[:var]]&dataon=[[var:]]dataon[[:var]]&decimal=[[var:]]decimal[[:var]]&validate=numerico required &primary=[[var:]]primary[[:var]]&readonly=[[var:]]readonly[[:var]]&eventos= onkeypress=' return soloNum(event,this);'  onblur='onChangeProd(); _buscarNomDb(this);' [[:component]]


<hr><hr></strong><br><span style='color:red;'><code>





 




[[component:]]form_input.buscardb::id=fk_prod&tipo=buscardb&tam=&clase=s9&unico=[[var:]]unico[[:var]]&dataon=[[var:]]dataon[[:var]]&decimal=[[var:]]decimal[[:var]]&validate=numerico required &primary=[[var:]]primary[[:var]]&readonly=[[var:]]readonly[[:var]]&eventos= onkeypress=' return soloNum(event,this);'  onblur='onChangeProd(); _buscarNomDb(this);' [[:component]]


</code> Compilado </span><br>---Renderizado Componente: form_input::id=fk_prod&tipo=buscardb&tam=&clase=s9&validate=numerico required &eventos= onkeypress=\' return soloNum(event,this);\'  onblur=\'onChangeProd(); _buscarNomDb(this);\' <strong style="color:red"><hr>Copilacion de: <hr>

{% echo  str_replace('form-config-section componente','',$campos[cant][i_pre]);  %}

{% if '[[var:]]unico[[:var]]'=='1' %}

[% append js.inline %]
var old_cant='[% echo [[]]item[cant]; %]';
function isUnique_cant(){
	var dato=[[]]('#cant').val();
	if (dato==''){
		[[]]('.btnPrevAjax').show();
		return true;
	}
	if (dato!=old_cant){
		[[]]('.btnPrevAjax').hide();
		dataUnique([[]]('#[[var:]]primary[[:var]]').val(),'cant',dato,function(msg){
			if (msg!='0'){
				alertfocus('Ese [% echo [[]]anexos[cant][labelf] %] ya existe!!!','#cant')
			}else{
				old_cant=dato;
				[[]]('.btnPrevAjax').show();
			}
		});
	}
}
[% /append %]


{% /if %}

 

{% php if (('float'=='selec')||('float'=='selecdb')||('float'=='selecdbgrupo')) { $tipoinput='selec';}else{ $tipoinput='float';} %}


{% echo '[[component:]]form_input.'.$tipoinput.'::id=cant&tipo=float&tam=&clase=s2&unico=[[var:]]unico[[:var]]&dataon=[[var:]]dataon[[:var]]&decimal=2&validate=numerico required &primary=[[var:]]primary[[:var]]&readonly=[[var:]]readonly[[:var]]&eventos= onkeypress=\' return soloNum(event,this);\'  onblur=\' _refreshFloat(this);\' [[:component]]'; %}

{% echo $campos[cant][i_pos] %}
<hr><hr></strong><strong style="color:blue"><hr>Copilacion de: <hr>





 




[[component:]]form_input.float::id=cant&tipo=float&tam=&clase=s2&unico=[[var:]]unico[[:var]]&dataon=[[var:]]dataon[[:var]]&decimal=2&validate=numerico required &primary=[[var:]]primary[[:var]]&readonly=[[var:]]readonly[[:var]]&eventos= onkeypress=' return soloNum(event,this);'  onblur=' _refreshFloat(this);' [[:component]]


<hr><hr></strong><br><span style='color:red;'><code>





 




[[component:]]form_input.float::id=cant&tipo=float&tam=&clase=s2&unico=[[var:]]unico[[:var]]&dataon=[[var:]]dataon[[:var]]&decimal=2&validate=numerico required &primary=[[var:]]primary[[:var]]&readonly=[[var:]]readonly[[:var]]&eventos= onkeypress=' return soloNum(event,this);'  onblur=' _refreshFloat(this);' [[:component]]


</code> Compilado </span><br>---Renderizado Componente: form_input::id=cant&tipo=float&tam=&clase=s2&decimal=2&validate=numerico required &eventos= onkeypress=\' return soloNum(event,this);\'  onblur=\' _refreshFloat(this);\' <strong style="color:red"><hr>Copilacion de: <hr>

{% echo  str_replace('form-config-section componente','',$campos[fk_unidades][i_pre]);  %}

{% if '[[var:]]unico[[:var]]'=='1' %}

[% append js.inline %]
var old_fk_unidades='[% echo [[]]item[fk_unidades]; %]';
function isUnique_fk_unidades(){
	var dato=[[]]('#fk_unidades').val();
	if (dato==''){
		[[]]('.btnPrevAjax').show();
		return true;
	}
	if (dato!=old_fk_unidades){
		[[]]('.btnPrevAjax').hide();
		dataUnique([[]]('#[[var:]]primary[[:var]]').val(),'fk_unidades',dato,function(msg){
			if (msg!='0'){
				alertfocus('Ese [% echo [[]]anexos[fk_unidades][labelf] %] ya existe!!!','#fk_unidades')
			}else{
				old_fk_unidades=dato;
				[[]]('.btnPrevAjax').show();
			}
		});
	}
}
[% /append %]


{% /if %}

 

{% php if (('selecdb'=='selec')||('selecdb'=='selecdb')||('selecdb'=='selecdbgrupo')) { $tipoinput='selec';}else{ $tipoinput='selecdb';} %}


{% echo '[[component:]]form_input.'.$tipoinput.'::id=fk_unidades&tipo=selecdb&tam=&clase=s1&unico=[[var:]]unico[[:var]]&dataon=[[var:]]dataon[[:var]]&decimal=[[var:]]decimal[[:var]]&validate=numerico required &primary=[[var:]]primary[[:var]]&readonly=[[var:]]readonly[[:var]]&eventos= onkeypress=\' return soloNum(event,this);\' [[:component]]'; %}

{% echo $campos[fk_unidades][i_pos] %}
<hr><hr></strong><strong style="color:blue"><hr>Copilacion de: <hr>





 




[[component:]]form_input.selec::id=fk_unidades&tipo=selecdb&tam=&clase=s1&unico=[[var:]]unico[[:var]]&dataon=[[var:]]dataon[[:var]]&decimal=[[var:]]decimal[[:var]]&validate=numerico required &primary=[[var:]]primary[[:var]]&readonly=[[var:]]readonly[[:var]]&eventos= onkeypress=' return soloNum(event,this);' [[:component]]


<hr><hr></strong><br><span style='color:red;'><code>





 




[[component:]]form_input.selec::id=fk_unidades&tipo=selecdb&tam=&clase=s1&unico=[[var:]]unico[[:var]]&dataon=[[var:]]dataon[[:var]]&decimal=[[var:]]decimal[[:var]]&validate=numerico required &primary=[[var:]]primary[[:var]]&readonly=[[var:]]readonly[[:var]]&eventos= onkeypress=' return soloNum(event,this);' [[:component]]


</code> Compilado </span><br>---Renderizado Componente: form_input::id=fk_unidades&tipo=selecdb&tam=&clase=s1&validate=numerico required &eventos= onkeypress=\' return soloNum(event,this);\' <strong style="color:red"><hr>Copilacion de: <hr>

{% echo  str_replace('form-config-section componente','',$campos[costo][i_pre]);  %}

{% if '[[var:]]unico[[:var]]'=='1' %}

[% append js.inline %]
var old_costo='[% echo [[]]item[costo]; %]';
function isUnique_costo(){
	var dato=[[]]('#costo').val();
	if (dato==''){
		[[]]('.btnPrevAjax').show();
		return true;
	}
	if (dato!=old_costo){
		[[]]('.btnPrevAjax').hide();
		dataUnique([[]]('#[[var:]]primary[[:var]]').val(),'costo',dato,function(msg){
			if (msg!='0'){
				alertfocus('Ese [% echo [[]]anexos[costo][labelf] %] ya existe!!!','#costo')
			}else{
				old_costo=dato;
				[[]]('.btnPrevAjax').show();
			}
		});
	}
}
[% /append %]


{% /if %}

 

{% php if (('float'=='selec')||('float'=='selecdb')||('float'=='selecdbgrupo')) { $tipoinput='selec';}else{ $tipoinput='float';} %}


{% echo '[[component:]]form_input.'.$tipoinput.'::id=costo&tipo=float&tam=&clase=s4&unico=[[var:]]unico[[:var]]&dataon=[[var:]]dataon[[:var]]&decimal=2&validate=numerico required &primary=[[var:]]primary[[:var]]&readonly=[[var:]]readonly[[:var]]&eventos= onkeypress=\' return soloNum(event,this);\'  onblur=\' _refreshFloat(this);\' [[:component]]'; %}

{% echo $campos[costo][i_pos] %}
<hr><hr></strong><strong style="color:blue"><hr>Copilacion de: <hr>





 




[[component:]]form_input.float::id=costo&tipo=float&tam=&clase=s4&unico=[[var:]]unico[[:var]]&dataon=[[var:]]dataon[[:var]]&decimal=2&validate=numerico required &primary=[[var:]]primary[[:var]]&readonly=[[var:]]readonly[[:var]]&eventos= onkeypress=' return soloNum(event,this);'  onblur=' _refreshFloat(this);' [[:component]]


<hr><hr></strong><br><span style='color:red;'><code>





 




[[component:]]form_input.float::id=costo&tipo=float&tam=&clase=s4&unico=[[var:]]unico[[:var]]&dataon=[[var:]]dataon[[:var]]&decimal=2&validate=numerico required &primary=[[var:]]primary[[:var]]&readonly=[[var:]]readonly[[:var]]&eventos= onkeypress=' return soloNum(event,this);'  onblur=' _refreshFloat(this);' [[:component]]


</code> Compilado </span><br>---Renderizado Componente: form_input::id=costo&tipo=float&tam=&clase=s4&decimal=2&validate=numerico required &eventos= onkeypress=\' return soloNum(event,this);\'  onblur=\' _refreshFloat(this);\' <strong style="color:red"><hr>Copilacion de: <hr>

{% echo  str_replace('form-config-section componente','',$campos[tipodoc][i_pre]);  %}

{% if '[[var:]]unico[[:var]]'=='1' %}

[% append js.inline %]
var old_tipodoc='[% echo [[]]item[tipodoc]; %]';
function isUnique_tipodoc(){
	var dato=[[]]('#tipodoc').val();
	if (dato==''){
		[[]]('.btnPrevAjax').show();
		return true;
	}
	if (dato!=old_tipodoc){
		[[]]('.btnPrevAjax').hide();
		dataUnique([[]]('#[[var:]]primary[[:var]]').val(),'tipodoc',dato,function(msg){
			if (msg!='0'){
				alertfocus('Ese [% echo [[]]anexos[tipodoc][labelf] %] ya existe!!!','#tipodoc')
			}else{
				old_tipodoc=dato;
				[[]]('.btnPrevAjax').show();
			}
		});
	}
}
[% /append %]


{% /if %}

 

{% php if (('selec'=='selec')||('selec'=='selecdb')||('selec'=='selecdbgrupo')) { $tipoinput='selec';}else{ $tipoinput='selec';} %}


{% echo '[[component:]]form_input.'.$tipoinput.'::id=tipodoc&tipo=selec&tam=&clase=s4&unico=[[var:]]unico[[:var]]&dataon=[[var:]]dataon[[:var]]&decimal=[[var:]]decimal[[:var]]&validate=&primary=[[var:]]primary[[:var]]&readonly=[[var:]]readonly[[:var]]&eventos=[[var:]]eventos[[:var]][[:component]]'; %}

{% echo $campos[tipodoc][i_pos] %}
<hr><hr></strong><strong style="color:blue"><hr>Copilacion de: <hr>





 




[[component:]]form_input.selec::id=tipodoc&tipo=selec&tam=&clase=s4&unico=[[var:]]unico[[:var]]&dataon=[[var:]]dataon[[:var]]&decimal=[[var:]]decimal[[:var]]&validate=&primary=[[var:]]primary[[:var]]&readonly=[[var:]]readonly[[:var]]&eventos=[[var:]]eventos[[:var]][[:component]]


<hr><hr></strong><br><span style='color:red;'><code>





 




[[component:]]form_input.selec::id=tipodoc&tipo=selec&tam=&clase=s4&unico=[[var:]]unico[[:var]]&dataon=[[var:]]dataon[[:var]]&decimal=[[var:]]decimal[[:var]]&validate=&primary=[[var:]]primary[[:var]]&readonly=[[var:]]readonly[[:var]]&eventos=[[var:]]eventos[[:var]][[:component]]


</code> Compilado </span><br>---Renderizado Componente: form_input::id=tipodoc&tipo=selec&tam=&clase=s4&validate=<strong style="color:red"><hr>Copilacion de: <hr>

{% echo  str_replace('form-config-section componente','',$campos[nfac][i_pre]);  %}

{% if '[[var:]]unico[[:var]]'=='1' %}

[% append js.inline %]
var old_nfac='[% echo [[]]item[nfac]; %]';
function isUnique_nfac(){
	var dato=[[]]('#nfac').val();
	if (dato==''){
		[[]]('.btnPrevAjax').show();
		return true;
	}
	if (dato!=old_nfac){
		[[]]('.btnPrevAjax').hide();
		dataUnique([[]]('#[[var:]]primary[[:var]]').val(),'nfac',dato,function(msg){
			if (msg!='0'){
				alertfocus('Ese [% echo [[]]anexos[nfac][labelf] %] ya existe!!!','#nfac')
			}else{
				old_nfac=dato;
				[[]]('.btnPrevAjax').show();
			}
		});
	}
}
[% /append %]


{% /if %}

 

{% php if (('alfa'=='selec')||('alfa'=='selecdb')||('alfa'=='selecdbgrupo')) { $tipoinput='selec';}else{ $tipoinput='alfa';} %}


{% echo '[[component:]]form_input.'.$tipoinput.'::id=nfac&tipo=alfa&tam=&clase=s4&unico=[[var:]]unico[[:var]]&dataon=[[var:]]dataon[[:var]]&decimal=[[var:]]decimal[[:var]]&validate=&primary=[[var:]]primary[[:var]]&readonly=[[var:]]readonly[[:var]]&eventos=[[var:]]eventos[[:var]][[:component]]'; %}

{% echo $campos[nfac][i_pos] %}
<hr><hr></strong><strong style="color:blue"><hr>Copilacion de: <hr>





 




[[component:]]form_input.alfa::id=nfac&tipo=alfa&tam=&clase=s4&unico=[[var:]]unico[[:var]]&dataon=[[var:]]dataon[[:var]]&decimal=[[var:]]decimal[[:var]]&validate=&primary=[[var:]]primary[[:var]]&readonly=[[var:]]readonly[[:var]]&eventos=[[var:]]eventos[[:var]][[:component]]


<hr><hr></strong><br><span style='color:red;'><code>





 




[[component:]]form_input.alfa::id=nfac&tipo=alfa&tam=&clase=s4&unico=[[var:]]unico[[:var]]&dataon=[[var:]]dataon[[:var]]&decimal=[[var:]]decimal[[:var]]&validate=&primary=[[var:]]primary[[:var]]&readonly=[[var:]]readonly[[:var]]&eventos=[[var:]]eventos[[:var]][[:component]]


</code> Compilado </span><br>---Renderizado Componente: form_input::id=nfac&tipo=alfa&tam=&clase=s4&validate=<strong style="color:red"><hr>Copilacion de: <hr>

{% echo  str_replace('form-config-section componente','',$campos[serial][i_pre]);  %}

{% if '[[var:]]unico[[:var]]'=='1' %}

[% append js.inline %]
var old_serial='[% echo [[]]item[serial]; %]';
function isUnique_serial(){
	var dato=[[]]('#serial').val();
	if (dato==''){
		[[]]('.btnPrevAjax').show();
		return true;
	}
	if (dato!=old_serial){
		[[]]('.btnPrevAjax').hide();
		dataUnique([[]]('#[[var:]]primary[[:var]]').val(),'serial',dato,function(msg){
			if (msg!='0'){
				alertfocus('Ese [% echo [[]]anexos[serial][labelf] %] ya existe!!!','#serial')
			}else{
				old_serial=dato;
				[[]]('.btnPrevAjax').show();
			}
		});
	}
}
[% /append %]


{% /if %}

 

{% php if (('alfa'=='selec')||('alfa'=='selecdb')||('alfa'=='selecdbgrupo')) { $tipoinput='selec';}else{ $tipoinput='alfa';} %}


{% echo '[[component:]]form_input.'.$tipoinput.'::id=serial&tipo=alfa&tam=&clase=s6&unico=[[var:]]unico[[:var]]&dataon=[[var:]]dataon[[:var]]&decimal=[[var:]]decimal[[:var]]&validate=&primary=[[var:]]primary[[:var]]&readonly=[[var:]]readonly[[:var]]&eventos=[[var:]]eventos[[:var]][[:component]]'; %}

{% echo $campos[serial][i_pos] %}
<hr><hr></strong><strong style="color:blue"><hr>Copilacion de: <hr>





 




[[component:]]form_input.alfa::id=serial&tipo=alfa&tam=&clase=s6&unico=[[var:]]unico[[:var]]&dataon=[[var:]]dataon[[:var]]&decimal=[[var:]]decimal[[:var]]&validate=&primary=[[var:]]primary[[:var]]&readonly=[[var:]]readonly[[:var]]&eventos=[[var:]]eventos[[:var]][[:component]]


<hr><hr></strong><br><span style='color:red;'><code>





 




[[component:]]form_input.alfa::id=serial&tipo=alfa&tam=&clase=s6&unico=[[var:]]unico[[:var]]&dataon=[[var:]]dataon[[:var]]&decimal=[[var:]]decimal[[:var]]&validate=&primary=[[var:]]primary[[:var]]&readonly=[[var:]]readonly[[:var]]&eventos=[[var:]]eventos[[:var]][[:component]]


</code> Compilado </span><br>---Renderizado Componente: form_input::id=serial&tipo=alfa&tam=&clase=s6&validate=<strong style="color:red"><hr>Copilacion de: <hr>

{% echo  str_replace('form-config-section componente','',$campos[fecven][i_pre]);  %}

{% if '[[var:]]unico[[:var]]'=='1' %}

[% append js.inline %]
var old_fecven='[% echo [[]]item[fecven]; %]';
function isUnique_fecven(){
	var dato=[[]]('#fecven').val();
	if (dato==''){
		[[]]('.btnPrevAjax').show();
		return true;
	}
	if (dato!=old_fecven){
		[[]]('.btnPrevAjax').hide();
		dataUnique([[]]('#[[var:]]primary[[:var]]').val(),'fecven',dato,function(msg){
			if (msg!='0'){
				alertfocus('Ese [% echo [[]]anexos[fecven][labelf] %] ya existe!!!','#fecven')
			}else{
				old_fecven=dato;
				[[]]('.btnPrevAjax').show();
			}
		});
	}
}
[% /append %]


{% /if %}

 

{% php if (('date'=='selec')||('date'=='selecdb')||('date'=='selecdbgrupo')) { $tipoinput='selec';}else{ $tipoinput='date';} %}


{% echo '[[component:]]form_input.'.$tipoinput.'::id=fecven&tipo=date&tam=&clase=s6&unico=[[var:]]unico[[:var]]&dataon=[[var:]]dataon[[:var]]&decimal=[[var:]]decimal[[:var]]&validate=&primary=[[var:]]primary[[:var]]&readonly=[[var:]]readonly[[:var]]&eventos=[[var:]]eventos[[:var]][[:component]]'; %}

{% echo $campos[fecven][i_pos] %}
<hr><hr></strong><strong style="color:blue"><hr>Copilacion de: <hr>





 




[[component:]]form_input.date::id=fecven&tipo=date&tam=&clase=s6&unico=[[var:]]unico[[:var]]&dataon=[[var:]]dataon[[:var]]&decimal=[[var:]]decimal[[:var]]&validate=&primary=[[var:]]primary[[:var]]&readonly=[[var:]]readonly[[:var]]&eventos=[[var:]]eventos[[:var]][[:component]]


<hr><hr></strong><br><span style='color:red;'><code>





 




[[component:]]form_input.date::id=fecven&tipo=date&tam=&clase=s6&unico=[[var:]]unico[[:var]]&dataon=[[var:]]dataon[[:var]]&decimal=[[var:]]decimal[[:var]]&validate=&primary=[[var:]]primary[[:var]]&readonly=[[var:]]readonly[[:var]]&eventos=[[var:]]eventos[[:var]][[:component]]


</code> Compilado </span><br>---Renderizado Componente: form_input::id=fecven&tipo=date&tam=&clase=s6&validate=<strong style="color:red"><hr>Copilacion de: <hr>

{% echo  str_replace('form-config-section componente','',$campos[fk_resp][i_pre]);  %}

{% if '[[var:]]unico[[:var]]'=='1' %}

[% append js.inline %]
var old_fk_resp='[% echo [[]]item[fk_resp]; %]';
function isUnique_fk_resp(){
	var dato=[[]]('#fk_resp').val();
	if (dato==''){
		[[]]('.btnPrevAjax').show();
		return true;
	}
	if (dato!=old_fk_resp){
		[[]]('.btnPrevAjax').hide();
		dataUnique([[]]('#[[var:]]primary[[:var]]').val(),'fk_resp',dato,function(msg){
			if (msg!='0'){
				alertfocus('Ese [% echo [[]]anexos[fk_resp][labelf] %] ya existe!!!','#fk_resp')
			}else{
				old_fk_resp=dato;
				[[]]('.btnPrevAjax').show();
			}
		});
	}
}
[% /append %]


{% /if %}

 

{% php if (('join'=='selec')||('join'=='selecdb')||('join'=='selecdbgrupo')) { $tipoinput='selec';}else{ $tipoinput='join';} %}


{% echo '[[component:]]form_input.'.$tipoinput.'::id=fk_resp&tipo=join&tam=&clase=s12&unico=[[var:]]unico[[:var]]&dataon=[[var:]]dataon[[:var]]&decimal=[[var:]]decimal[[:var]]&validate=numerico required &primary=[[var:]]primary[[:var]]&readonly=[[var:]]readonly[[:var]]&eventos= onkeypress=\' return soloNum(event,this);\' [[:component]]'; %}

{% echo $campos[fk_resp][i_pos] %}
<hr><hr></strong><strong style="color:blue"><hr>Copilacion de: <hr>





 




[[component:]]form_input.join::id=fk_resp&tipo=join&tam=&clase=s12&unico=[[var:]]unico[[:var]]&dataon=[[var:]]dataon[[:var]]&decimal=[[var:]]decimal[[:var]]&validate=numerico required &primary=[[var:]]primary[[:var]]&readonly=[[var:]]readonly[[:var]]&eventos= onkeypress=' return soloNum(event,this);' [[:component]]

</div></div>
<hr><hr></strong><br><span style='color:red;'><code>





 




[[component:]]form_input.join::id=fk_resp&tipo=join&tam=&clase=s12&unico=[[var:]]unico[[:var]]&dataon=[[var:]]dataon[[:var]]&decimal=[[var:]]decimal[[:var]]&validate=numerico required &primary=[[var:]]primary[[:var]]&readonly=[[var:]]readonly[[:var]]&eventos= onkeypress=' return soloNum(event,this);' [[:component]]

</div></div>
</code> Compilado </span><br>---Renderizado Componente: form_input::id=fk_resp&tipo=join&tam=&clase=s12&validate=numerico required &eventos= onkeypress=\' return soloNum(event,this);\' <hr>nuevos componentes<hr><pre>Array
(
    [form_input.date] => Array
        (
            [0] => id=fecha&tipo=date&tam=&clase=s3&unico=[[var:]]unico[[:var]]&dataon=[[var:]]dataon[[:var]]&decimal=[[var:]]decimal[[:var]]&validate= required &primary=[[var:]]primary[[:var]]&readonly=[[var:]]readonly[[:var]]&eventos=[[var:]]eventos[[:var]]
            [1] => id=fecven&tipo=date&tam=&clase=s6&unico=[[var:]]unico[[:var]]&dataon=[[var:]]dataon[[:var]]&decimal=[[var:]]decimal[[:var]]&validate=&primary=[[var:]]primary[[:var]]&readonly=[[var:]]readonly[[:var]]&eventos=[[var:]]eventos[[:var]]
        )

    [form_input.oculto] => Array
        (
            [0] => id=pk&tipo=oculto&tam=&clase=s12&unico=[[var:]]unico[[:var]]&dataon=[[var:]]dataon[[:var]]&decimal=[[var:]]decimal[[:var]]&validate=numerico&primary=[[var:]]primary[[:var]]&readonly=[[var:]]readonly[[:var]]&eventos= onkeypress=' return soloNum(event,this);' 
        )

    [form_input.selec] => Array
        (
            [0] => id=tipo&tipo=selec&tam=&clase=s3&unico=[[var:]]unico[[:var]]&dataon=[[var:]]dataon[[:var]]&decimal=[[var:]]decimal[[:var]]&validate=&primary=[[var:]]primary[[:var]]&readonly=[[var:]]readonly[[:var]]&eventos=[[var:]]eventos[[:var]]
            [1] => id=fk_almacenes&tipo=selecdb&tam=&clase=s6&unico=[[var:]]unico[[:var]]&dataon=[[var:]]dataon[[:var]]&decimal=[[var:]]decimal[[:var]]&validate=numerico required &primary=[[var:]]primary[[:var]]&readonly=[[var:]]readonly[[:var]]&eventos= onkeypress=' return soloNum(event,this);' 
            [2] => id=fk_unidades&tipo=selecdb&tam=&clase=s1&unico=[[var:]]unico[[:var]]&dataon=[[var:]]dataon[[:var]]&decimal=[[var:]]decimal[[:var]]&validate=numerico required &primary=[[var:]]primary[[:var]]&readonly=[[var:]]readonly[[:var]]&eventos= onkeypress=' return soloNum(event,this);' 
            [3] => id=tipodoc&tipo=selec&tam=&clase=s4&unico=[[var:]]unico[[:var]]&dataon=[[var:]]dataon[[:var]]&decimal=[[var:]]decimal[[:var]]&validate=&primary=[[var:]]primary[[:var]]&readonly=[[var:]]readonly[[:var]]&eventos=[[var:]]eventos[[:var]]
        )

    [form_input.buscardb] => Array
        (
            [0] => id=fk_prod&tipo=buscardb&tam=&clase=s9&unico=[[var:]]unico[[:var]]&dataon=[[var:]]dataon[[:var]]&decimal=[[var:]]decimal[[:var]]&validate=numerico required &primary=[[var:]]primary[[:var]]&readonly=[[var:]]readonly[[:var]]&eventos= onkeypress=' return soloNum(event,this);'  onblur='onChangeProd(); _buscarNomDb(this);' 
        )

    [form_input.float] => Array
        (
            [0] => id=cant&tipo=float&tam=&clase=s2&unico=[[var:]]unico[[:var]]&dataon=[[var:]]dataon[[:var]]&decimal=2&validate=numerico required &primary=[[var:]]primary[[:var]]&readonly=[[var:]]readonly[[:var]]&eventos= onkeypress=' return soloNum(event,this);'  onblur=' _refreshFloat(this);' 
            [1] => id=costo&tipo=float&tam=&clase=s4&unico=[[var:]]unico[[:var]]&dataon=[[var:]]dataon[[:var]]&decimal=2&validate=numerico required &primary=[[var:]]primary[[:var]]&readonly=[[var:]]readonly[[:var]]&eventos= onkeypress=' return soloNum(event,this);'  onblur=' _refreshFloat(this);' 
        )

    [form_input.alfa] => Array
        (
            [0] => id=nfac&tipo=alfa&tam=&clase=s4&unico=[[var:]]unico[[:var]]&dataon=[[var:]]dataon[[:var]]&decimal=[[var:]]decimal[[:var]]&validate=&primary=[[var:]]primary[[:var]]&readonly=[[var:]]readonly[[:var]]&eventos=[[var:]]eventos[[:var]]
            [1] => id=serial&tipo=alfa&tam=&clase=s6&unico=[[var:]]unico[[:var]]&dataon=[[var:]]dataon[[:var]]&decimal=[[var:]]decimal[[:var]]&validate=&primary=[[var:]]primary[[:var]]&readonly=[[var:]]readonly[[:var]]&eventos=[[var:]]eventos[[:var]]
        )

    [form_input.join] => Array
        (
            [0] => id=fk_resp&tipo=join&tam=&clase=s12&unico=[[var:]]unico[[:var]]&dataon=[[var:]]dataon[[:var]]&decimal=[[var:]]decimal[[:var]]&validate=numerico required &primary=[[var:]]primary[[:var]]&readonly=[[var:]]readonly[[:var]]&eventos= onkeypress=' return soloNum(event,this);' 
        )

)
</pre><br>code unique

{% append js.files %}
	<link href='js/datedropper/datedropper.css' rel='stylesheet'>
	<script type='text/javascript' src='js/datedropper/datedropper.js'></script>
{% /append %}

[[setvar: openform]]
	$('input.datafecha').dateDropper();
[[:setvar]]

 POsicion: <br>Procesado el Componente: date<br>---Renderizado Componente: form_input.date::id=fecha&tipo=date&tam=&clase=s3&unico=[[var:]]unico[[:var]]&dataon=[[var:]]dataon[[:var]]&decimal=[[var:]]decimal[[:var]]&validate= required &primary=[[var:]]primary[[:var]]&readonly=[[var:]]readonly[[:var]]&eventos=[[var:]]eventos[[:var]]<br>---Renderizado Componente: form_input.date::id=fecven&tipo=date&tam=&clase=s6&unico=[[var:]]unico[[:var]]&dataon=[[var:]]dataon[[:var]]&decimal=[[var:]]decimal[[:var]]&validate=&primary=[[var:]]primary[[:var]]&readonly=[[var:]]readonly[[:var]]&eventos=[[var:]]eventos[[:var]]<br>Procesado el Componente: oculto<br>---Renderizado Componente: form_input.oculto::id=pk&tipo=oculto&tam=&clase=s12&unico=[[var:]]unico[[:var]]&dataon=[[var:]]dataon[[:var]]&decimal=[[var:]]decimal[[:var]]&validate=numerico&primary=[[var:]]primary[[:var]]&readonly=[[var:]]readonly[[:var]]&eventos= onkeypress=' return soloNum(event,this);' <br>Procesado el Componente: selec<br>---Renderizado Componente: form_input.selec::id=tipo&tipo=selec&tam=&clase=s3&unico=[[var:]]unico[[:var]]&dataon=[[var:]]dataon[[:var]]&decimal=[[var:]]decimal[[:var]]&validate=&primary=[[var:]]primary[[:var]]&readonly=[[var:]]readonly[[:var]]&eventos=[[var:]]eventos[[:var]]<br>---Renderizado Componente: form_input.selec::id=fk_almacenes&tipo=selecdb&tam=&clase=s6&unico=[[var:]]unico[[:var]]&dataon=[[var:]]dataon[[:var]]&decimal=[[var:]]decimal[[:var]]&validate=numerico required &primary=[[var:]]primary[[:var]]&readonly=[[var:]]readonly[[:var]]&eventos= onkeypress=' return soloNum(event,this);' <br>---Renderizado Componente: form_input.selec::id=fk_unidades&tipo=selecdb&tam=&clase=s1&unico=[[var:]]unico[[:var]]&dataon=[[var:]]dataon[[:var]]&decimal=[[var:]]decimal[[:var]]&validate=numerico required &primary=[[var:]]primary[[:var]]&readonly=[[var:]]readonly[[:var]]&eventos= onkeypress=' return soloNum(event,this);' <br>---Renderizado Componente: form_input.selec::id=tipodoc&tipo=selec&tam=&clase=s4&unico=[[var:]]unico[[:var]]&dataon=[[var:]]dataon[[:var]]&decimal=[[var:]]decimal[[:var]]&validate=&primary=[[var:]]primary[[:var]]&readonly=[[var:]]readonly[[:var]]&eventos=[[var:]]eventos[[:var]]<br>Procesado el Componente: buscardb<br>---Renderizado Componente: form_input.buscardb::id=fk_prod&tipo=buscardb&tam=&clase=s9&unico=[[var:]]unico[[:var]]&dataon=[[var:]]dataon[[:var]]&decimal=[[var:]]decimal[[:var]]&validate=numerico required &primary=[[var:]]primary[[:var]]&readonly=[[var:]]readonly[[:var]]&eventos= onkeypress=' return soloNum(event,this);'  onblur='onChangeProd(); _buscarNomDb(this);' <br>Procesado el Componente: float<br>---Renderizado Componente: form_input.float::id=cant&tipo=float&tam=&clase=s2&unico=[[var:]]unico[[:var]]&dataon=[[var:]]dataon[[:var]]&decimal=2&validate=numerico required &primary=[[var:]]primary[[:var]]&readonly=[[var:]]readonly[[:var]]&eventos= onkeypress=' return soloNum(event,this);'  onblur=' _refreshFloat(this);' <br>---Renderizado Componente: form_input.float::id=costo&tipo=float&tam=&clase=s4&unico=[[var:]]unico[[:var]]&dataon=[[var:]]dataon[[:var]]&decimal=2&validate=numerico required &primary=[[var:]]primary[[:var]]&readonly=[[var:]]readonly[[:var]]&eventos= onkeypress=' return soloNum(event,this);'  onblur=' _refreshFloat(this);' <br>Procesado el Componente: alfa<br>---Renderizado Componente: form_input.alfa::id=nfac&tipo=alfa&tam=&clase=s4&unico=[[var:]]unico[[:var]]&dataon=[[var:]]dataon[[:var]]&decimal=[[var:]]decimal[[:var]]&validate=&primary=[[var:]]primary[[:var]]&readonly=[[var:]]readonly[[:var]]&eventos=[[var:]]eventos[[:var]]<br>---Renderizado Componente: form_input.alfa::id=serial&tipo=alfa&tam=&clase=s6&unico=[[var:]]unico[[:var]]&dataon=[[var:]]dataon[[:var]]&decimal=[[var:]]decimal[[:var]]&validate=&primary=[[var:]]primary[[:var]]&readonly=[[var:]]readonly[[:var]]&eventos=[[var:]]eventos[[:var]]<br>Procesado el Componente: join<br>---Renderizado Componente: form_input.join::id=fk_resp&tipo=join&tam=&clase=s12&unico=[[var:]]unico[[:var]]&dataon=[[var:]]dataon[[:var]]&decimal=[[var:]]decimal[[:var]]&validate=numerico required &primary=[[var:]]primary[[:var]]&readonly=[[var:]]readonly[[:var]]&eventos= onkeypress=' return soloNum(event,this);' <hr>nuevos componentes<hr><pre>Array
(
)
</pre><br>Grabado Vista:D:\AppServ\www\framework\almacen\application\modulos\ingalm\\views\formulario.html<script>console.log('PHP: 2018/03/29 21:16:09 Finalizo initTime():2115.3181');</script> <!DOCTYPE html>
  <html>
    <head>
		<meta charset="utf-8">
		<meta title="Modulo de Creacion de ABM/CRUD del framework MK">
		<meta name="viewport" content="width=device-width, initial-scale=1.0"/>
			<script type="text/javascript" src="js/jquery/jquery.js"></script>
			<link type="text/css" rel="stylesheet" href="js/materialize/materializeicon.css"/>
			<link type="text/css" rel="stylesheet" href="js/materialize/materialize.min.css"/>
			<script type="text/javascript" src="js/materialize/materialize.min.js"></script>
			<link type="text/css" rel="stylesheet" href="../mk/js/mk.css"/>
			<link type="text/css" rel="stylesheet" href="../mk/js/mkprint.css" media="print" />
			<script type="text/javascript" src="../mk/js/mk.js"></script>
		<style>
		</style>
	</head>
	<body>
		<header class="noprinter">
			  <div class="navbar-fixed">
    <nav>
      <div class="nav-wrapper">
        <a href="#!" class="brand-logo">  CRUD de la Tabla (ingalm)</a>
        <ul class="right ">
  <li><a href="index.php?crud=init" >TABLAS</a></li>
</ul>
      </div>
    </nav>
  </div>
		</header>
		<main>
 <br>
<pre><code class="language-php line-numbers no-whitespace-normalization"> <br>//Aqui empieza el Modelo<br><?php <br />
class Ingalm extends Mk\Shared\Model<br />
{<br />
<br />
/**<br />
* @column<br />
* @readwrite<br />
* @primary<br />
* @type autonumber<br />
* @label Id<br />
* @validate  numeric<br />
*/<br />
protected $_pk;<br />
/**<br />
* @column<br />
* @readwrite<br />
* @type date<br />
* @uso A<br />
* @funcion date<br />
* @label Fecha<br />
* @validate  required<br />
*/<br />
protected $_fecha;<br />
/**<br />
* @column<br />
* @readwrite<br />
* @type int<br />
* @uso A<br />
* @funcion st<br />
* @label Almacen<br />
* @validate  required, numeric<br />
*/<br />
protected $_fk_almacenes;<br />
/**<br />
* @column<br />
* @readwrite<br />
* @type int<br />
* @uso A<br />
* @funcion st<br />
* @label Producto<br />
* @validate  required, numeric<br />
*/<br />
protected $_fk_prod;<br />
/**<br />
* @column<br />
* @readwrite<br />
* @type decimal<br />
* @uso A<br />
* @funcion bdf<br />
* @label Cant<br />
* @validate  required, numeric<br />
*/<br />
protected $_cant;<br />
/**<br />
* @column<br />
* @readwrite<br />
* @type decimal<br />
* @uso A<br />
* @funcion bdf<br />
* @label Costo<br />
* @validate  required, numeric<br />
*/<br />
protected $_costo;<br />
/**<br />
* @column<br />
* @readwrite<br />
* @type int<br />
* @uso A<br />
* @funcion st<br />
* @label Unidad<br />
* @validate  required, numeric<br />
*/<br />
protected $_fk_unidades;<br />
/**<br />
* @column<br />
* @readwrite<br />
* @type char<br />
* @uso A<br />
* @funcion st<br />
* @label Tipo<br />
* @labelf Tipo de Ingreso<br />
*/<br />
protected $_tipo='C';<br />
/**<br />
* @column<br />
* @readwrite<br />
* @type char<br />
* @uso A<br />
* @funcion st<br />
* @label Tipo Doc.<br />
* @labelf Tipo de Documento<br />
*/<br />
protected $_tipodoc='F';<br />
/**<br />
* @column<br />
* @readwrite<br />
* @type varchar<br />
* @uso A<br />
* @funcion st<br />
* @label Doc<br />
* @labelf No. de Factura/Recibo<br />
*/<br />
protected $_nfac;<br />
/**<br />
* @column<br />
* @readwrite<br />
* @type date<br />
* @uso A<br />
* @funcion date<br />
* @label Vence<br />
* @labelf Fecha de Vencimiento<br />
*/<br />
protected $_fecven;<br />
/**<br />
* @column<br />
* @readwrite<br />
* @type varchar<br />
* @uso A<br />
* @funcion st<br />
* @label Serial<br />
*/<br />
protected $_serial;<br />
/**<br />
* @column<br />
* @readwrite<br />
* @type int<br />
* @uso A<br />
* @funcion useract<br />
* @label Resp<br />
* @labelf Responsable<br />
* @validate  required, numeric<br />
*/<br />
protected $_fk_resp;<br />
/**<br />
* @column<br />
* @readwrite<br />
* @type datetime<br />
* @uso G<br />
* @funcion datetimesystem<br />
* @label Created_<br />
*/<br />
protected $_created_;<br />
/**<br />
* @column<br />
* @readwrite<br />
* @type datetime<br />
* @uso A<br />
* @funcion datetimesystem<br />
* @label Modified_<br />
*/<br />
protected $_modified_;<br />
/**<br />
* @column<br />
* @readwrite<br />
* @type char<br />
* @uso G<br />
* @funcion custom<br />
* @fcustom 1<br />
* @label St<br />
*/<br />
protected $_status='1';<br />
public $_tSingular='Ingreso a Almacen';<br />
public $_tPlural='Ingresos a Almacen';<br />

<br />

<br />
public function __construct($options = array())<br />
	{<br />
		parent::__construct($options);<br />
<br />
		$this->setJoins('almacenes','(ingalm.fk_almacenes=j_almacenes.pk)',Array('j_almacenes.nombre' => 'join_fk_almacenes'));<br />
		$this->setJoins('prod','(ingalm.fk_prod=j_prod.pk)',Array('j_prod.nom' => 'join_fk_prod'));<br />
		$this->setJoins('unidades','(ingalm.fk_unidades=j_unidades.pk)',Array('j_unidades.nombre' => 'join_fk_unidades'));<br />
		$this->setJoins('resp','(ingalm.fk_resp=j_resp.pk)',Array('j_resp.nombre' => 'join_fk_resp'));<br />
<br />
	}<br />
}<br />
<br />
//version MK.CRUD 1.0 <br />
?>
//Aqui empieza el Controlador<br><?php <br />
use Mk\Shared\CrudDb as CrudDb;<br />
class Ingalm_controller extends CrudDb<br />
{<br />
	public function __construct($options = array())<br />
	{<br />
		parent::__construct($options);<br />
		$this->_secureKey='resp';<br />
		$this->_secure();<br />
	}<br />
<br />
	public function getAnexos($anexos=array(),$join=0){<br />
		$anexos=parent::getAnexos($anexos);<br />
		$anexos['listAction']="-1";<br />
		$anexos['fk_almacenes']['join']['table']='almacenes';<br />
		$anexos['fk_almacenes']['join']['campo']='nombre';<br />
		$anexos['fk_prod']['join']['table']='prod';<br />
		$anexos['fk_prod']['join']['campo']='nom';<br />
		$anexos['fk_prod']['join']['tag']="fk_unidades";<br />
		$anexos['fk_prod']['join']['join']="left join unidades on (fk_unidades=unidades.pk)";<br />
		$anexos['fk_unidades']['join']['table']='unidades';<br />
		$anexos['fk_unidades']['join']['campo']='nombre';<br />
		$anexos['fk_unidades']['join']['cond']="(tipo='%s')";<br />
		$anexos['fk_unidades']['join']['tag']="tipo";<br />
		$anexos['tipo']['defVal']='C';<br />
		$anexos['tipo']['options']['C']='Compra';<br />
		$anexos['tipo']['options']['I']='Inventario Inicial';<br />
		$anexos['tipo']['options']['T']='Traspaso';<br />
		$anexos['tipo']['options']['D']='Devolucion';<br />
		$anexos['tipo']['options']['A']='Ajuste';<br />
		$anexos['tipodoc']['defVal']='F';<br />
		$anexos['tipodoc']['options']['F']='Factura';<br />
		$anexos['tipodoc']['options']['R']='Recibo';<br />
		$anexos['tipodoc']['options']['X']='Ninguno';<br />
		$anexos['status']['defVal']='1';<br />
		if ($join!=0){<br />
			$anexos['fk_almacenes']['options']=$this->actionGetListFor('fk_almacenes',$anexos);<br />
			$anexos['fk_unidades']['options']=$this->actionGetListFor('fk_unidades',$anexos);<br />
		}<br />
<br />
		return $anexos;<br />
	}<br />
//* preserve code: *//<br />
<br />
<br />
//* :preserve code *//<br />
<br />
}<br />
//version MK.CRUD 1.0 <br />
?>  </code></pre>
		</main>
		<footer>
		</footer>
<link href='js/prism/prism.css' rel='stylesheet'>
<script type='text/javascript' src='js/prism/prism.js'></script>
		<script>
			$(document).ready(function(){
				$('#debug').modal();
			});
		</script>
	</body>
</html>
