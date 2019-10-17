<?php
/* 
	This file will hold all functions needed to run the application
*/


// Retrieve all journal entries from database 
function get_journal_entries() {
	include 'inc/dbconnection.php';

	try {
		$results = $db->query("SELECT * FROM entries"); //TRY ADDING LIMIT 2 
	} catch (Exception $e) {
		echo $e->getMessage();
		return array();
	}
	return $results->fetchAll(PDO::FETCH_ASSOC);
}


// Print journal entries to the page
function print_journal_entries() {

	foreach (get_journal_entries() as $entry) {
		echo "<h2><a href='detail.php?id= ";
		echo $entry['id'] . " '> ";
		echo $entry['title'];
		echo "</a></h2>";
		echo "<time>";
		echo $entry['date'];
		echo "</time>";
		echo "<hr>";
	}
}


// Add a new journal entry to the database
function add_journal_entry($title, $date = NULL, $time_spent = NULL, $learned = NULL, $resources = NULL){
    include 'inc/dbconnection.php';
    
    // Insert journal entry into database sql statement 
    $add_entry = "INSERT INTO entries (title, date, time_spent, learned, resources) VALUES(?, ?, ?, ?, ?)";

    try {
        $results = $db->prepare($add_entry); // Prepare sql statenebt abd palace the results into the variable $results
        $results->bindValue(1, $title, PDO::PARAM_STR); // Associates the 1st ? with the $title var
        $results->bindValue(2, $date, PDO::PARAM_STR); // Associates the 2nd ? with the $date var
        $results->bindValue(3, $time_spent, PDO::PARAM_INT); // Associates the 3rd ? with the $time_spent var
        $results->bindValue(4, $learned, PDO::PARAM_STR); // Associates the 4th ? with the $learned var
        $results->bindValue(5, $resources, PDO::PARAM_STR); // Associates the 5th ? with the $resources var
        $results->execute(); // Executes the insert query after filtering & binding the inputs
				 //echo "Your journal entry was added successfully!"; // Prints confiramtion msg to the screen after adding entry to database
				// header("Location: index.php"); // will return to the index page where all the entires are listed

    } catch (Exception $e) {
            $e->getMessage();
            return array();
		} 
}

