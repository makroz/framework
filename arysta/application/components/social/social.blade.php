<div class="tredes">
  Redes Sociales:
</div>
@foreach($_php->get() as $soc)
<a href="{{$soc[link]}}" target="_blank">
  <img title="{{$soc[nom]}}" src="upload\sociales-file1-{{$soc[pk]}}.png" width="40">
</a>
@endforeach
