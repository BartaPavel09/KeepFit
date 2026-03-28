<?php
session_start();
if (isset($_SESSION['ID']))
{
    $ID = $_SESSION['ID'];
}
?>