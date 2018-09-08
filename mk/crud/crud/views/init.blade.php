<h2 class="header">Database: {{$database}}</h2>
<div class="row">

  @foreach($tables as $table_i=>$table)

    <div class="col s6 m4 l2 ">
      <div class="card large ">
        <div class="card-content  " >
          <div class="card-title red-text">
            <span class="hide-on-small-only">
              Tabla:
            </span>
            {{$table_i}}
          </div>
          <div class="small" style="height:350px; overflow: auto;">
            <ul class="collapsible" data-collapsible="accordion">

              @foreach($table as $field_i=>$field)

                <li>
                  <div class="collapsible-header @if( ($field['key']=='PRI') ) red-text @endif ">
                    <i class="tiny material-icons ">
                      @if( ($field['key']=='PRI'))
                        stars
                      @endif
                      @if( ($field['key']=='MUL'))
                        vpn_key
                      @endif
                      @if( ($field['key']==''))
                        adjust
                      @endif
                    </i>
                    {{$field_i}}
                  </div>
                  <div class="collapsible-body">
                    <p>
                      Tipo:{{$field['type']}}
                      @if( ($field['args'][0]) )
                        (
                        {{$field['args'][0]}}
                        @if( ($field['args'][1]) )
                          , {{$field['args'][1]}}
                        @endif  )
                      @endif
                      @if( ($field['null']=='NO') )
                        <br>Null: NO
                      @endif
                      @if( ($field['default']!='') )
                        <br>Default: {{$field['default']}}
                      @endif
                      @if( ($field['extra']!='') )
                        <br>{{$field['extra']}}
                      @endif
                    </p>
                  </div>
                </li>
              @endforeach
            </ul>
          </div>
        </div>
        <div class="card-action">
          <a class="waves-effect waves-light btn red" href="index.php?crud=table&table={{$table_i}}">
            Seleccionar
          </a>

        </div>
      </div>
    </div>
  @endforeach
</div>
