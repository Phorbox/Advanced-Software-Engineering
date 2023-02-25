<?php
$files=array('splitmentaa','splitmentab','splitmentac','splitmentad','splitmentae','splitmentaf','splitmentag','splitmentah','splitmentai','splitmentaj','splitmentak');
foreach ($files as $pid=>$fileName) {
    shell_exec("/usr/bin/php /var/www/html/importerArg.php $pid $fileName > /var/www/html/$fileName.log 2>/var/www/html/$fileName.log &");
}
echo "Main Process Done\n";

