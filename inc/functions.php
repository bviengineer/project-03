<?php
/*=======================================================================================
 	> This file contains all functions needed to run the application
	> Functions are listed or categorized based on the acronym: CRUD
	> Functions that do not apply to the CRUD model are listed after in alphabetical order 
=========================================================================================*/

/*========================
 	CRUD => CREATE
=========================*/
// ADD A JOURNAL ENTRY
function add_journal_entry($title, $date = NULL, $time_spent = NULL, $learned = NULL, $resources = NULL){
	include 'inc/dbconnection.php';
	$add_entry = "INSERT INTO entries (title, date, time_spent, learned, resources) VALUES(?, ?, ?, ?, ?)";
  try {
		$results = $db->prepare($add_entry);
		$results->bindValue(1, $title, PDO::PARAM_STR);
		$results->bindValue(2, $date, PDO::PARAM_STR);
		$results->bindValue(3, $time_spent, PDO::PARAM_INT);
		$results->bindValue(4, $learned, PDO::PARAM_STR);
		$results->bindValue(5, $resources, PDO::PARAM_STR);
		$results->execute();
  } catch (Exception $e) {
			$e->getMessage();
			return array();
	} 
	return true; 
}
// ADD TAG(S) FOR A NEW JOURNAL ENTRY: called in new.php
function add_tags() {
	include 'inc/dbconnection.php';
	// Gets ID of most recent entry entered added to the dbase
	$id = get_last_entry();
	// Assigns returned id, which is an associative array & converts the ID from a str to an int
	$entry_id = intval($id['id']); 
	foreach ($_POST['tags'] as $tag) {
		$tag_id = intval($tag);
		try {
			$results = $db->prepare("INSERT INTO entry_tag (entry_id, tag_id) VALUES(?, ?)");
			$results->bindValue(1, $entry_id, PDO::PARAM_STR);
			$results->bindValue(2, $tag_id, PDO::PARAM_STR);
			$results->execute();
		} catch(Exception $e) {
				$e->getMessage();
				return array();
			}	
	}
	return $results->fetchAll(PDO::FETCH_ASSOC);
}
/*========================
 	CRUD => READ
=========================*/
// RETRIEVE ALL JOURNAL ENTIRES [from entries table]
function get_journal_entries_table() {
	include 'inc/dbconnection.php';
	$sql = "SELECT * FROM entries ORDER BY date DESC";
	try {
		$results = $db->query($sql); 
	} catch (Exception $e) {
		echo $e->getMessage();
		return array();
	}
		return $results->fetchAll(PDO::FETCH_ASSOC);
}
// RETRIEVES ALL JOURNAL ENTRIES & TAGS [SQL join]
function get_journal_entries() {
	include 'inc/dbconnection.php';
	$sql = "SELECT entries.id, entries.title, entries.date, entries.learned, entries.resources, my_tags.tags,entry_tag.entry_id, entry_tag.tag_id
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
	return $results->fetchAll(PDO::FETCH_ASSOC);
}
// RETRIEVE A SINGLE JOURNAL ENTRY & ITS TAGS (SQL join)
function get_single_entry($id) {
	include 'inc/dbconnection.php';
	$get_entry = "SELECT entries.id, entries.title, entries.date, entries.time_spent, entries.learned, entries.resources, my_tags.tags, entry_tag.entry_id, entry_tag.tag_id 
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
// RETRIEVE JOURNAL ENTRIES BY TAG(S) (SQL JOIN)
function get_filtered_entries($tag) {
	include 'inc/dbconnection.php';
	$get_tag = "SELECT entries.id, entries.title, entries.date, entries.learned, entries.resources, my_tags.tags, entry_tag.entry_id, entry_tag.tag_id
								FROM entries  
								LEFT OUTER JOIN entry_tag ON entries.id = entry_tag.entry_id
								LEFT OUTER JOIN my_tags ON my_tags.tag_id = entry_tag.tag_id
								WHERE my_tags.tags LIKE ? ORDER BY date DESC"; 
	if (isset($_GET['tag'])) {
	try {
			$results = $db->prepare($get_tag);
			$results->bindValue(1, $_GET['tag'], PDO::PARAM_STR);
			$results->execute();
		} catch (Connection $e) {
				$e->getMessage();
				return array();
		}
	}
	return $results->fetchAll(PDO::FETCH_ASSOC);
}
// RETRIEVE TAGS BY ENTRY
function get_tags() {
	include 'inc/dbconnection.php';
	$get_tags = "SELECT my_tags.tag_id, entries.id, my_tags.tags, entries.title
							FROM my_tags 
							LEFT OUTER JOIN entry_tag 
							ON entry_tag.tag_id = my_tags.tag_id
							LEFT OUTER JOIN entries 
							ON entries.id = entry_tag.entry_id";
	try {
		$results = $db->query($get_tags);
	} catch (Exception $e) {
			$e->getMessage();
			return array();
	}
	return $results->fetchAll(PDO::FETCH_ASSOC);
}
// RETRIEVE MOST RECENT JOURNAL ENTRY ADDED
function get_last_entry() {
	include 'inc/dbconnection.php';
	$select_last_entry = "SELECT id FROM entries ORDER BY id DESC LIMIT 1";
	try {
		$results = $db->query($select_last_entry);
	} catch (Exception $e) {
		$e->getMessage();
		return array();
	}
	return $results->fetch(PDO::FETCH_ASSOC);
}
/*========================
 	CRUD => UPDATE
=========================*/
// UPDATE JOURNAL ENTRY
function update_journal_entry($title, $date, $time_spent, $learned, $resources = NULL) {
	include 'inc/dbconnection.php';
	$update_entry = "UPDATE entries 
										SET title = ?, date = ?, time_spent = ?, learned = ?, resources = ? 
										WHERE id = ?";
	if (isset($_POST['id'])) {
		try {
				$results = $db->prepare($update_entry);
				$results->bindValue(1, $title, PDO::PARAM_STR);
				$results->bindValue(2, $date, PDO::PARAM_STR);
				$results->bindValue(3, $time_spent, PDO::PARAM_INT);
				$results->bindValue(4, $learned, PDO::PARAM_STR);
				$results->bindValue(5, $resources, PDO::PARAM_STR);
				$results->bindValue(6, $_POST['id'], PDO::PARAM_INT);
				$results->execute();
		} catch (Exception $e) {
				$e->getMessage();
			return array();
		} 
	}
	return true;
}
// UPDATE TAGS FOR A GIVEN JOURNAL ENTRY
function update_tags($id) {
	include 'inc/dbconnection.php';
		$entry_id = intval($id);
		$update_tags = "INSERT INTO entry_tag (entry_id, tag_id) VALUES(?, ?)";
		foreach ($_POST['tags'] as $tag) {
			try {
				$results = $db->prepare($update_tags);
				$results->bindValue(1, $entry_id, PDO::PARAM_STR);
				$results->bindValue(2, intval($tag), PDO::PARAM_STR);
				$results->execute();
			} catch(Exception $e) {
					$e->getMessage();
					return array();
				}	
		}
		return true;
	}
/*========================
 	CRUD => DELETE
=========================*/
// DELETE A JOURNAL ENTRY
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
// DELETE TAGS 
function delete_tags($id) {
	include 'inc/dbconnection.php';
		$entry_id = intval($id);
		$delete_tags = "DELETE FROM entry_tag WHERE entry_id = ?";
		foreach ($_POST['tags'] as $tag) {
			try {
				$results = $db->prepare($delete_tags);
				$results->bindValue(1, $entry_id, PDO::PARAM_STR);
				$results->execute();
			} catch(Exception $e) {
					$e->getMessage();
					return array();
				}	
		}
		return true;
	}
/*========================
 	DISPLAY / OTHER FUNCTIONS
=========================*/
// PRINTS ALL JOURNAL ENTRIES $ THEIR TAGS: on index.php
function print_entries_tags() {
	foreach (get_journal_entries_table() as $entries) {
		echo "<h2><a href='detail.php?id=";
		echo $entries['id'] . " '> ";
		echo $entries['title'];
		echo "</a></h2>";
		echo "<time>"; 
		echo date('F d, Y', strtotime($entries['date']));
		echo "</time>";
		echo "<br><br>"; 
		echo "<h2 class='tags-heading'>Tags: </h2>";
		foreach (get_tags() as $details) {
			if ($entries['id'] == $details['id']) {
					echo "<a class='tags' href='filtered_entries.php?tag=";
					echo $details['tags'] . " '>";
					echo $details['tags'] . "</a>" . ' ';
			}
		}
		echo "<br><br>";
		echo "<hr>";	
	}
}
// ERROR NOTIFICATION
function print_err_msg($message) {
	$blank_title_err = $message;
	return $blank_title_err;
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
		echo "<br><br>";
		echo "<h2 class='tags-heading'>Tags: </h2>";
		echo "<a class='tags' href='filtered_entries.php?tag=";
		echo $entry['tags'] . " '>";
		echo $entry['tags'] . "</a>" . ' ';
		echo "<br><br>";
		echo "<hr>";
	}
}