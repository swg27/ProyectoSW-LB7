<?php

error_reporting(~E_DEPRECATED & ~E_NOTICE);

define('DBHOST', 'localhost');
define('DBUSER', 'root');
define('DBPASS', '');
define('DBNAME', 'Preguntas');
$conn = mysqli_connect(DBHOST, DBUSER, DBPASS, DBNAME)
or die("Database Connection failed : " . mysqli_error());

//echo "Database successfully connected ";

?>