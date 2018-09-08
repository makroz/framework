@section('style.inline')
  .tabladiv{
    float:left;
    border:1px doted red;
    display:block;
    clear:both;
  }
  table#camposLista th{
    position: relative;
  }

  .top-r-o{
    position:absolute;
    top:-10px;
    font-size: 8px;
    right: 10px;
  }

  .bottom-r-o{
    position:absolute;
    bottom:-20px;
    font-size: 8px;
    right: -5px;
  }
  .bottom-l-o{
    position:absolute;
    bottom:-20px;
    font-size: 8px;
    left: -5px;
  }

  .top-r-i{
    position: absolute;
    top: -1px;
    right: -5px;
  }
  .bottom-r-i{
    position: absolute;
    bottom:1px;
    right: 5px;
  }


  table.highlight > tbody > tr:hover {
    background-color: #BFBFFF;
  }

  .sortable{
    background-image:url('img/sort.png');
    background-repeat: no-repeat;
    background-position: left;
    padding-left:19px;
    cursor:pointer;
  }

  .sort_desc{
    background-image:url('img/sort_desc.png');
  }

  .sort_asc{
    background-image:url('img/sort_asc.png');
  }

  .tablaLista th{
    border-right:1px solid #888888;
    border-left:1px solid #888888;
  }

  .selTR, table.striped > tbody > tr.selTR:nth-child(2n+1), table.striped > tbody > tr.selTR:nth-child(2n+0) {
    background-color: red;
  }



  .highlight{
    background-color:#000;
  }
  .input-field .postfix {
    font-size: 2rem;
    position: absolute;
    right:0;
    transition: color 0.2s ease 0s;
    width: 3rem;
  }
  .input-field .postfix.active {
    color:#26a69a;
  }

  .portlet-placeholder {
    border: 1px dotted black;
    margin: 0 1em 1em 0;
    height: 50px;
  }

  .input-field .postfix ~ input, .input-field .postfix ~ textarea, .input-field .postfix ~ label, .input-field .postfix ~ .validate ~ label, .input-field .postfix ~ .autocomplete-content {
    margin-rigth: 3rem;
    width: calc(100% - 3rem);
  }

  #panelComponentes{
    background-color:#fff;
  }

@append


@section('js.files')
  <link href='js/jquery-ui/jquery-ui.min.css' rel='stylesheet'>
  <script type='text/javascript' src='js/jquery-ui/jquery-ui.min.js'></script>
  <script src="../mk/js/mk_MasterDetails.js"></script>
  <script src="../mk/js/mk_Componentes.js"></script>
  {!!\Mk\Tools\App::jscomponentes()!!}

  <link rel="stylesheet" href="../mk/js/codemirror/lib/codemirror.css">
  <link rel="stylesheet" href="../mk/js/codemirror/theme/material.css">
  <script src="../mk/js/codemirror/lib/codemirror.js"></script>
  <script src="../mk/js/codemirror/addon/selection/active-line.js"></script>
  <script src="../mk/js/codemirror/addon/edit/matchbrackets.js"></script>
  <script src="../mk/js/codemirror/addon/edit/closebrackets.js"></script>
  <script src="../mk/js/codemirror/addon/fold/xml-fold.js"></script>
  <script src="../mk/js/codemirror/addon/edit/closetag.js"></script>
  <script src="../mk/js/codemirror/addon/edit/matchtags.js"></script>
  <script src="../mk/js/codemirror/mode/javascript/javascript.js"></script>
  <script src="../mk/js/codemirror/mode/php/php.js"></script>

  <link href='../mk/js/colresize/colResizable.css' rel='stylesheet'>
  <script src='../mk/js/colresize/colResizable.js'></script>
  <link type='text/css' rel='stylesheet' href='js/confirm/confirm.css'/>
  <script type='text/javascript' src='js/confirm/confirm.js'></script>

@append
@section('js.files')
<link href='../mk/js/custombox/custombox.min.css' rel='stylesheet'>
<script type='text/javascript' src='../mk/js/custombox/custombox.min.js'></script>
@append
@section('js.onready')

  $('#pindiv').pushpin({
    top: 10,
    bottom: 1000,
    offset: 0
  });

  Mk_Componentes.showAll('#panelComponentes');

  @foreach($_pedir as $pedir_i=>$pedir)

    @if( ($pedir['type']=='codeeditor') )

      editor_{{$pedir_i}} = CodeMirror.fromTextArea(document.getElementById("{{$pedir_i}}"), {
        lineNumbers: true,
        styleActiveLine: true,
        matchBrackets: true,
        autoCloseBrackets: true,
        matchTags: {bothTags: true},
        extraKeys: {"Ctrl-J": "toMatchingTag"},
        autoCloseTags: true,
        autoRefresh: true,
        theme: 'material'
      });
    @endif
  @endforeach


  $(".button-collapse").sidenav();
  $('select').formSelect();

  $('#funcion').bind( "change", function() {
    valFuncion();
  });

  $(' #tipolista').bind( "change", function() {
    valTipoLista();
  });

  $('#usof').bind( "change", function() {
    valUsof();
  });


  $("#campos").sortable({
    containment: "#campos",
    cursor: "move",
    forceHelperSize: true,
    handle: ".handle",
    opacity: 0.5,
  });

  //$("#listado").sortable({
    //  containment: "#campos",
    //   cursor: "move",
    //   forceHelperSize: true,
    // handle: ".handle",
    //   opacity: 0.5,
    //});
    //$("#trlistado").sortable({
    //  items: "> th",
    ///  cursor: "move",
    //  forceHelperSize: true,
    //  opacity: 0.5,
    //});
    //$("tr.trlistado").disableSelection();
    //$("#modal1").modal();


    $("#tabs").tabs({ onShow: function(tab) {
      idtabshow=$(tab).attr('id');
      if (idtabshow=='tabcodigos'){
        @foreach($_pedir as $pedir_i=>$pedir)
          @if( ($pedir['type']=='codeeditor') )
            editor_{{$pedir_i}}.refresh();
          @endif
        @endforeach
      }

      //alert(idtabshow);
      if (idtabshow=='formulario'){
        showFormulario();
      }
      if (idtabshow=='lista'){
        showLista();
      }



    }
  });

  if (confirm('Desea Cargar la ultima Configuracion?')){
    cargarConfig();
  }

  valFunc();


