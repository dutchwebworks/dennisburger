<?php
session_start();
if($_SESSION["acces"] != true) die(header("location: index.php?action=logout"));
?>
