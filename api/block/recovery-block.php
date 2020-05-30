<?php

$sql = 'update link_block set deleted=false where id=:id';
$stmt = $pdo->prepare($sql);

$stmt->execute([
    'id' => $_REQUEST['id'],
]);

echo $stmt->rowCount();
