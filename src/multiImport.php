<?php
// $files=array('splitmentaa','splitmentab','splitmentac','splitmentad','splitmentae','splitmentaf','splitmentag','splitmentah','splitmentai','splitmentaj','splitmentak','splitmental','splitmentam','splitmentan','splitmentao','splitmentap','splitmentaq','splitmentar','splitmentas','splitmentat','splitmentau','splitmentav','splitmentaw','splitmentax','splitmentay','splitmentaz','splitmentba','splitmentbb','splitmentbc','splitmentbd','splitmentbe','splitmentbf','splitmentbg','splitmentbh','splitmentbi','splitmentbj','splitmentbk','splitmentbl','splitmentbm','splitmentbn','splitmentbo','splitmentbp','splitmentbq','splitmentbr','splitmentbs','splitmentbt','splitmentbu','splitmentbv','splitmentbw','splitmentbx','splitmentby','splitmentbz','splitmentca','splitmentcb','splitmentcc','splitmentcd','splitmentce','splitmentcf','splitmentcg','splitmentch','splitmentci','splitmentcj','splitmentck','splitmentcl','splitmentcm','splitmentcn','splitmentco','splitmentcp','splitmentcq','splitmentcr','splitmentcs','splitmentct','splitmentcu','splitmentcv','splitmentcw','splitmentcx','splitmentcy','splitmentcz','splitmentda','splitmentdb','splitmentdc','splitmentdd','splitmentde','splitmentdf','splitmentdg','splitmentdh','splitmentdi','splitmentdj','splitmentdk','splitmentdl','splitmentdm','splitmentdn','splitmentdo','splitmentdp','splitmentdq','splitmentdr','splitmentds','splitmentdt','splitmentdu','splitmentdv','splitmentdw');
$files=array('splitmentaa','splitmentab','splitmentac','splitmentad','splitmentae','splitmentaf','splitmentag','splitmentah','splitmentai','splitmentaj','splitmentak');
foreach ($files as $pid=>$fileName) {
    $command = "/usr/bin/php /var/www/html/advanced-software-project/src/importerArg.php $pid ../data/splitter/$fileName > /var/www/html/importLog/$fileName.log 2>/var/www/html/importLog/$fileName.log &";
    echo ($command . "\n") ;
    shell_exec($command);
}
echo "Main Process Done\n";

