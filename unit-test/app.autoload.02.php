<?php
if (UNIT_TEST_MODE) {
    echo '<br><div class="start-line">' . basename(__FILE__) . '</div>';

    echo '#[app.autoload.php] :: $ready_path: ' . $ready_path . '<br>';
}
