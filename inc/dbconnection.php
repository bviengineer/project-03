<?php 
    try {
        $db = new PDO('sqlite:__DIR__journal.db');
        echo "connected to the database";
    } catch (Exception $e) {
        echo $e->getMessage();
    }
?>