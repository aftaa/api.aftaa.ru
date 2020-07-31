<?php

/** @var object $app */

$sql = "select id, name from link_block where deleted=false order by col_num, sort";

/** @var PDOStatement $stmt */
$stmt = $app->pdo->prepare($sql);
$stmt->execute();
$fetchAll = $stmt->fetchAll();

$blocksList = [];
foreach ($fetchAll as $row) {
    $blocksList[$row['id']] = $row['name'];
}

return $blocksList;
