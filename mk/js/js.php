//js.php
require 'jsmin.php';

function checkCanGzip(){
    if (array_key_exists('HTTP_ACCEPT_ENCODING', $_SERVER)) {
        if (strpos($_SERVER['HTTP_ACCEPT_ENCODING'], 'gzip') !== false) return "gzip";
        if (strpos($_SERVER['HTTP_ACCEPT_ENCODING'], 'x-gzip') !== false) return "x-gzip";
    }
    return false;
}

function gzDocOut($contents, $level=6){
    $return = array();
    $return[] = "\x1f\x8b\x08\x00\x00\x00\x00\x00";
    $size = strlen($contents);
    $crc = crc32($contents);
    $contents = gzcompress($contents,$level);
    $contents = substr($contents, 0, strlen($contents) - 4);
    $return[] = $contents;
    $return[] = pack('V',$crc);
    $return[] = pack('V',$size);
    return implode(null, $return);
}

$ite = new RecursiveDirectoryIterator(dirname(__FILE__));
foreach(new RecursiveIteratorIterator($ite) as $file => $fileInfo) {
    $extension = strtolower(pathinfo($file, PATHINFO_EXTENSION));
    if ($extension == 'js') {
        $f = $fileInfo->openFile('r');
        $fdata = "";
        while ( ! $f->eof()) {
            $fdata .= $f->fgets();
        }
        $buffer[] = $fdata;
    }
}

$output = JSMin::minify(implode(";\n", $buffer));

header("Content-type: application/x-javascript; charset: UTF-8");
$forceGz    = filter_input(INPUT_GET, 'gz', FILTER_SANITIZE_STRING);
$forcePlain = filter_input(INPUT_GET, 'plain', FILTER_SANITIZE_STRING);

$encoding = checkCanGzip();
if ($forceGz) {
    header("Content-Encoding: {$encoding}");
    echo gzDocOut($output);
} elseif ($forcePlain) {
    echo $output;
} else {
    if ($encoding){
        header("Content-Encoding: {$encoding}");
        echo GzDocOut($output);
    } else {
        echo $output;
    }
}
