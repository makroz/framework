<?php

namespace Mk
{
    class Debug
    {

        public function __construct()
        {
        // do nothing
        }
        public function __clone()
        {
        // do nothing
        }
        public static function init()
        {
        // do nothing

        }

        public static function msgfile($msg,$file=''){
            if ($file==''){
                $file='\log'.date('Ymd').'.txt';

            }
            file_put_contents($file, "*********\n\r\l\ln".$msg, FILE_APPEND);
        }

        public static function msg($msg, $key = "",$nivel=2)
        {
            if (DEBUG>=$nivel)
            {    
                echo "<h3>DEBUG msg ($key) </h3><pre>";
                @print_r($msg);
                echo "</pre>";
            }
        }
        public static function smsg($msg,$title='',$nivel=3)
        {
            if (DEBUG>=$nivel)
            {    
                
                if ($title!='')
                {
                    $msg="<span style='color:red;'>$title: </span>$msg";
                }
                $msg="<div >".$msg."</div>"; 

                echo $msg;
            }
        }
        /**
        * jdebug() - provide a Java style exception trace
        * @param $exception
        * @param $seen      - array passed to recursive calls to accumulate trace lines already seen
        *                     leave as NULL when calling this function
        * @return array of strings, one entry per trace line
        */
        public static function jdebug($e, $seen=null) {
            $starter = $seen ? 'Causado por: ' : '';
            $result = array();
            if (!$seen) $seen = array();
            $trace  = $e->getTrace();
            $prev   = $e->getPrevious();
            $result[] = sprintf('%s%s: %s', $starter, get_class($e), $e->getMessage());
            if (DEBUG>=1)
            {    

                $file = $e->getFile();
                $line = $e->getLine();
                while (true) {
                    $current = "$file:$line";
                    if (is_array($seen) && in_array($current, $seen)) {
                        $result[] = sprintf(' ... %d mas', count($trace)+1);
                        //break;
                    }
                    $result[] = sprintf(' at %s%s%s(%s%s%s)',
                        count($trace) && array_key_exists('class', $trace[0]) ? str_replace('\\', '.', $trace[0]['class']) : '',
                        count($trace) && array_key_exists('class', $trace[0]) && array_key_exists('function', $trace[0]) ? '.' : '',
                        count($trace) && array_key_exists('function', $trace[0]) ? str_replace('\\', '.', $trace[0]['function']) : '(main)',
                        $line === null ? $file : basename($file),
                        $line === null ? '' : ':',
                        $line === null ? '' : $line);
                    if (is_array($seen))
                        $seen[] = "$file:$line";
                    if (!count($trace))
                        break;
                    $file = array_key_exists('file', $trace[0]) ? $trace[0]['file'] : 'Origen Desconocido';
                    $line = array_key_exists('file', $trace[0]) && array_key_exists('line', $trace[0]) && $trace[0]['line'] ? $trace[0]['line'] : null;
                    array_shift($trace);
                }
            }
            $result = join("\n", $result);
            if ($prev)
                $result  .= "\n" . self::jdebug($prev, $seen);

            return $result;
        }


    }
}
?>