<?php

require __DIR__.'/include/DB.php';

sqlconnect();

echo json_encode(sqlselectSearch($_POST['search'], $_POST['start'], $_POST['next']));