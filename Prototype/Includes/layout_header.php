<?php
include 'db.php';
?>

<!DOCTYPE html>
    
<html>
    <head>
        <meta charset="utf-8"> 
        <title><?php echo isset($page_title) ? $page_title : "Web Store"; ?></title>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">       
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
        <link rel="stylesheet" type="text/css" href="../Styles/store.css">
    </head>
    <body>
        <?php include 'navbar.php'; ?>
        
        <div class="container">
            <div class="page-header">
                <h1><?php echo isset($page_title) ? $page_title : "Web Store" ; ?></h1>
            </div>
        


