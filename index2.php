<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html xmlns="http://www.w3.org/1999/xhtml"
      xmlns:ui="http://java.sun.com/jsf/facelets"
      xmlns:f="http://java.sun.com/jsf/core"
      xmlns:h="http://java.sun.com/jsf/html"
      xmlns:icecore="http://www.icefaces.org/icefaces/core"
      xmlns:ace="http://www.icefaces.org/icefaces/components"
      xmlns:ice="http://www.icesoft.com/icefaces/component"
      xml:lang="es" lang="es"
      >
    <h:head>
        <link rel="stylesheet" type="text/css" href="css/style.css" />
        <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.5.1/jquery.min.js"></script>
        <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.8.11/jquery-ui.min.js"></script>
        <title>Drag and Drop</title>
        <script type="text/javascript" >
        	
jQuery(function(){

    counter = 0;

    jQuery('.Artefacto').draggable({
        helper: 'clone',
        containment: '#areaDibujo',
        stop:function(ev, ui) {
            //al arrastrar el primer elemento
            var pos=jQuery(ui.helper).offset();
            objName = "#clonediv"+counter
            jQuery(objName).css({
                "left":pos.left,
                "top":pos.top
            });
            jQuery(objName).removeClass("Artefacto");
            //Para elementos existentes en el área
            jQuery(objName).draggable({
                containment: 'parent',
                stop:function(ev, ui) {
                    var pos=jQuery(ui.helper).offset();
                }
            });
        }
    });

    jQuery("#areaDibujo").droppable({
        drop: function(ev, ui) {
            if (ui.helper.attr('id').search(/Artefacto[0-9]+/) != -1){
                counter++;
                var element=jQuery(ui.draggable).clone();
                element.addClass("tempclass");
                jQuery(this).append(element);
                jQuery(".tempclass").attr("id","clonediv"+counter);
                jQuery("#clonediv"+counter).removeClass("tempclass");
                //Get the dynamically item id
                draggedNumber = ui.helper.attr('id').search(/Artefacto([0-9]+)/)
                itemDragged = "dragged" + RegExp.$1
                jQuery("#clonediv"+counter).addClass(itemDragged);
            }
        }
    });

});

        </script>
        <!--<link rel="stylesheet" type="text/css" href="./xmlhttp/css/rime/rime.css"/>-->

    </h:head>

    <h:body>

        <div id="contenedor">
            <div id="panelArtefactos">
                <h3>Artefactos</h3>
                <div id="Artefacto">
                    <div id="Artefacto1" class="Artefacto" styleClass="ui-widget-content">Entidad</div>
                    <br/>
                    <div id="Artefacto1" class="Artefacto">Claves</div>
                    <br/>
                    <div id="Artefacto1" class="Artefacto">Atributos</div>
                </div>
            </div>

            <div id="areaDibujo">
                AREA DE DIBUJO...
            </div>
        </div>
    </h:body>
</html>