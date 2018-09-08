@section('js.onready')
$('.mk-section').each(function(){
	var html=$(this).html();
	html='<div class="mk-edit-box"><span class="mk-edit-edit">edit</span><span class="mk-edit-save">save</span><div class="mk-edit-text">'+
		html+
		'</div></div>';
		$(this).html(html);
	
	});

$('.mk-edit-edit').click(function(){
	var obj=$(this).parent();
  $(this).hide();
  $('.mk-edit-box',obj).addClass('mk-edit-editable');
  $('.mk-edit-text',obj).attr('contenteditable', 'true');  
  $('.mk-edit-save',obj).show();
});

$('.mk-edit-save').click(function(){
var obj=$(this).parent();
  $(this).hide();
  $('.mk-edit-box',obj).removeClass('mk-edit-editable');
  $('.mk-edit-text',obj).removeAttr('contenteditable');
  $('.mk-edit-edit',obj).show();
});
@append 


@section('style.inline')

.mk-edit-box {
  position: relative;
  margin: 0px;
  padding: 5px;
  background: #fff;
}

.mk-edit-box:hover{
  border: 1px dotted red;
  border-radius: 3px;
  padding:4px;

}
.mk-edit-editable {
  border-color: #bd0f18;
  box-shadow: inset 0 0 10px #555;
  background: #f2f2f2;
  padding: 4px;
  border: 1px solid grey;
  border-radius: 3px;
}

.mk-edit-text {
  outline: none;
}

.mk-edit-edit, .mk-edit-save {
  width: 50px;
  display: block;
  position: absolute;
  top: 0px;
  right: 0px;
  padding: 4px 10px;
  border-top-right-radius: 2px;
  border-bottom-left-radius: 10px;
  text-align: center;
  cursor: pointer;
  box-shadow: -1px 1px 4px rgba(0,0,0,0.5);
}

.mk-edit-edit { 
  background: #557a11;
  color: #f0f0f0;
  opacity: 0;
  transition: opacity .2s ease-in-out;
}

.mk-edit-save {
  display: none;
  background: #bd0f18;
  color: #f0f0f0;
}

.mk-edit-box:hover .mk-edit-edit {
  opacity: 1;
}

.mk-section{

}

@append 
