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
$id = '';
function get_single_entry($id) {
	include 'inc/dbconnection.php';

	// Retrieve single entry & related details from database
	$get_entry = "SELECT id, title, date, time_spent, learned, resources 
								FROM entries 
								WHERE id = ?"; 
	
	if (isset($_GET)) {
		$id = $_GET['id'];
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

// Will print selected journal entry to the details page
function print_single_entry(){
	foreach (get_single_entry($id) as $choice) {
		echo "<h1>" . $choice['title'] . "</h1>";


		// h1>The best day I’ve ever had</h1>
    //                     <time datetime="2016-01-31">January 31, 2016</time>
    //                     <div class="entry">
    //                         <h3>Time Spent: </h3>
    //                         <p>15 Hours</p>
    //                     </div>
    //                     <div class="entry">
    //                         <h3>What I Learned:</h3>
    //                         <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nunc ut rhoncus felis, vel tincidunt neque.</p>
    //                         <p>Cras egestas ac ipsum in posuere. Fusce suscipit, libero id malesuada placerat, orci velit semper metus, quis pulvinar sem nunc vel augue. In ornare tempor metus, sit amet congue justo porta et. Etiam pretium, sapien non fermentum consequat, <a href="">dolor augue</a> gravida lacus, non accumsan. Vestibulum ut metus eleifend, malesuada nisl at, scelerisque sapien.</p>
    //                     </div>
    //                     <div class="entry">
    //                         <h3>Resources to Remember:</h3>
    //                         <ul>
    //                             <li><a href="">Lorem ipsum dolor sit amet</a></li>
    //                             <li><a href="">Cras accumsan cursus ante, non dapibus tempor</a></li>
    //                             <li>Nunc ut rhoncus felis, vel tincidunt neque</li>
    //                             <li><a href="">Ipsum dolor sit amet</a></li>
    //                         </ul>
    //                     </div>
	}
}

//print_single_entry();