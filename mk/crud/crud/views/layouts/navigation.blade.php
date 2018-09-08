<div class="navbar-fixed">
  <nav>
    <div class="nav-wrapper">
      <a href="#!" class="brand-logo">  CRUD de la Tabla ({{$tableName}})</a>
      <ul class="right ">

        @if( $_action == 'table' )

          <li class="active"><a href="#" onclick="validarFormulario();" > GENERAR</a></li>
          <li><a href="#" onclick="cargarConfig();" > CARGAR CONFIG</a></li>
          <li><a href="#" > FORMULARIO</a></li>
        @endif
        <li><a href="index.php?crud=init" >TABLAS</a></li>

      </ul>
    </div>
  </nav>
</div>
