<?php  $nodos=$_php->get();$f=ceil(count($nodos)/4);$f=count($nodos)-$f;$i=1;  ?>
<table id="alveolo">
	@foreach($nodos as $nodo)
	@if( (($i==1)||($i>$f)) )
	<tr>
	@endif
		<td @if(($i & 1)&&($i<$f)) rowspan="2" @endif >
			<div class="alveole insecticides clearfix ">
				<div class="content wow fadeInLeft animated" style="visibility: visible; animation-name: fadeInLeft;">
					<h2 class="cc{{$nodo[color]}}">{{$nodo[titulo]}}</h2>
					<div class="masque">
						<article>
							<p>{{$nodo[descrip]}}</p>
							<a href="{{$nodo[link]}}" class="button" style="background:url(img/alveolo{{$nodo[color]}}.png);background-position:bottom center;  background-repeat:no-repeat;  background-size:contain;">
								{{$nodo[boton]}}
							</a>
						</article>
					</div>
				</div>
			</div>
		</td>
	@if ($i>$f)
	</tr>
	@endif
	<?php  $i++;  ?>
	@endforeach
</table>
