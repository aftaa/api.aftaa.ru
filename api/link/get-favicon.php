<?php

$originUrl = $_POST['origin'];
$name   = $_POST['name'];

$faviconContent = file_get_contents($originUrl);

if (false === $faviconContent) {
    throw new Exception("Can't get $originUrl");
}

$faviconExt = pathinfo($originUrl, PATHINFO_EXTENSION);
$faviconFileName = "$name.$faviconExt";
$faviconFileName = "$_SERVER[DOCUMENT_ROOT]/favicons/$faviconFileName";

if (!file_put_contents($faviconFileName, $faviconContent)) {
    throw new Exception("Can't set $faviconFileName");
}

$myFaviconUrl = "/favicons/$name.$faviconExt";

return $myFaviconUrl;
