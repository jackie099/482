<?php
$open = true;
require 'lib/site.inc.php';
$p=new \Recommendation\Products($site);

if(isset($_GET['uid'])&&isset($_GET['first'])&&isset($_GET['second'])&&isset($_GET['third']))
{
    $uid = $_GET['uid'];
    $first=$_GET['first'];
    $second =$_GET['second'];
    $third =$_GET['third'];
    $p->saveRecommendation($uid,$first,$second,$third);
}
else{
    echo("jackiedsb");

}