@append

@section('js.inline')
  function showLista(){
    var html= '<div class="row camposLista" >'+
      '<table class="striped bordered highlight tablaLista" id="camposLista">'+
        '<thead class="red">'+
          '<tr id="trlistado">'+
            '<th  data-field="i_check" width="30" class="center noprinter" >'+
              '<label for="list_check_all"><input type="checkbox" id="list_check_all" name="list_check_all"  data-type="check" data-on="1" data-off="0"  />'+
                '<span></span></label>'+
                '</th>'+
                '';
                var ncampos=0;
                var htmluso='Campos Disponibles:<br>';

                var col=[];
                var i_append=0;
                $('.card-content').each(function(){
                  let nom=$(this).data('campo');
                  let pos=$('#field-'+nom+'-posl').val();
                  col.push([pos,nom]);
                });
                col=sortByCol(col,0);
                $.each(col,function(i,item){
                //$('.card-content').each(function(){
                  //let nom=$(this).data('campo');
                  let nom=item[1];

                  let tipo=$('#field-'+nom+'-tipolista').val();
                  let tam=$('#field-'+nom+'-tamlista').val();
                  let label=$('#field-'+nom+'-label').val();
                  let usof=$('#field-'+nom+'-usof').val();
                  let inp='';
                  let filter=$('#field-'+nom+'-listafilter').val();
                  let lfilter='';
                  switch(usof) {
                    case 'selec':
                    case 'selecdb':
                    case 'selecdbgrupo':
                    if (filter==1){
                      filter='<i class="material-icons black-text" data-campo="'+nom+'" onclick="onQuitarFiltro(this,0);">filter_list</i>';
                    }else{
                      filter='<i class="material-icons grey-text" data-campo="'+nom+'" onclick="onQuitarFiltro(this,1);">filter_list</i>';
                    }

                    break;
                    default:
                    $('#field-'+nom+'-listafilter').val('0');
                    filter='';
                    break;
                  }


                  switch(tipo) {
                    case '-1':
                    case 'get':
                    htmluso=htmluso+filter+'<i class="material-icons" data-campo="'+nom+'" onclick="onQuitarLista(this,1);">visibility</i> '+label+'<br> ';
                    break;
                    default:
                    let seltamvar='';
                    let showtam=parseFloat(tam).toFixed(2)+'px';
                    if (tam==''){seltamvar='checked';showtam='';}
                    inp='<th data-field="'+nom+'" id="th-'+nom+'" width="'+tam+'" class="sortable thlista" >'+label+
                      ' <div class="top-r-o showtam" >'+showtam+'</div>'+
                      ' <span class="top-r-i">'+
                        ' <label for="listatamvar1'+nom+'"><input type="radio" name="listatamvar1" id="listatamvar1'+nom+'" value="'+nom+'" '+seltamvar+' onchange="onListChange(1);"><span></span></label>'+
                        '</span>'+
                        ' <span class="bottom-r-i">'+filter+'<i class="material-icons" data-campo="'+nom+'" onclick="onQuitarLista(this,0);">visibility_off</i></span>'+
                        ' <div class="bottom-l-o" onclick="onMover(this,-1);" ><i class="material-icons" >navigate_before</i> </div>'+
                        ' <div class="bottom-r-o" onclick="onMover(this,1);" > <i class="material-icons" >navigate_next</i>  </div>'+
                        '</th>';
                        ncampos++;
                        break;
                      }
                      //html=html+item[0]+':'+item[1]+' uso:'+tipo+'<br>';
                      html=html+inp;
                    });

                    if ($('#listAction').val()=='show'){
                      html=html+
                      '<th data-field="i_action" width="290" class=" noprinter">Accion'+
                        '<span class="bottom-r-i"><i class="material-icons" data-campo="i_action" onclick="onQuitarLista(this,0);">visibility_off</i></span>'+
                        '</th>';
                      }else{
                        htmluso=htmluso+'<i class="material-icons" data-campo="i_action" onclick="onQuitarLista(this,1);">visibility</i> Menu Acciones<br> ';
                      }
                      html=html+
                      '</thead>'+
                      '<tbody></tbody>'+
                      '</table>'+
                      '</div>'+
                      '<hr>'+
                      htmluso;
                      $('.list-content').html(html);
                      $(".tablaLista").colResizable({
                        liveDrag:true,
                        gripInnerHtml:"<div class='grip'></div>",
                        draggingClass:"dragging",
                        resizeMode:"fit",
                        disabledColumns:[0,ncampos],
                        onResize:onListChange,
                        postbackSafe:false,
                        partialRefresh:true,
                        headerOnly:true

                      });
                      actualizarUI();


                    }

                    function onMover(t,c){
                        let nom=$(t).parent().data('field');
                        let pos=$('#field-'+nom+'-posl').val();
                        if (c==-1){
                            $('#field-'+nom+'-posl').val(pos-1.1);
                        }else{
                          $('#field-'+nom+'-posl').val((pos*1)+1.1);
                        }
                        var col=[];
                        $('.card-content').each(function(){
                          let nom=$(this).data('campo');
                          let pos=$('#field-'+nom+'-posl').val();
                          col.push([pos,nom]);
                        });
                        //alert(col);
                        col=sortByCol(col,0);
                        //alert(col);
                        $.each(col,function(i,item){
                          $('#field-'+item[1]+'-posl').val(i);
                        });
                        showLista();

                    }

                    function onQuitarFiltro(campo,tipo){
                      if (!tipo){
                        tipo=0;
                      }
                      var nom=$(campo).data('campo');
                      $('#field-'+nom+'-listafilter').val(tipo);
                      showLista();
                    }

                    function onQuitarLista(campo,tipo){
                      if (!tipo){
                        tipo=0;
                      }
                      var nom=$(campo).data('campo');
                      if (tipo==1){
                        tipo='show';
                      }else{
                        tipo='-1';
                      }
                      if (nom=='i_action'){
                        $('#listAction').val(tipo);
                      }else{
                        $('#field-'+nom+'-tipolista').val(tipo);
                      }
                      showLista();
                    }

                    function onListChange(e){

                      var columns = $('table#camposLista').find("th");

                      $(columns).each(function(){
                        let nom=$(this).data('field');
                        let tam=$(this).css('width');
                        $('#field-'+nom+'-tamlista').val(tam);
                        $(this).find('div').eq(0).html(parseFloat(tam).toFixed(2)+'px');

                        //tam=tam+'Col:'+$(this).data('field')+' Tam:'+$(this).css('width');
                      });

                      var nomvar=$('input:radio[name=listatamvar1]:checked').val();
                      $('#field-'+nomvar+'-tamlista').val('');
                      $('#th-'+nomvar).find('div').html('');


                    }



                    var flagcambios=0;
                    function cambioCamposform( event, ui ){
                      if (flagcambios==0){
                        flagcambios=1;
                        var c=0;
                        var contenido=''+$('.form-content').html()+'';
                        contenido=iReplace(contenido,Mk_Componentes.getTools(),'');
                        contenido=iReplace(contenido,'ui-sortable','');
                        contenido=iReplace(contenido,'ui-droppable','');
                        //alert(contenido);
                        var nom;
                        var ult;
                        var nombres=[];
                        $('.input-field.form-config').each(function(i){

                          nom=$(this).data('campo');
                          if (nombres[nom]==1){
                            return false;
                          }else{
                            nombres[nom]=1;
                            $('#field-'+nom+'-posf').val(i);
                            $('#field-'+nom+'-i_pos').val('');
                            $('#field-'+nom+'-i_pre').val('');
                            ult=nom;
                            //alert(nom+':'+i);
                            var posi=contenido.indexOf('<div id="form-config-'+nom+'"');
                            if (posi>=0){
                              var i_pre=contenido.substr(0,posi);
                              posi=contenido.indexOf(Mk_Componentes.getTagFin());
                              posi=contenido.indexOf('</div>',posi);
                              contenido=contenido.substr(posi+6);
                              $('#field-'+nom+'-i_pre').val(i_pre);
                              c++;
                            }
                          }

                        });
                        $('#field-'+ult+'-i_pos').val(contenido);
                        flagcambios=0;
                      }
                    }


                    function showFormulario(){
                      var html='';
                      var col=[];
                      var i_append=0;
                      $('.card-content').each(function(){
                        let nom=$(this).data('campo');
                        let pos=$('#field-'+nom+'-posf').val();
                        if ($('#field-'+nom+'-i_pos').val()!=''){
                          i_append++;
                        }
                        if ($('#field-'+nom+'-i_pre').val()!=''){
                          i_append++;
                        }
                        col.push([pos,nom]);
                      });
                      //alert(col);
                      col=sortByCol(col,0);
                      //alert(col);
                      //html=html+'<hr>';
                      $.each(col,function(i,item){
                        let tipo=$('#field-'+item[1]+'-usof').val();
                        let inp='';
                        let clase='';
                        let tam=$('#field-'+item[1]+'-tam').val();
                        if (isNaN(tam)!==false){
                          clase=tam;
                          tam='';
                        }
                        let label=$('#field-'+item[1]+'-labelf').val();
                        if (label==''){
                          label=$('#field-'+item[1]+'-label').val();
                        }

                        //alert(item[1]+':'+item[0]+':'+i);
                        switch(tipo) {
                          case 'oculto':
                          //inp='<span class="form-config" title="'+item[1]+'" data-campo="'+item[1]+'" data-type="field">[x]</span>';
                          break;
                          case 'alfa':
                          case 'join':
                          case 'date':
                          case 'datetime':
                          case 'float':
                          case 'int':
                          case 'pass':
                          inp='<div id="form-config-'+item[1]+'" class="input-field col '+clase+' form-config " data-campo="'+item[1]+'"" data-type="field">'+
                            '<input id="config-'+item[1]+'" type="text" class="alfa" width="'+tam+'" value="" >'+
                            '<label for="config-'+item[1]+'">'+label+'</label>'+
                            Mk_Componentes.getTagFin()+
                            '</div>';
                            break;
                            case 'area':
                            case 'editor':
                            inp='<div id="form-config-'+item[1]+'" class="input-field col '+clase+' form-config " data-campo="'+item[1]+'"" data-type="field">'+
                              '<textarea id="config-'+item[1]+'" type="text" class="area" width="'+tam+'" ></textarea>'+
                              '<label for="config-'+item[1]+'">'+label+'</label>'+
                              Mk_Componentes.getTagFin()+
                              '</div>';
                              break;
                              case 'check':
                              inp='<div id="form-config-'+item[1]+'" class="input-field col '+clase+' form-config " data-campo="'+item[1]+'" data-type="field">'+
                                '<input type="checkbox" id="config-'+item[1]+'"  class="check" value="1" />'+
                                '<label for="config-'+item[1]+'">'+label+'</label>'+
                                Mk_Componentes.getTagFin()+
                                '</div>';
                                break;
                                case 'tree':
                                inp='<div id="form-config-'+item[1]+'" class="input-field col '+clase+' form-config " data-campo="'+item[1]+'" data-type="field">'+
                                  '<label class="labeltop"  for="config-'+item[1]+'">'+label+'</label>'+
                                  '<table id="config-'+item[1]+'"  class="treeg"  width="'+tam+'">'+
                                    '<tr><td>item</td><td><a class="btn-floating  waves-effect waves-light green" title="Adicionar"><i class="material-icons">add</i></a><a class="btn-floating  waves-effect waves-light red" title="Borrar"><i class="material-icons">delete</i></a><a class="btn-floating  waves-effect waves-light yellow" title="Editar"><i class="material-icons">edit</i></a></td></tr>'+
                                    '</table>'+
                                    Mk_Componentes.getTagFin()+
                                    '</div>';
                                    break;

                                    case 'selec':
                                    case 'selecdb':
                                    case 'selecdbgrupo':
                                    inp='<div id="form-config-'+item[1]+'" class="input-field col '+clase+' form-config " data-campo="'+item[1]+'" data-type="field">'+
                                      '<select id="config-'+item[1]+'" class="select" width="'+tam+'" >'+
                                        '<option>opcion1</option><option>opcion2</option>'+
                                        '</select>'+
                                        '<label for="config-'+item[1]+'">'+label+'</label>'+
                                        Mk_Componentes.getTagFin()+
                                        '</div>';
                                        break;
                                        case 'buscardb':
                                        inp='<div id="form-config-'+item[1]+'" class="input-field col '+clase+' form-config " data-campo="'+item[1]+'"" data-type="field">'+
                                          '<div class="col s4">'+
                                            '<input id="config-'+item[1]+'" type="text" class="alfa" value="" style="margin-right: 30px;" >'+
                                            '<label for="config-'+item[1]+'">'+label+'</label>'+
                                            '</div>'+
                                            '<div class="col s8">'+
                                              '<i class="material-icons prefix">sms</i>'+
                                              '<input id="config-'+item[1]+'" type="text" class="alfa" value="" >'+
                                              '</div>'+
                                              Mk_Componentes.getTagFin()+
                                              '</div>';
                                              break;
                                              default:
                                              //code block
                                              break;
                                            }
                                            if (inp!=''){
                                              inp=$('#field-'+item[1]+'-i_pre').val()+inp+$('#field-'+item[1]+'-i_pos').val();
                                            }

                                            html=html+inp;
                                          });

                                          //alert(i_append);

                                          if (i_append==0){
                                            html='<div class="row form-config-section componente i_c-section"  id="c-section-0" data-campo="c-section-0" data-type="c-section"> <div class="dropin row" >'+html+'</div></div>';
                                          }

                                          $('.form-content').html(html);
                                          actualizarUI();

                                          //$('.form-config,.form-config-section ').prepend(Mk_Componentes.getTools());

                                          Mk_Componentes.initComponentes(cambioCamposform);
                                          Mk_Componentes.init('.form-content');


                                        }

                                        function cargarConfig(){
                                          getAjax('index.php?crud=getConfig','GET',{},'',function(msg){
                                            cargarConfig1(msg);
                                          });
                                        }

                                        function cargarConfig1(plantilla){
                                          if(plantilla==''){
                                            plantilla=prompt('Ingrese la Plantilla:','');
                                          }
                                          if (plantilla!=''){
                                            var datos=JSON.parse(plantilla);

                                            $.each(datos, function( i, item) {
                                              if (i=='field'){
                                                $.each(item, function(i1,item1){
                                                  if (jQuery.type(item1)=='object'){
                                                    $.each(item1, function(i2,item2){
                                                      // alert('#'+i+'-'+i1+'-'+i2+':'+$('#'+i+'-'+i1+'-'+i2).val());
                                                      $('#'+i+'-'+i1+'-'+i2).val(item2);
                                                      // alert('#'+i+'-'+i1+'-'+i2+':'+$('#'+i+'-'+i1+'-'+i2).val());
                                                    });
                                                  }
                                                });
                                              }else{
                                                if (jQuery.type(item)=='string'){
                                                  $('#'+ i +'.plantilla').val(item);
                                                }
                                              }
                                            });

                                          }

                                          @foreach($_pedir as $pedir_i=>$pedir)
                                            @if( ($pedir['type']=='codeeditor') )
                                              editor_{{$pedir_i}}.getDoc().setValue($('#{{$pedir_i}}').val());
                                              editor_{{$pedir_i}}.refresh();
                                            @endif
                                          @endforeach

                                          $('select').formSelect();
                                          M.updateTextFields();

                                          if (idtabshow=='tabcodigos'){
                                            @foreach($_pedir as $pedir_i=>$pedir)
                                              @if( ($pedir['type']=='codeeditor') )
                                                editor_{{$pedir_i}}.refresh();
                                              @endif
                                            @endforeach
                                          }

                                          if (idtabshow=='formulario'){
                                            showFormulario();
                                          }

                                          if (idtabshow=='lista'){
                                            showLista();
                                          }

                                          alert('Configuraion Cargada!!');
                                        }


                                        function openDet(id){
                                          $('#modal1').attr('data-key',id);
                                          $('#modal1 > h4').html("Detalles del Campo: <span class='red-text'>"+id+"</span>");
                                          $('._pedir').each(function() {

                                            if ( ($(this).attr('data-type')=='text')||($(this).attr('data-type')=='sel')||($(this).attr('data-type')=='range') ){
                                              $(this).val($('#field-'+id+'-'+$(this).attr('id')).val());
                                            }

                                            if ( ($(this).attr('data-type')=='switch')||($(this).attr('data-type')=='check') ){

                                              if ($('#field-'+id+'-'+$(this).attr('id')).val()==$(this).attr('data-on')){

                                                this.checked=true;
                                              }else{
                                                this.checked=false;
                                              }
                                            }
                                          });

                                          valFunc();

                                          //$('select').formSelect();
                                          // actualizarUI();
                                          M.updateTextFields();
                                          //$('#modal1').modal('open');
                                          new Custombox.modal({
                                            content: {
                                              effect: 'fadein',
                                              target: '#modal1',
                                              onComplete: function(){
                                                actualizarUI();
                                              }
                                            }
                                          }).open();




                                          //  M.updateTextFields();

                                          return false;
                                        }



                                        function valFunc(){
                                          valUsof();
                                          valTipoLista();
                                          valFuncion();
                                        }

                                        function closeDet(){
                                          var id=$('#modal1').attr('data-key');

                                          $('._pedir').each(function() {

                                            if ( ($(this).attr('data-type')=='text')||($(this).attr('data-type')=='sel')||($(this).attr('data-type')=='range') ){
                                              $('#field-'+id+'-'+$(this).attr('id')).val($(this).val())
                                            }

                                            if ( ($(this).attr('data-type')=='switch')||($(this).attr('data-type')=='check')  ){
                                              if ($(this).is(':checked')){
                                                $('#field-'+id+'-'+$(this).attr('id')).val($(this).attr('data-on'));
                                              }else{
                                                $('#field-'+id+'-'+$(this).attr('id')).val($(this).attr('data-off'));
                                              }

                                            }


                                          });


                                          //$('#modal1').modal('close');
                                          Custombox.modal.close();
                                        }


                                        function valUsof(){

                                          $('#funcion').prop('disabled',false);

                                          var valor=$('#usof').val();
                                          if (!valor){
                                            valor='';
                                          }
                                          $('.usof').removeClass('s8').addClass('s12');
                                          $('.tam , .posf').hide();

                                          if ((valor!='-1')&&(valor!='oculto')&&(valor.trim()!='')){
                                            $('.usof').removeClass('s12').addClass('s8');
                                            $('.tam, .posf').show();
                                          }

                                          if (valor=='check'){
                                            $('#funcion').val('check').prop('disabled',true);
                                            $('#tipolista').val('check');
                                            valFuncion();
                                            valTipoLista();
                                          }

                                          if (valor=='selecdb'){
                                            $('#funcion').val('st');
                                            $('#tipolista').val('join');
                                            valFuncion();
                                            valTipoLista();
                                          }

                                          if (valor=='selecdbgrupo'){
                                            $('#funcion').val('st');
                                            $('#tipolista').val('join');
                                            valFuncion();
                                            valTipoLista();
                                          }

                                          if (valor=='selec'){
                                            $('#funcion').val('st');
                                            $('#tipolista').val('lista');
                                            valFuncion();
                                            valTipoLista();
                                          }

                                          if (valor=='float'){
                                            $('#funcion').val('bdf');
                                            valFuncion();
                                          }
                                          $('select').formSelect();
                                          M.updateTextFields();

                                        }

                                        function valFuncion(){


                                          var valor=$('#funcion').val();
                                          $('.funcion').removeClass('s10').addClass('s12');
                                          $('.dec, .fcustom, .checkvalor').hide();

                                          if (valor=='bdf'){
                                            $('.funcion').removeClass('s12').addClass('s10');
                                            $('.dec').show();
                                          }

                                          if (valor=='check'){
                                            $('.funcion').removeClass('s12').addClass('s10');
                                            $('.checkvalor').show();
                                          }

                                          if (valor=='custom'){
                                            $('.funcion').removeClass('s12').addClass('s10');
                                            $('.fcustom').show();
                                          }

                                        }

                                        function valTipoLista(){
                                          valor=$('#tipolista').val();
                                          $('.tipolista').removeClass('s6, s12').addClass('s9');
                                          $('.campojoin,  .checklista, .listalista').hide();
                                          $('.tamlista').show();

                                          if ((valor=='get')||(valor=='-1')){
                                            $('.tipolista').removeClass('s6, s9').addClass('s12');
                                            $('.tamlista').hide();
                                          }

                                          if (valor=='join'){
                                            $('.tipolista').removeClass('s12, s9').addClass('s6');
                                            $('.campojoin').show();
                                          }

                                          if (valor=='lista'){
                                            $('.tipolista').removeClass('s12, s9').addClass('s6');
                                            $('.listalista').show();
                                          }

                                          if (valor=='check'){
                                            $('.tipolista').removeClass('s12, s9').addClass('s6');
                                            $('.checklista').show();
                                          }



                                        }

                                        function validarFormulario(){
                                          $('#form1').submit();
                                        }


                                        function clicChecked(id){
                                          return false;
                                        }


                                        function openJoin(id){
                                          //$('#modal2').modal();

                                          $('#modal2').attr('data-key',id);
                                          var dato=$('#campojoin').val();
                                          if (dato==''){
                                            $('#n_table, #n_col').val(-1);
                                            $('#n_cond').val('');
                                            $('#n_tag').val('');
                                            $('#n_join').val('');
                                            $('#n_cb').val('');
                                            $('#n_carga').prop('checked',false);

                                          }else{
                                            dato=dato+'||||||';
                                            var datos=dato.split('|');
                                            $('#n_table').val(datos[0]);
                                            getCampos(datos[1]);

                                            $('#n_cond').val(datos[3]);
                                            $('#n_tag').val(datos[4]);
                                            $('#n_join').val(datos[5]);
                                            $('#n_cb').val(datos[6]);
                                            if (datos[2]=='1'){
                                              $('#n_carga').prop('checked',true);
                                            }else{
                                              $('#n_carga').prop('checked',false);
                                            }

                                          }
                                          //$('#modal2').modal('open');
                                          new Custombox.modal({
                                            content: {
                                              effect: 'fadein',
                                              target: '#modal2',
                                              onComplete: function(){
                                                actualizarUI();
                                              }
                                            }
                                          }).open();
                                          //$('select').formSelect();


                                        }

                                        function getCampos(valTarget){
                                          var dato=getSelAjax('#n_table',
                                          'index.php?crud=getCampos',
                                          '#n_col',
                                          valTarget
                                          );
                                        }

                                        function closeJoin(){
                                          var id=$('#modal2').attr('data-key');
                                          var ncarga=0;
                                          if ($('#n_carga').prop('checked')){
                                            ncarga=1;
                                          }
                                          var dato=$('#n_table').val()+'|'+$('#n_col').val()+'|'+ncarga+'|'+$('#n_cond').val()+'|'+$('#n_tag').val()+'|'+$('#n_join').val()+'|'+$('#n_cb').val();
                                          $('#'+id).val( dato );

                                          M.updateTextFields();
                                          //$('#modal2').modal('close');
                                          Custombox.modal.close();

                                        }

                                        var modalista=[];
                                        modalista['modal']='';
                                        modalista['campo']='';
                                        modalista['addTr']='';
                                        modalista['tit']='';
                                        modalista['head']='';
                                        var modalistalista=[];
                                        modalistalista['modal']='#modalLista';
                                        modalistalista['campo']='#listalista';
                                        modalistalista['addTr']='addTrListalista';
                                        modalistalista['tit']='Crear Lista';
                                        modalistalista['head']='<tr><th data-field="valor">VALOR</th><th data-field="texto">TEXTO</th><th data-field="tag">TAGS</th><th data-field="action">Accion</th></tr>';
                                        var modalistaeventos=[];
                                        modalistaeventos['modal']='#modalLista';
                                        modalistaeventos['campo']='#listaeventos';
                                        modalistaeventos['addTr']='addTrListaeventos';
                                        modalistaeventos['tit']='Lista de Eventos';
                                        modalistaeventos['head']='<tr><th data-field="evento">EVENTO</th><th data-field="codigo">CODIGO</th><th data-field="action">Accion</th></tr>';
                                        //$('#modalLista').modal();
                                        function openLista(objeto){
                                          if (!objeto){
                                            objeto=modalistalista;
                                          }
                                          modalista=objeto;
                                          var modal=modalista['modal'];
                                          var campo=modalista['campo'];
                                          $(modal).find('h4').html(modalista['tit']);
                                          $(modal+' thead').html(modalista['head']);

                                          //$(modal).modal();
                                          //$(modal).attr('data-key',id);

                                          var datos=$(campo).val()+'*';
                                          var tr=datos.split('*');
                                          $(modal+' tbody tr').remove();
                                          for (i = 0; i < tr.length; i++) {
                                            if (tr[i]!=''){
                                              var dato=(tr[i]).split('|');
                                              _addTr(i+1,dato);
                                            }
                                          }

                                          $(modal).find('#bAddLista').data('indice',tr.length);

                                          //alert(modal);
                                          new Custombox.modal({
                                            content: {
                                              effect: 'fadein',
                                              target: modal,
                                              onComplete: function(){
                                                actualizarUI();
                                              }
                                            }
                                          }).open();

                                          //$(modal).modal('open');

                                          //$('select').formSelect();
                                          // actualizarUI();
                                          $(modal).find("#tablalista tbody").sortable({
                                            axis:'y',
                                            containment: "parent",
                                            cursor: "move",
                                            forceHelperSize: true,
                                            handle: ".handle",
                                            opacity: 0.5
                                          });
                                        }

                                        function cAdd(){
                                          var modal=modalista['modal'];
                                          var campo=modalista['campo'];

                                          var dato=0;
                                          dato= $(modal).find('#bAddLista').data('indice');
                                          if (dato=='-1'){
                                            dato= $(modal).find('#tablalista tbody tr').length;
                                          }
                                          dato=dato+1;
                                          $(modal).find('#bAddLista').data('indice',dato);

                                          _addTr(dato,['','','']);
                                        }


                                        function cDel(id){
                                          var modal=modalista['modal'];
                                          $(modal).find('#trlista'+id).remove();
                                        }

                                        function cSaveLista(){
                                          var modal=modalista['modal'];
                                          var campo=modalista['campo'];
                                          var dato='';

                                          $(modal).find('#tablalista tbody tr').each(function( index ) {
                                            var i=$( this ).data('i');

                                            $(modal).find('.dato'+i).each(function( index ) {
                                              if ($( this ).prop("tagName")!='DIV'){
                                                dato=dato+$( this ).val()+'|';
                                              }
                                            });
                                            dato=dato+'*';
                                          });
                                          $(campo).val(dato);
                                        }

                                        function _addTr(i,dato){
                                          var funcion=modalista['addTr'];
                                          eval(funcion+'('+i+',dato);');
                                        }

                                        function addTrListalista(i,dato){
                                          $('#tablalista tbody').append('<tr id="trlista'+i+'" data-i="'+i+'">'+
                                            '<td><input id="valor'+i+'" type="text" class="validate dato'+i+'" value="'+dato[0]+'"></td>'+
                                            '<td><input id="texto'+i+'" type="text" class="validate dato'+i+'" value="'+dato[1]+'"></td>'+
                                            '<td><input id="tag'+i+'" type="text" class="validate dato'+i+'" value="'+dato[2]+'"></td>'+
                                            '<td> <i class="material-icons red-text" data-i="'+i+'" onclick="cDel('+i+');" style="cursor: pointer;" >delete</i> <i class="material-icons handle grey-text text-lighten-1 "  style="cursor: move;" >import_export</i> </td>'+
                                            '</tr>');
                                          }

                                          function getOptions(lista,sel){
                                            var r='';
                                            for(var i in lista){
                                              var s='';
                                              if (sel!=''){
                                                if (sel==i){
                                                  s=' selected="selected" ';
                                                }
                                              }
                                              r=r+'<option value="'+i+'" '+s+'>'+lista[i]+'</option>';
                                            }
                                            return r;
                                          }

                                          function addTrListaeventos(i,dato){
                                            var listaopciones=[];
                                            listaopciones['onchange']='onChange';
                                            listaopciones['onclick']='onClick';
                                            listaopciones['onblur']='onBlur';
                                            listaopciones['onfocus']='onFocus';
                                            listaopciones['onkeypress']='onKeyPress';
                                            var lista=getOptions(listaopciones,dato[0]);
                                            $('#tablalista tbody').append('<tr id="trlista'+i+'" data-i="'+i+'">'+
                                              '<td><select  id="evento'+i+'" type="text" class="validate dato'+i+'" >'+lista+'</select></td>'+
                                              '<td><input id="codigo'+i+'" type="text" class="validate dato'+i+'" value="'+dato[1]+'"></td>'+
                                              '<td> <i class="material-icons red-text" data-i="'+i+'" onclick="cDel('+i+');" style="cursor: pointer;" >delete</i> <i class="material-icons handle grey-text text-lighten-1 "  style="cursor: move;" >import_export</i> </td>'+
                                              '</tr>');
                                              $('select').formSelect();
                                            }

                                            function closeLista(){
                                              var modal=modalista['modal'];
                                              //var id=$(modal).attr('data-key');
                                              cSaveLista();
                                              M.updateTextFields();
                                              //$(modal).modal('close');
                                              Custombox.modal.close();
                                            }

                                            var idtabshow='';

                                          @append

                                          <!-- <h2 class="header">   Tabla: <span class="grey-text text-lighten-4">{{$database.'.'}}</span>{{$tableName}}</h2> -->

                                          <form action="index.php?crud=generar" id="form1" name="fom1" method="post">
                                            <div class="row">
                                              <div class="col s12">
                                                <ul id="tabs" class="tabs z-depth-1"">
                                                  <li class="tab col s3"><a class="active" href="#tabcampos">CAMPOS</a></li>
                                                  <li class="tab col s3"><a class="" href="#tabcodigos">CODIGOS</a></li>
                                                  <li class="tab col s3"><a  class="" href="#lista">LISTA</a></li>
                                                  <li class="tab col s3 "><a  class="" href="#formulario">FORMULARIO</a></li>
                                                </ul>
                                              </div>
                                              <div   id="tabcampos" class="col s12">

                                                <div class="input-field col s4">
                                                  <input id="singular" name='singular' type="text" class="validate plantilla " data-type="text" value="{{\Mk\Tools\Strings::singularize(ucfirst($tableName))}}">
                                                  <label for="singular" data-error="Debe escribir un nombre en singular" data-success="">Nombre del Modulo en Singular</label>
                                                </div>
                                                <div class="input-field col s4">
                                                  <input id="plural" name='plural' type="text" class="validate plantilla" data-type="text"  value="{{ucfirst($tableName)}}" >
                                                  <label for="plural" data-error="Debe escribir un nombre en plural" data-success="">Nombre del Modulo en plural</label>
                                                </div>
                                                <div class="input-field col s4">
                                                  <input id="seguridad" name='seguridad' type="text" class="validate plantilla " data-type="text" value="">
                                                  <label for="seguridad" data-error="Debe escribir una llave de seguridad" data-success="">llave de seguridad debe ser nombre de un Modulo</label>
                                                </div>


                                                <input id="listAction" name='listAction' type="hidden" class="validate plantilla "  value="show">
                                                @include(campos)
                                              </div>
                                              <div id="tabcodigos" class="col s12"><h3>Codigos en Formulario</h3>

                                                @foreach($_pedir as $pedir_i=>$pedir)
                                                  @if( ($pedir['type']=='codeeditor') )
                                                    <label for="{{$pedir_i}}" style="color: black;">{!!$pedir['text']!!}</label>
                                                    <textarea id="{{$pedir_i}}" name="{{$pedir_i}}" class="validate plantilla codejs" data-type="text"  ></textarea>
                                                  @endif
                                                @endforeach

                                              </div>
                                              <div id="lista" class="col s12">Lista
                                                <div class="list-content">

                                                </div>
                                              </div>

                                              <div id="formulario" class="col s12">

                                                <div id="f-1" class="col s3">
                                                  Componentes:
                                                  <hr>
                                                  <div id="panelComponentes"></div>
                                                </div>

                                                <div class="container col s6"  >

                                                  <div class="form-content row" style="padding-top: 30px;" >

                                                  </div>

                                                </div>


                                                <div id="f-3" class="col s3">
                                                  <div id='pindiv'>
                                                    <!-- Modal Structure -->
                                                    <div id="menu-campos-config" data-key="" class="oculto">
                                                      <strong style="font-size: 8px;">Opciones del Campo:</strong><h4 id="modal-tit" style="margin-top: 0px;"></h4>
                                                      <br>

                                                      <div class="modal-content z-depth-3"></div>

                                                      <div class="modal-footer">
                                                        <a class="modal-action  waves-effect waves-green btn-flat " id="config-borrar" onclick="Mk_Componentes.delConfig();">Borrar</a>
                                                        <a class="modal-action  waves-effect waves-green btn-flat" onclick="Mk_Componentes.closeConfig();">Cerrar</a>
                                                        <a class="modal-action  waves-effect waves-green btn-flat" onclick="Mk_Componentes.saveConfig();" >Grabar</a>
                                                      </div>
                                                    </div>
                                                    <!-- Modal Structure -->

                                                  </div>
                                                </div>
                                              </div>
                                            </div>

                                          </form>

                                          <!-- Modal Structure -->

                                          <div id="modal1" data-key="" class="modal modal-fixed-footer">
                                            <h4 id="modal-tit" style="border-bottom: 1px solid rgba(0, 0, 0, 0.1);background-color: #fafafa;border-radius:  2px 2px 0 0;height: 56px;position: absolute;top: 0;padding: 4px 6px;width: 100%;">Modal Header</h4>
                                            <div class="modal-content" style="margin-top:56px;height:calc(100% - 112px);">
                                              <div class="row">


                                                @foreach($_pedir as $pedir_i=>$pedir)

                                                  <?php  $ctam='s12'; if ($pedir['tam']!=''){$ctam=$pedir['tam'];}  ?>


                                                  @if( ($pedir['type']=='text') )



                                                    <div class="input-field col {{$ctam}} {{$pedir_i}}">
                                                      @if( ($pedir['icon']!='') )
                                                        <span onclick="{{$pedir['icon-click']}}"><i class="material-icons {{$pedir['icon-type']}}"  >{{$pedir['icon']}}</i></span>
                                                      @endif
                                                      <input id="{{$pedir_i}}" name='{{$pedir_i}}' type="text" class="validate _pedir" data-type="{{$pedir['type']}}" {{$pedir['disabled']}} {{$pedir['bind']}} >
                                                      <label for="{{$pedir_i}}" data-error="{{$pedir['error']}}" data-success="{{$pedir['ok']}}">{{$pedir['text']}}</label>
                                                    </div>

                                                  @endif

                                                  @if( ($pedir['type']=='int') )

                                                    <div class="input-field col {{$ctam}} {{$pedir_i}}">
                                                      @if( ($pedir['icon']!='') )
                                                        <i class="material-icons {{$pedir['icon-type']}}" >{{$pedir['icon']}}</i>
                                                      @endif
                                                      <input id="{{$pedir_i}}" name='{{$pedir_i}}' type="number" class="validate _pedir" data-type="{{$pedir['type']}}" {{$pedir['disabled']}} {{$pedir['bind']}}  @if( ($pedir['min']!='') ) min="{{$pedir['min']}}" @endif  @if( ($pedir['max']!='') ) max="{{$pedir['max']}}" @endif  >
                                                        <label for="{{$pedir_i}}" data-error="{{$pedir['error']}}" data-success="{{$pedir['ok']}}">{{$pedir['text']}}</label>
                                                      </div>

                                                    @endif

                                                    @if( ($pedir['type']=='sel') )

                                                      <div class="input-field col {{$ctam}} {{$pedir_i}}">
                                                        <select id="{{$pedir_i}}" name='{{$pedir_i}}' class="validate _pedir" data-type="{{$pedir['type']}}"  {{$pedir['disabled']}} {{$pedir['bind']}} >
                                                          {!!$pedir['opt']!!}
                                                        </select>
                                                        <label   for="{{$pedir_i}}" data-error="{{$pedir['error']}}" data-success="{{$pedir['ok']}}">{{$pedir['text']}}</label>
                                                      </div>

                                                    @endif

                                                    @if( ($pedir['type']=='range') )

                                                      <div class="input-field col {{$ctam}} {{$pedir_i}}">
                                                        <p class="range-field">
                                                          <input type="range" id="{{$pedir_i}}" name='{{$pedir_i}}' class="validate _pedir" data-type="{{$pedir['type']}}"  min="{{$pedir['min']}}" max="{{$pedir['max']}}" {{$pedir['disabled']}} {{$pedir['bind']}} >
                                                        </p>
                                                        <label  for="{{$pedir_i}}"  data-error="{{$pedir['error']}}" data-success="{{$pedir['ok']}}">{{$pedir['text']}}</label>
                                                      </div>

                                                    @endif

                                                    @if( ($pedir['type']=='switch') )

                                                      <div class=" col {{$ctam}} {{$pedir_i}}">
                                                        <label >{{$pedir['text']}}</label>
                                                        <div class="switch" onclick="clicChecked('{{$pedir_i}}')" >
                                                          <label>
                                                            {{$pedir['off']}}
                                                            <input type="checkbox" id="{{$pedir_i}}" name='{{$pedir_i}}' class=" _pedir" data-type="{{$pedir['type']}}" data-on="{{$pedir['onval']}}" data-off="{{$pedir['offval']}}"  {{$pedir['disabled']}} {{$pedir['bind']}} >
                                                            <span class="lever"></span>
                                                            {{$pedir['on']}}
                                                          </label>
                                                        </div>

                                                      </div>

                                                    @endif

                                                    @if( ($pedir['type']=='check') )

                                                      <div class="col {{$ctam}} {{$pedir_i}}">

                                                        <p onclick="clicChecked('{{$pedir_i}}')">
                                                          <label  for="{{$pedir_i}}" >
                                                            <input type="checkbox" id="{{$pedir_i}}" name='{{$pedir_i}}' class=" _pedir" data-type="{{$pedir['type']}}" data-on="{{$pedir['onval']}}" data-off="{{$pedir['offval']}}" {{$pedir['disabled']}} {{$pedir['bind']}} />
                                                            <span>{{$pedir['text']}}</span>
                                                          </label>
                                                        </p>
                                                      </div>

                                                    @endif

                                                    @if( ($pedir['type']=='raw') )
                                                      {!!$pedir['text']!!}
                                                    @endif


                                                  @endforeach

                                                </div>


                                              </div>
                                              <div class="modal-footer">
                                                <button class="modal-action  waves-effect waves-green btn-flat" onclick="closeDet();">Ok</button>


                                              </div>
                                            </div>

                                            <!-- Modal Structure -->
                                            <div id="modal2" data-key="" class="modal modal-fixed-footer">
                                              <div class="modal-content">
                                                <h4 id="modal-tit">Escojer Tabla y Campo</h4>


                                                <div class="row">


                                                  <div class="input-field col {{$ctam}}">
                                                    <select id="n_table" name='n_table' class="validate" onchange="getCampos();"  >
                                                      {{$_tablas}}
                                                    </select>
                                                    <label   for="n_table" >Tabla:</label>
                                                  </div>

                                                </div>


                                                <div class="row">


                                                  <div class="input-field col {{$ctam}}">

                                                    <select id="n_col" name='n_col' class="validate"   >
                                                    </select>
                                                    <label   for="n_col" >Columna:</label>
                                                  </div>

                                                  <div class="col {{$ctam}} ">
                                                    <input type="checkbox" id="n_carga" name='n_carga' class="" value="1" />
                                                    <label  for="n_carga" >Cargar por Ajax cada que muestre formulario?</label>
                                                  </div>

                                                  <div class="input-field col {{$ctam}} ">
                                                    <input id="n_cond" name='n_cond' type="text" class="validate" value="" >
                                                    <label for="n_cond" >Condicion Extra:</label>
                                                  </div>
                                                  <div class="input-field col {{$ctam}} ">
                                                    <input id="n_join" name='n_join' type="text" class="validate" value="" >
                                                    <label for="n_join" >Join Extra:</label>
                                                  </div>
                                                  <div class="input-field col {{$ctam}} ">
                                                    <input id="n_tag" name='n_tag' type="text" class="validate" value="" >
                                                    <label for="n_tag" >Datos Tag:</label>
                                                  </div>
                                                  <div class="input-field col {{$ctam}} ">
                                                    <input id="n_cb" name='n_tag' type="text" class="validate" value="" >
                                                    <label for="n_cb" >Campos Extra Busqueda:</label>
                                                  </div>


                                                </div>
                                              </div>
                                              <div class="modal-footer">
                                                <button class="modal-action  waves-effect waves-green btn-flat" onclick="closeJoin();">Ok</button>

                                              </div>
                                            </div>

                                            <!-- Modal Structure -->
                                            <div id="modalLista" data-key="" class="modal modal-fixed-footer">
                                              <div class="modal-content">
                                                <h4 id="modal-tit">Crear lista</h4>
                                                <div class="row ">
                                                  <div class="col s10">

                                                  </div>

                                                  <div class="col s2">
                                                    <div class="btn z-depth-2 waves-effect waves-light green" onclick="cAdd();" id="bAddLista" data-indice='-1' >Adicionar</div>
                                                  </div>
                                                </div>


                                                <div class="row">



                                                  <table class="striped" id="tablalista">
                                                    <thead>
                                                      <tr>
                                                        <th data-field="valor">valor</th>
                                                        <th data-field="texto">texto</th>
                                                        <th data-field="tag">tags</th>
                                                        <th data-field="action">Accion</th>
                                                      </tr>
                                                    </thead>

                                                    <tbody>


                                                    </tbody>
                                                  </table>


                                                </div>



                                              </div>
                                              <div class="modal-footer">
                                                <button class="modal-action  waves-effect waves-green btn-flat" onclick="closeLista();">Ok</button>

                                              </div>
                                            </div>
