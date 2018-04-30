<?php
$open = true;
require 'lib/site.inc.php';
$p=new \Recommendation\Products($site);

$all=$p->getAllRated();
//print_r($all);
foreach ($all as $rated)
{
    echo ($rated['userid'].",".$rated['itemid'].",".$rated['rating'].'|');

}

