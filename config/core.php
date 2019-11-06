<?php
// this file for determine products per page

// number of page
if (isset($_GET['page']) &&  filter_var($_GET['page'], FILTER_VALIDATE_INT)) { 
    $page = (int) $_GET['page'];
} else {
  $page = 1;
};

// record per page
$record_per_page = 5;

$start_read_from = ($record_per_page * $page) - $record_per_page;
