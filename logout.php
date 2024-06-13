<?php
session_start();
session_unset();
session_destroy();
header('Location: authenticate.php');
exit;
