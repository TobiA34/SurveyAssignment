<?php

// Things to notice:
// This script is called by every other script (via require_once)
// It finishes outputting the HTML for this page:
// don't forget to add your own name and student number to the footer
date_default_timezone_set('Europe/London');
$sTime = date("d-m-Y");

echo <<<_END
    <div id="footer">
    <br>
    <p>&copy;6G5Z2107 - Tobi Adegoroye - 18011328 - 2019/20 ($sTime)</p>
    </div>
    </body>
    </html>
_END;
?>
