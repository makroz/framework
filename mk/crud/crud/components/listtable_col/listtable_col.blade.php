[[compile:]]


[* if '[[var:]]tipo[[:var]]'=='status' *]

@section('js.inline')

function cambiarStatus(item){
var pk=$(item).data('pk');
var status=$(item).data('status');

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
     	
     	$(item).data('status',newstatus).attr('src','img/'+icon+'.png');

     }
   });

}

@append 

<td >

     @if( ($row[[[var:]]key[[:var]]]=="[[var:]]status[[:var]]") ) 
          <img src="img/E.png" title="Click para cambiar" data-status='0' data-pk='$row[pk]' id='img_status_$row[pk]' onclick="cambiarStatus(this);" >
      @endif 
     {% else %}
          <img src="img/X.png" title="Click para cambiar" data-status='[[var:]]status[[:var]]' data-pk='$row[pk]' id='img_status_$row[pk]' onclick="cambiarStatus(this);" >
      @endif 
</td>

[* /if *]

[* if '[[var:]]tipo[[:var]]'=='check' *]
<td > 
     @if( ($anexos[[[var:]]key[[:var]]]['dataon']==$row[[[var:]]key[[:var]]]) )  
          {{$anexos[[[var:]]key[[:var]]]['labelon']}}
      @endif 
     {% else %}
          {{$anexos[[[var:]]key[[:var]]]['labeloff']}}
      @endif 
</td>

[* /if *]

[* if '[[var:]]tipo[[:var]]'=='lista' *]

<td > 
     {{$anexos[[[var:]]key[[:var]]]['options'][$row[[[var:]]key[[:var]]]]}}
</td>

[* /if *]

[* if '[[var:]]tipo[[:var]]'=='join' *]

<td > 
     {{$row[join_[[var:]]key[[:var]]]; }}
</td>

[* /if *]

[* if '[[var:]]tipo[[:var]]'=='date' *]

<td > 

     {{\\Mk\\Tools\\Form::dbToDate($row[[[var:]]key[[:var]]])}}
</td>

[* /if *]


[* if '[[var:]]tipo[[:var]]'=='default' *]

<td > 
     {{$row[[[var:]]key[[:var]]]}}
</td>

[* /if *]

[[:compile]]