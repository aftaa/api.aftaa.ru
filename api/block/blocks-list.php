<?php

/** @var object $app */

$sql = "select id, name from block where deleted=false order by col_num, sort";

/** @var PDOStatement $stmt */
$stmt = $app->pdo->prepare($sql);
$stmt->execute();

$blocksList = [];

foreach ($stmt->fetchObject() as $row) {
    $blocksList[(int)$row->id] = $row->name;
}

return $blocksList;
