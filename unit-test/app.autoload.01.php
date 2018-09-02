<?php
if (UNIT_TEST_MODE) {
    echo '<br><div class="start-line">' . basename(__FILE__) . '</div>';

    echo '#[app.autoload.php] :: $stack_class: |<br>';
    print_r($stack_class);
    echo '<br>';
}
