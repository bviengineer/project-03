<?php
/* This file will hold all functions needed to run the application
*/

// RETRIEVE ALL JOURNAL ENTRIES
function get_journal_entries() {
	include 'inc/dbconnection.php';
	$sql = "SELECT entries.id, entries.title, entries.date, entries.learned, entries.resources, my_tags.tags
					FROM entries  
					LEFT OUTER JOIN entry_tag ON entries.id = entry_tag.entry_id
					LEFT OUTER JOIN my_tags ON my_tags.tag_id = entry_tag.tag_id
					ORDER BY date DESC";
	try {
		$results = $db->query($sql); 
	} catch (Exception $e) {
		echo $e->getMessage();
		return array();
	}
	// echo "<pre>";	
	// var_dump($results->fetchAll(PDO::FETCH_ASSOC));
	// echo "</pre>";
	return $results->fetchAll(PDO::FETCH_ASSOC);
}
// RETRIEVE A SINGLE JOURNAL ENTRY
function get_single_entry($id) {
	include 'inc/dbconnection.php';
	$get_entry = "SELECT entries.id, entries.title, entries.date, entries.time_spent, entries.learned, entries.resources, my_tags.tags 
				FROM entries
				LEFT OUTER JOIN entry_tag ON entries.id = entry_tag.entry_id
				LEFT OUTER JOIN my_tags ON my_tags.tag_id = entry_tag.tag_id 
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
// RETRIEVE JOURNAL ENTRIES BY TAG(S)
function get_filtered_entries($tag) {
	include 'inc/dbconnection.php';
	$get_tag = "SELECT entries.id, entries.title, entries.date, entries.learned, entries.resources, my_tags.tags
								FROM entries  
								LEFT OUTER JOIN entry_tag ON entries.id = entry_tag.entry_id
								LEFT OUTER JOIN my_tags ON my_tags.tag_id = entry_tag.tag_id
								WHERE my_tags.tags LIKE ? ORDER BY date DESC"; 
	 if (isset($_GET['tag'])) {
		 //echo "<br>".$_GET['tag'] . "<br>"; // testing tag selected by user 
		try {
			$results = $db->prepare($get_tag);
			$results->bindValue(1, $_GET['tag'], PDO::PARAM_STR);
			$results->execute();
		} catch (Connection $e) {
				$e->getMessage();
				return array();
		}
		//echo "<br> tag after result set is returned: " . $_GET['tag'] . "<br>";
		//var_dump($results->fetchAll(PDO::FETCH_ASSOC));
	}
	return $results->fetchAll(PDO::FETCH_ASSOC);
}
// PRINT ALL JOURNAL ENTRIES: on index.php & creates hyperlinks to respective entries 
function print_journal_entries() {
	foreach (get_journal_entries() as $entry) {
		echo "<h2><a href='detail.php?id=";
		echo $entry['id'] . " '> ";
		echo $entry['title'];
		echo "</a></h2>";
		echo "<time>"; 
		echo date('F d, Y', strtotime($entry['date']));
		echo "</time>";
		echo "<h4 class='tags'><a href='filtered_entries.php?tag=";
		echo  $entry['tags'] . " '> Tag(s): ";
		echo $entry['tags'] . "</a></h4>";
		echo "<hr>";
	}
}
// PRINT JOURNAL ENTRIES BY TAG: on filtered_entries.php
function print_filtered_entries($tag) {
	foreach (get_filtered_entries($tag) as $entry) {
		echo "<h2><a href='detail.php?id=";
		echo $entry['id'] . " '> ";
		echo $entry['title'];
		echo "</a></h2>";
		echo "<time>"; 
		echo date('F d, Y', strtotime($entry['date']));
		echo "</time>";
		echo "<h4 class='tags'><a href='filtered_entries.php?tag=";
		echo  $entry['tags'] . " '> Tag(s): ";
		echo $entry['tags'] . "</a></h4>";
		echo "<hr>";
	}
}
// ADD JOURNAL ENTRY
function add_journal_entry($title, $date = NULL, $time_spent = NULL, $learned = NULL, $resources = NULL, $tags){
	include 'inc/dbconnection.php';
	
$add_entry = "SELECT entries.id, entries.title, entries.time_spent, entries.date, entries.learned, entries.resources, my_tags.tags
							FROM entries  
							LEFT OUTER JOIN entry_tag ON entries.id = entry_tag.entry_id
							LEFT OUTER JOIN my_tags ON my_tags.tag_id = entry_tag.tag_id 
							INSERT INTO entries (entries.title, entries.date, entries.time_spent, entries.learned, entries.resources, entry_tag.tag_id) 
							WHERE entry_tag.tag_id IN ('1', '2', '3', '4', '5') 
							VALUES(?, ?, ?, ?, ?, ?)";
					
	// $add_entry = "INSERT INTO entries (title, date, time_spent, learned, resources) VALUES(?, ?, ?, ?, ?, ?)";
	// $add_tags = "INSERT INTO entry_tag (entry_id, tag_id) VALUES(?, ?)";

  try {
		$results = $db->prepare($add_entry); // Prepare sql statement & assigns results to the variable $results
		$results->bindValue(1, $title, PDO::PARAM_STR); // Associates the 1st ? with the $title var
		$results->bindValue(2, $date, PDO::PARAM_STR); // Associates the 2nd ? with the $date var
		$results->bindValue(3, $time_spent, PDO::PARAM_INT); // Associates the 3rd ? with the $time_spent var
		$results->bindValue(4, $learned, PDO::PARAM_STR); // Associates the 4th ? with the $learned var
		$results->bindValue(5, $resources, PDO::PARAM_STR); // Associates the 5th ? with the $resources var
		$results->bindValue(5, $tags, PDO::PARAM_STR);
		$results->execute(); // Executes the insert query after filtering & binding the inputs
		
		// $results2 = $db-prepare($add_tags);
		// $results2->bindValue(1, $_POST['id'], PDO::PARAM_STR);
		// $results2->bindValue(2, $_POST['tags'], PDO::PARAM_STR);
		// $results2->execute();
    } catch (Exception $e) {
            $e->getMessage();
            return array();
		} 
		return true; 
}
// UPDATE JOURNAL ENTRY
function update_journal_entry($title, $date, $time_spent, $learned, $resources = NULL) {
	include 'inc/dbconnection.php';

	$update_entry = "UPDATE entries 
						SET title = ?, date = ?, time_spent = ?, learned = ?, resources = ? 
						WHERE id = ?";

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