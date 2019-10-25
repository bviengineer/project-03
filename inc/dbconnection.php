<?php
    try {
        $db = new PDO("sqlite:".__DIR__."/journal.db");
        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); 
        $db->exec( 'PRAGMA foreign_keys = ON;' ); // Obtained from Jennifer Nordell, see note below 
        } catch (Exception $e) {
        echo $e->getMessage();
        exit;
		}
		
/*=================================
	CRITICAL
=================================*/
  // $db->exec( 'PRAGMA foreign_keys = ON;' ) is critical. Without it, the cascading options in sqlite does
  // not work. Source:  https://dba.stackexchange.com/questions/94134/on-delete-cascade-not-deleting-entry-for-foreign-key