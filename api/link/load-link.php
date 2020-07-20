<?php

/** @var object $app */

$sql = "select * from link where id=:id";

/** @var PDOStatement $stmt */
$stmt = $app->pdo->prepare($sql);
$stmt->execute([
    'id' => $_GET['id'],
]);

return $stmt->fetchObject();
