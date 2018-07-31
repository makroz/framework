<?php  $ults='';//$menus=$_php->get(); ?>
@foreach($_php->get() as $menu)
  @if( $menu[fk_menus]!=$ults )
    @if( $ults!='' )
    </ul>
    @endif
  <ul id="submenu{{$menu[fk_menus]}}" class="dropdown-content dropmenu">
    <?php  $ults=$menu[fk_menus];  ?>
  @endif
  @if( $menu[tipo]=='P' )
    <li>
      <a href = "index.php?url=home/page&id={{$menu[pk]}}" >{{$menu[nom]}}</a>
    </li>
  @else
    <li>
      <a href = "{{$menu[link]}}" >{{$menu[nom]}}</a>
    </li>
  @endif
@endforeach
@if( $ults!='' )
</ul>
@endif
