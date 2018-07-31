@foreach($_php->get() as $menu)
  @if( $menu[tipo]=='M' )
    <li>
      <a class="dropdown-trigger" href="#!" data-target="submenu{{$menu[pk]}}" >
        {{$menu[nom]}}
        <i class="material-icons right">arrow_drop_down</i>
      </a>
    </li>
  @else
    <li>
      <a href = "{{$menu[link]}}" >
        {{$menu[nom]}}
      </a>
    </li>
  @endif
@endforeach
