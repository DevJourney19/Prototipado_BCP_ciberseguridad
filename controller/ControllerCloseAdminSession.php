<?php
session_start();

session_destroy();
header("Location: ../view/login_admin.php");
exit();