<!DOCTYPE html>
<html lang="en">
<head></head>
<body>
<?php 
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
if(isset($_GET['ReportPage'])) {
  $Grab = $_GET['ReportPage'];


        $matches = [];
        $logs =[];
        preg_match_all('/\n\t[0-9,a-z,A-Z]+/', $Grab, $matches, PREG_UNMATCHED_AS_NULL);
        preg_match_all('/\n[[:space:]]\t[0-9,a-z,A-Z]+/', $Grab, $logs, PREG_UNMATCHED_AS_NULL);
        echo '<p>';
        echo 'Grab';
        echo json_encode($matches);
        echo json_encode(count($matches));
        echo 'bag';
        echo json_encode($logs);
        echo '</p>';
        }
        else{
                echo '<p>';
        echo 'No Grab';
        echo '</p>';
        
        
        }
        ?>
        </body>
        </html>