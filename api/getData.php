<?php

require __DIR__.'/include/DB.php';

sqlconnect();

echo json_encode(sqlSelectAll($_POST['start'], $_POST['next']));
