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
		echo "<h2><a href='detail.php?id=";
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
				 //echo "Your journal entry was added successfully!"; // Prints confiramtion msg to the screen after adding

    } catch (Exception $e) {
            $e->getMessage();
            return array();
		} 
		// Will return true once if no error is encountered & pass the value to the call of add_journal_entry inside new.php
		return true; 
}


// Will print message to page if submitted journal entry form is missing the title
function print_blank_err_msg($message) {
	$blank_title_err = $message;
	return $blank_title_err;
}


// Will get the id & return the specific journal entry that was selected on the index page
function get_single_entry($id) {
	include 'inc/dbconnection.php';

	// Retrieve single entry & related details from database
	$get_entry = "SELECT id, title, date, time_spent, learned, resources 
								FROM entries 
								WHERE id = ?"; 
	
	if (isset($_GET['id'])) {
		try {
			$results = $db->prepare($get_entry);
			$results->bindValue(1, $id, PDO::PARAM_INT);
			$results->execute();
		} catch (Connection $e) {
				$e->getMessage();
				return array();
		}
	}
	return $results->fetch(PDO::FETCH_ASSOC);
}


// Update journal entry to the database
function update_journal_entry($title, $date = NULL, $time_spent = NULL, $learned = NULL, $resources = NULL){
	include 'inc/dbconnection.php';
	
	// Update journal entry in database sql statement 
	$update_entry = "UPDATE entries SET title = ?, date = ?, time_spent = ?, learned = ?, resources = ? WHERE id = ?";

	try {
			$results = $db->prepare($update_entry); // Prepare sql statenebt abd palace the results into the variable $results
			$results->bindValue(1, $title, PDO::PARAM_STR); // Associates the 1st ? with the $title var
			$results->bindValue(2, $date, PDO::PARAM_STR); // Associates the 2nd ? with the $date var
			$results->bindValue(3, $time_spent, PDO::PARAM_INT); // Associates the 3rd ? with the $time_spent var
			$results->bindValue(4, $learned, PDO::PARAM_STR); // Associates the 4th ? with the $learned var
			$results->bindValue(5, $resources, PDO::PARAM_STR); // Associates the 5th ? with the $resources var
			$results->bindValue(6, $id, PDO::PARAM_INT); // Associates the 6th ? with the $id var
			$results->execute(); // Executes the insert query after filtering & binding the inputs
			 //echo "Your journal entry was added successfully!"; // Prints confiramtion msg to the screen after adding

	} catch (Exception $e) {
					$e->getMessage();
					return array();
	} 
	// Will return true once if no error is encountered & pass the value to the call of add_journal_entry inside new.php
	return true; 
}