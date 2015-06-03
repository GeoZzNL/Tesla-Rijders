<?php
    function makeFriendlyFix($string){
        $string = strtolower(trim($string));
        $string = str_replace("'", '', $string);
        $string = preg_replace('#[ ]+#', '_', $string);
        $string = preg_replace('#[^0-9a-z\-]+#', '_', $string);
        $string = preg_replace('#_{2,}#', '_', $string);
        $string = preg_replace('#_-_#', '-', $string);
        return preg_replace('#(^_+|_+$)#D', '', $string);
    }
?>