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


// Print journal entries on the [index] page & creates hyperlinks to respective entries 
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
        $results = $db->prepare($add_entry); // Prepare sql statement & assigns results to the variable $results
        $results->bindValue(1, $title, PDO::PARAM_STR); // Associates the 1st ? with the $title var
        $results->bindValue(2, $date, PDO::PARAM_STR); // Associates the 2nd ? with the $date var
        $results->bindValue(3, $time_spent, PDO::PARAM_INT); // Associates the 3rd ? with the $time_spent var
        $results->bindValue(4, $learned, PDO::PARAM_STR); // Associates the 4th ? with the $learned var
        $results->bindValue(5, $resources, PDO::PARAM_STR); // Associates the 5th ? with the $resources var
        $results->execute(); // Executes the insert query after filtering & binding the inputs

    } catch (Exception $e) {
            $e->getMessage();
            return array();
		} 
		// Will return true if no error is encountered & pass the value to the call of add_journal_entry inside new.php
		return true; 
}


// Will halt submission & print message on page if submitted journal entry form is missing the title
function print_blank_err_msg($message) {
	$blank_title_err = $message;
	return $blank_title_err;
}


// Will get the ID & return the specific journal entry that was selected [while on the index page]
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


// Update journal entry in the database
function update_journal_entry($title, $date = NULL, $time_spent = NULL, $learned = NULL, $resources = NULL) {
	include 'inc/dbconnection.php';
	
	// Update journal entry in database sql statement 
	$update_entry = "UPDATE entries SET title = ?, date = ?, time_spent = ?, learned = ?, resources = ? WHERE id = ?";
	
	// Verifies that the ID of the journal entry isset before updating the database 
	if (isset($_POST['id'])) {
		try {
				$results = $db->prepare($update_entry); // Prepare sql statement & assigns results to the variable $results
				$results->bindValue(1, $title, PDO::PARAM_STR); // Associates the 1st ? with the $title var
				$results->bindValue(2, $date, PDO::PARAM_STR); // Associates the 2nd ? with the $date var
				$results->bindValue(3, $time_spent, PDO::PARAM_INT); // Associates the 3rd ? with the $time_spent var
				$results->bindValue(4, $learned, PDO::PARAM_STR); // Associates the 4th ? with the $learned var
				$results->bindValue(5, $resources, PDO::PARAM_STR); // Associates the 5th ? with the $resources var
				$results->bindValue(6, $_POST['id'], PDO::PARAM_INT); // Associates the 6th ? with the $id var
				$results->execute(); // Executes the insert query after filtering & binding the inputs

		} catch (Exception $e) {
						$e->getMessage();
						return array();
		} 
	}
	// Will return true if no error is encountered & pass the return value to the call of update_journal_entry inside edit.php
	return true; 
}


// Will get the ID & return the specific journal entry that was selected [while on the index page]
function delete_single_entry($id) {
	include 'inc/dbconnection.php';

	// Retrieve single entry & related details from database
	$delete_entry = "DELETE id, title, date, time_spent, learned, resources 
										FROM entries 
										WHERE id = ?"; 
	
	if (isset($_GET['id'])) {
		try {
			$results = $db->prepare($delete_entry);
			$results->bindValue(1, $id, PDO::PARAM_INT);
			$results->execute();
		} catch (Connection $e) {
				$e->getMessage();
				return array();
		}
	}
	return true;
}