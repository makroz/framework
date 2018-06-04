
<h1>Selecciones la sucursal que desea ingresar</h1>
Ip: 
<?php 
function get_client_ip() {
        $ipaddress = '';
        if (getenv('HTTP_CLIENT_IP'))
            $ipaddress = getenv('HTTP_CLIENT_IP');
        else if(getenv('HTTP_X_FORWARDED_FOR'))
            $ipaddress = getenv('HTTP_X_FORWARDED_FOR');
        else if(getenv('HTTP_X_FORWARDED'))
            $ipaddress = getenv('HTTP_X_FORWARDED');
        else if(getenv('HTTP_FORWARDED_FOR'))
            $ipaddress = getenv('HTTP_FORWARDED_FOR');
        else if(getenv('HTTP_FORWARDED'))
           $ipaddress = getenv('HTTP_FORWARDED');
        else if(getenv('REMOTE_ADDR'))
            $ipaddress = getenv('REMOTE_ADDR');
        else
            $ipaddress = 'UNKNOWN';
        return $ipaddress;
    }

echo get_client_ip().' - ';
echo $_SERVER["REMOTE_ADDR"];
?>
<br>

<a href="http://www.netpizza.com.bo/admin"><button>Sucursal Sur</button></a>
<a href="http://200.119.201.114/admin"><button>Sucursal Norte</button></a>
<a href="http://190.186.70.162/admin"><button>Sucursal Beni</button></a>