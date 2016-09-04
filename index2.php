<?php 
$_data= array();
if (is_array($_data) && sizeof($_data))
        extract($_data); $_text = array();$_text[] = "

  

    

      

        CRUD ";$_text[] = "
";$_text[] =  $tableName ;$_text[] = "
";$_text[] = "
        


     home

     search


      

    

  

        

";return implode($_text);
?>