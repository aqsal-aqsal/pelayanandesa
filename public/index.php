<?php

session_save_path(sys_get_temp_dir());
if (!session_id()) session_start();

require_once '../app/init.php';

$app = new App;
