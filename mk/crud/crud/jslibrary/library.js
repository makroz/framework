[[js:]]iDisabledCheck::
function iDisabledCheck(check,target,val){
    if (!val){
      val='';
    }
    var c= $(check).is(':checked');
    if (c==true){
      $(target).attr('old_check_value',$(target).val()).prop('disabled',true).val(val);
    }else{
      $(target).prop('disabled',false).val($(target).attr('old_check_value'));
    }
    M.updateTextFields();
  }
[[:js]]