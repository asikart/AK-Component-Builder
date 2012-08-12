<?php
include 'configuration.php';
$config = new JConfig();
echo addslashes($config->password) ;
exit;
