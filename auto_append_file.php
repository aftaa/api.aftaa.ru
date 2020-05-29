<?php

echo json_encode((object)[
    'success' => true,
    'response' => ob_get_clean(),
]);
