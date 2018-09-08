[[unique:]]<?php $maxpage=ceil($count / $limit); $minpage=$page-1; if ($minpage<=0){ $minpage=1; } $lastpage=$minpage+2;if($lastpage>$maxpage){ $lastpage=$maxpage;}   ?>[[:unique]]

@if( $items != false ) 
<ul class="pagination" style="padding: 0.8em;margin:0;" >

     <li class="@if( ($count <= 1)or($page==1) )  disabled  @endif {% else %} waves-effect  @endif "><a href="#!"><i class="material-icons" @if( !(($count <= 1)or($page==1)) )  onclick="_changePageList('1')"  @endif  >skip_previous</i></a></li>
    <li class="@if( ($count <= 1)or($page==1) )  disabled  @endif {% else %} waves-effect  @endif "><a href="#!"><i class="material-icons" @if( !(($count <= 1)or($page==1)) )  onclick="_changePageList('{{($page-1)}}')"  @endif  >chevron_left</i></a></li>

				@foreach(range($minpage, $lastpage) as $_page_i=>$_page)
				<li class="@if( $page == $_page ) active @endif  waves-effect" ><a href="#!" onclick="_changePageList('{{$_page}}')" >{{$_page}}</a></li>
				@endforeach 

     <li class="@if( ($count <= 1)or($page==$maxpage) )  disabled  @endif {% else %} waves-effect  @endif "><a href="#!"><i class="material-icons" @if( !(($count <= 1)or($page==$maxpage)) )  onclick="_changePageList('{{($page+1)}}')"  @endif  >chevron_right</i></a></li>
    <li class="@if( ($count <= 1)or($page==$maxpage) )  disabled  @endif {% else %} waves-effect  @endif "><a href="#!"><i class="material-icons" @if( !(($count <= 1)or($page==$maxpage)) )  onclick="_changePageList('{{$maxpage}}')"  @endif  >skip_next</i></a></li>
    <li class="" ><?php $__selected[$limit]="selected='selected'";  ?> 
    <select id="limit" name="limit" class="browser-default" style="width: 90px;height: 40px;" onchange="_changeLimitList(this);">
	<option value="10" {{$__selected['10']}} >10 / $count</option>
	<option value="20" {{$__selected[20]}} >20 / $count</option>
	<option value="30" {{$__selected[30]}} >30 / $count</option>
	<option value="40" {{$__selected[40]}} >40 / $count</option>
	<option value="50" {{$__selected[50]}} >50 / $count</option>
	<option value="100" {{$__selected[100]}} >100 / $count</option>
</select>  </li>
</ul>

 @endif 
{% else %}
0 Items
 @endif 