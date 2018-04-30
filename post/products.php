<?php
$open = true;		// Can be accessed when not logged in
require '../lib/site.inc.php';

$controller = new Recommendation\ProductsController($site,$user,$_POST);
header("location: " . $controller->getRedirect());