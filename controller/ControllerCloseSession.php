<?php
session_start();
session_destroy();
header("Location: ../view/index.php?logout=true");
exit();
