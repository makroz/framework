@if( $_action!='add' ) 
<img src="upload\{{$_mod}}-[[var:]]idfile[[:var]]-{{$item[pk]}}.png"><br>
 @endif
@if( $_action!='ver' )
<input type="file" name="[[var:]]idfile[[:var]]" id="[[var:]]idfile[[:var]]">
 @endif
