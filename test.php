<?php
$in = 'vinh[otsection]lala[/otsection]asdsad[otsection]kaka[/otsection]';

$out = preg_replace_callback(
    "(\[otsection\](.*?)\[/otsection\])is",
    function ($m) {
        static $id = 0;
        $id++;
        return "<div class=\"otsection\" id=\"ots" . $id . "\">" . $m[1] . "</div>";
    },
    $in);

echo $out;

$data = 0;
if ($data !== null) {
    echo '# null';
}

$result = preg_match('|^user/info$|i', 'user/infe');
var_dump($result);
if ($result) {
    echo 'pass';
}
