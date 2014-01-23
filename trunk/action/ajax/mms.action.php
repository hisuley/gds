<?php
/**
 * Created by PhpStorm.
 * User: suley
 * Date: 1/9/14
 * Time: 4:38 PM
 */


require("foundation/nusoap/nusoap.php");
require('foundation/module_category.php');

dbtarget('r', $dbServs);
$dbo = new dbex();
$table = $tablePreStr . "category";
$result = get_sub_under($dbo, $table, '433');
print_r($result);

?>
