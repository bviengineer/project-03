<?php
/* This file will hold all functions needed to run the application
*/

// RETRIEVE ALL JOURNAL ENTRIES
function get_journal_entries() {
	include 'inc/dbconnection.php';
	$sql = "SELECT entries.id, entries.title, entries.date, entries.learned, entries.resources, tags.tags
					FROM entries  
					LEFT OUTER JOIN entry_tag ON entries.id = entry_tag.entry_id
					LEFT OUTER JOIN tags ON tags.tag_id = entry_tag.tag_id
					ORDER BY date DESC";
	try {
		$results = $db->query($sql); 
	} catch (Exception $e) {
		echo $e->getMessage();
		return array();
	}
	return $results->fetchAll(PDO::FETCH_ASSOC);
}
// PRINT ALL JOURNAL ENTRIES: on the [index] page & creates hyperlinks to respective entries 
function print_journal_entries() {
	foreach (get_journal_entries() as $entry) {
		echo "<h2><a href='detail.php?id=";
		echo $entry['id'] . " '> ";
		echo $entry['title'];
		echo "</a></h2>";
		echo "<time>"; 
		echo date('F d, Y', strtotime($entry['date']));
		echo "</time>";
		echo "<h4 class='tags'><a href=filtered_entries.php?tag=";
		echo  $entry['tags'] . " '> Tag(s): ";
		echo $entry['tags'] . "</a></h4>";
		echo "<hr>";
	}
}
// RETRIEVE A SINGLE JOURNAL ENTRY
function get_single_entry($id) {
	include 'inc/dbconnection.php';
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
// RETRIEVE JOURNAL ENTRIES BY TAGS
function get_filtered_entries($tag) {
	include 'inc/dbconnection.php';
	$get_tag = "SELECT entries.id, entries.title, entries.date, entries.learned, entries.resources, tags.tags
								FROM entries  
								LEFT OUTER JOIN entry_tag ON entries.id = entry_tag.entry_id
								LEFT OUTER JOIN tags ON tags.tag_id = entry_tag.tag_id
								WHERE tags LIKE ?"; 
	 if (isset($_GET['tag'])) {
		 echo $_GET['tag'];
		try {
			$results = $db->prepare($get_tag);
			$results->bindValue(1, $tag, PDO::PARAM_INT);
			$results->execute();
		} catch (Connection $e) {
				$e->getMessage();
				//return array();
		}
	}
	return $results->fetchAll(PDO::FETCH_ASSOC);
}
// ADD JOURNAL ENTRY
function add_journal_entry($title, $date = NULL, $time_spent = NULL, $learned = NULL, $resources = NULL){
    include 'inc/dbconnection.php';
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
		return true; 
}
// UPDATE JOURNAL ENTRY
function update_journal_entry($title, $date = NULL, $time_spent = NULL, $learned = NULL, $resources = NULL) {
	include 'inc/dbconnection.php';
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
	return true;
}
// DELETE JOURNAL ENTRY
function delete_single_entry($id) {
	include 'inc/dbconnection.php';
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
// ERROR NOTIFICATION FUNCTION 
	//Will halt a request & print an error message if submitted journal entry form data is invalid
function print_err_msg($message) {
	$blank_title_err = $message;
	return $blank_title_err;
}