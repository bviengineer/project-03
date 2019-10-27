<?php
    try {
        $db = new PDO("sqlite:".__DIR__."/journal.db");
        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); 
        $db->exec( 'PRAGMA foreign_keys = ON;' ); // Obtained from Jennifer Nordell, see her note below 
        } catch (Exception $e) {
        echo $e->getMessage();
        exit;
		}
		
/*=================================
  CRITICAL
  =================================*/
  // The following line [of code] is critical. Without it, the cascading options in sqlite do
  // not take effect at all. Hours of figthing lead me to this:  https://dba.stackexchange.com/questions/94134/on-delete-cascade-not-deleting-entry-for-foreign-key
  //$db->exec( 'PRAGMA foreign_keys = ON;' );