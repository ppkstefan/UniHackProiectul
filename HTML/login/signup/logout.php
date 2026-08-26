<?php
session_start();


session_unset(); 
session_destroy(); 


header("Location: \\myapp\\UniHackProiectul\\HTML\\test_main.html");
exit; 
?>
