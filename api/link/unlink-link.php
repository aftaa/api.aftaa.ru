<?php

$sql = 'update link set deleted=true where id=:id';
$stmt = $app->pdo->prepare($sql);

$stmt->execute([
    'id' => $_REQUEST['id'],
]);

echo $stmt->rowCount();
