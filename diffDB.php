<?php

$link1 = mysqli_connect("172.16.88.100", "root", "", "cardstore1.0", "3306");
$link2 = mysqli_connect("172.16.88.100", "root", "", "cardstore", "3306");
mysqli_query($link1, "set names utf8");
mysqli_query($link2, "set names utf8");

$sql1 = "show tables";
$ret1 = mysqli_query($link1, $sql1);
while ($row1 = mysqli_fetch_assoc($ret1)) {
    $tables1[] = $row1["Tables_in_cardstore1.0"];
}


$sql2 = "show tables";
$ret2 = mysqli_query($link2, $sql2);
while ($row2 = mysqli_fetch_assoc($ret2)) {
    $tables2[] = $row2["Tables_in_cardstore"];
}

$diffarr = array_diff($tables2, $tables1);
var_dump($diffarr);
foreach ($diffarr as $val2) {
    $diff_table_diff = "show create table " . $val2;
    $diff_ret_2      = mysqli_query($link2, $diff_table_diff);
    $diff_table_sql  = mysqli_fetch_all($diff_ret_2, MYSQLI_ASSOC);
    print_r($diff_table_sql[0]['Create Table'] . ";");
    echo '<br />';
}


$intersectarr = array_intersect($tables2, $tables1);
foreach ($intersectarr as $inter) {
    $rowColumns1 = [];
    $sqlColumns1 = "show columns from " . $inter;
    $retColumns1 = mysqli_query($link1, $sqlColumns1);
    while ($row1 = mysqli_fetch_assoc($retColumns1)) {
        $rowColumns1[] = $row1["Field"] . "#" . $row1["Type"];
    }

    $rowColumns2 = [];
    $sqlColumns2 = "show columns from " . $inter;
    $retColumns2 = mysqli_query($link2, $sqlColumns2);
    while ($row2 = mysqli_fetch_assoc($retColumns2)) {
        $rowColumns2[] = $row2["Field"] . "#" . $row2["Type"];
    }

    $diff = array_diff($rowColumns2, $rowColumns1);
    if (!empty($diff)) {
        foreach ($diff as $val) {
            $arr = explode("#", $val);
            echo 'alter table ' . $inter . " add column " . $arr[0] . " " . $arr[1] . " not null default '' ; <br />";
        }

//        var_dump($diff);
    }
}





