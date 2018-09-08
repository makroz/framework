 <div id="campos" class="row">

  @foreach($_table as $field_i=>$field)

  <div class="col s6 m4 l2 divcampos">

    <div class="card large ">

      <div class="card-content  " data-campo='{{$field_i}}' >
        <div class=" handle card-title waves-effect
@if( ($field['key']=='PRI'))
red-text @endif  z-depth-1 " style="display:block;padding:5px;margin-bottom:5px;" >
          <i class="tiny material-icons ">@if( ($field['key']=='PRI'))stars @endif  @if( ($field['key']=='MUL'))vpn_key @endif  @if( ($field['key']==''))adjust @endif </i>
          {{$field_i}}
        </div>

        <p>
          Tipo:{{$field['type']}} @if( ($field['args'][0]) ) ( {{$field['args'][0]}} @if( ($field['args'][1]) ) , {{$field['args'][1]}} @endif  ) @endif

@if( ($field['null']=='NO') )
 <br>Null: NO  @endif
          @if( ($field['null']!='NO') ) <br>Null: SI  @endif
          @if( ($field['default']!='') ) <br>Default: {{$field['default']}}   @endif
          @if( ($field['extra']!='') ) <br>{{$field['extra']}}   @endif
        </p>


        @foreach($_pedir as $pedir_i=>$pedir)
          @if( $pedir['unique']!=1 )
          <input type="hidden" id="field-{{$field_i}}-{{$pedir_i}}" name="field[{{$field_i}}][{{$pedir_i}}]"  value="{{$pedir['val'][$field_i]}}" class="data-campo" data-nom='{{$pedir_i}}' data-campo='{{$field_i}}' >
          @endif
        @endforeach
         <input type="hidden" id="field-{{$field_i}}-i_pre" name="field[{{$field_i}}][i_pre]"  value="" class="data-campo" data-nom="i_pre" data-campo='{{$field_i}}' >
        <input type="hidden" id="field-{{$field_i}}-i_pos" name="field[{{$field_i}}][i_pos]"  value="" class="data-campo" data-nom="i_pos" data-campo='{{$field_i}}' >
      </div>
      <div class="card-action">
          <button type="button" data-target="modal1" class="modal-trigger waves-effect waves-light btn red" onclick="openDet('{{$field_i}}');">Editar</button>

      </div>

  </div>
</div>

@endforeach

 </div>
