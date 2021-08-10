<?php
require 'includes/config.php';
require 'includes/constant.php';
$page = 'welcome'; //default page
if (isset($_GET['page'])) {
    $page = $_GET['page'];
}

die();
include "pages/$page/inhead.php"; 
include "pages/$page/inbody.php";