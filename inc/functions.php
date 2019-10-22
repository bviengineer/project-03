<?php
/* This file will hold all functions needed to run the application
*/

// RETRIEVE ALL JOURNAL ENTRIES: will retrieve all journal entries from database 
function get_journal_entries() {
	include 'inc/dbconnection.php';
	 	$sql = "SELECT entries.id, entries.title, entries.date, entries.learned, entries.resources, tags.tags
		 				FROM entries  
		 				LEFT JOIN entry_tag ON entries.id = entry_tag.entry_id
		 				LEFT JOIN tags ON tags.tag_id = entry_tag.tag_id
		 				ORDER BY date DESC";
	
	// PREVIOUS QUERY 
	// "SELECT entries.id, entries.title, entries.date, entries.learned, entries.resources, tags.tags 
	// 				FROM entries  
	// 				LEFT JOIN tags ON entries.tag_id = tags.tag_id
	// 				ORDER BY date DESC";
	
	try {
		$results = $db->query($sql); //TRY ADDING LIMIT 2 
	} catch (Exception $e) {
		echo $e->getMessage();
		return array();
	}
	// echo "<pre>";
	// var_dump($results->fetchAll(PDO::FETCH_ASSOC));
	// echo "</pre>";
	return $results->fetchAll(PDO::FETCH_ASSOC);
}
// PRINT ALL JOURNAL ENTRIES: will print journal entries on the [index] page & creates hyperlinks to respective entries 
function print_journal_entries() {
	foreach (get_journal_entries() as $entry) {
		$date_conversion = explode("-", $entry['date']); // Converts date of type string to an array, - is the separator 
		$month = ''; // At index 1 of $date_conversion is the month
		$day = $date_conversion[2]; // At index 2 of $date_conversion is the day
		$year = $date_conversion[0]; // At index 0 of $date_conversion is the year

		// Will assign the month [in words] to the $month variable before printing to the page
		switch ($date_conversion[1]) {
			case '1':
			$month = 'January';
			break;

			case '2':
				$month = 'February';
				break;
			
				case '3':
				$month = 'March';
				break;

				case '4':
				$month = 'April';
				break;

				case '5':
				$month = 'May';
				break;

				case '6':
				$month = 'June';
				break;

				case '7':
				$month = 'July';
				break;

				case '8':
				$month = 'August';
				break;

				case '9':
				$month = 'September';
				break;

				case '10':
				$month = 'October';
				break;

				case '11':
				$month = 'November';
				break;

				case '12':
				$month = 'December';
				break;
		}
		echo "<h2><a href='detail.php?id=";
		echo $entry['id'] . " '> ";
		echo $entry['title'];
		echo "</a></h2>";
		echo "<time>";
		echo $month . ' ' . $day . ', ' . $year; 
		echo "</time>";
		echo "<h4 class='tags'><a href=detail.php?id=";
		echo $entry['id'] . " '> Tag(s): ";
		echo $entry['tags'] . "</a></h4>";
		echo "<hr>";
	}
}
// RETRIEVE A SINGLE JOURNAL ENTRY: Will retrieve the specific journal entry that was selected [while on the index page]
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
// ADD JOURNAL ENTRY: will add a new journal entry to the database
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
// UPDATE JOURNAL ENTRY: will update a given journal entry
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
	return true; // ReturnS true if no error is encountered & pass the return value to the call of update_journal_entry inside edit.php
}
// DELETE JOURNAL ENTRY: Will get the associated ID & delete the specified journal entry
function delete_single_entry($id) {
	include 'inc/dbconnection.php';

	// Retrieve single entry & related details from database
	$delete_entry = "DELETE FROM entries WHERE id = ?"; 

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
// ERROR NOTIFICATION: Will halt a request & print an error message if submitted journal entry form data is invalid
function print_err_msg($message) {
	$blank_title_err = $message;
	return $blank_title_err;
}