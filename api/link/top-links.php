<?php

/** @var object $app */

$limit = $_REQUEST['limit'] ?? 17;
$limit = (int)$limit;

$sql = "select count(l.id) as cnt, l.* 
        from link_view lv join link l on l.id=link_id 
        group by l.id order by cnt desc, name limit $limit";

$rows = $app->pdo->query($sql);

$data = [];

while ($row = $rows->fetchObject()) {
    $link = (object)[
        'id'   => $row->id,
        'name' => $row->name,
        'href' => $row->href,
        'icon' => 'https://api.aftaa.ru' . $row->icon,
    ];
    $data[] = $link;
}

return [
    'columns' => $data,
];
