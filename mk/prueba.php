<?php
if (is_array($_data) && sizeof($_data))
  extract($_data); $_text = array();$_text[] = "

<div class=\"navbar-fixed\">
  <nav>
    <div class=\"nav-wrapper\">
      <a href=\"#!\" class=\"brand-logo\">Logo</a>
      <ul class=\"right hide-on-med-and-down\">
        <li><a href=\"/\" > home</a></li>
        <li><a href = \"index.php?url=user/search\" > search</a></li>
        ";if (isset($user)) {$_text[] = "
        <li><a href = \"index.php?url=user/profile\" > profile</a></li>
        <li><a href = \"index.php?url=user/settings\" > settings</a></li>
        <li><a href = \"index.php?url=user/logout\" > logout</a></li>
        ";if () {else {$_text[] = "
        <li><a href = \"index.php?url=user/register\" > register</a></li>
        <li><a href = \"index.php?url=user/login\" > login</a></li>
        ";}$_text[] = "        </ul>
      </div>
    </nav>
  </div>
  

  ";}}return implode($_text);<hr>if (is_array($_data) && sizeof($_data))
  extract($_data); $_text = array();$_text[] = "
  <!DOCTYPE html>
  <html>
  <head>

    ";$_text[] = "

    ";$_text[] = "

    ";$_text[] = "

    
    <meta name=\"viewport\" content=\"width=device-width, initial-scale=1.0\"/>

    ";$_text[] = "";$_text[] = "

    ";$_text[] = "";$_text[] = "
    <style>
      ";$_text[] = "";$_text[] = "
    </style>
    ";$_text[] = "";$_text[] = "


  </head>

  <body>
    ";function anon_0($_data){
      if (is_array($_data) && sizeof($_data))
        extract($_data); $_text = array();$_text[] = "

      <div class=\"navbar-fixed\">
        <nav>
          <div class=\"nav-wrapper\">
            <a href=\"#!\" class=\"brand-logo\">Logo</a>
            <ul class=\"right hide-on-med-and-down\">
              <li><a href=\"/\" > home</a></li>
              <li><a href = \"index.php?url=user/search\" > search</a></li>
              ";if (isset($user)) {$_text[] = "
              <li><a href = \"index.php?url=user/profile\" > profile</a></li>
              <li><a href = \"index.php?url=user/settings\" > settings</a></li>
              <li><a href = \"index.php?url=user/logout\" > logout</a></li>
              ";if () {else {$_text[] = "
              <li><a href = \"index.php?url=user/register\" > register</a></li>
              <li><a href = \"index.php?url=user/login\" > login</a></li>
              ";}$_text[] = "        </ul>
            </div>
          </nav>
        </div>
        

        ";}}return implode($_text);
      };$_text[] = anon_0($_data);$_text[] = "
      ";$_text[] =  $template;$_text[] = "




      ";$_text[] = "";$_text[] = "
      <script >
        $(document).ready(function(){
         var a=2;
         if (a==2){
           a=a+5;
           alert(a);
         }
       });

       ";$_text[] = "";$_text[] = "
     });

     ";$_text[] = "";$_text[] = ");

     ";$_text[] = "";$_text[] = "
   </script>
 </body>
 </html>



 ";return implode($_text);
 ?>
