<?php
function __autoload($uix)
{
    /*
    UIX:
    Category : First Char Upper
    Filename : First Char Lower To The End
     */
    // STACK
    $stack_uix = explode('_', $uix);
    $path = '';
    foreach ($stack_uix as $word) {
        if (ctype_upper($word[0])) {
            $path .= strtolower($word) . '/';
        } else {
            // FOUNDED FILE NAME
            $path .= strtolower($word) . '_';
        }
    }
    // OMIT LAST CHAR '_'
    $ready_path = substr($path, 0, -1) . '.php';
    include $ready_path;
}
