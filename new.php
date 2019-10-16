<?php include 'inc/header.php'; 

	// Conditional will ensure there is at least a title for a given entry before adding it to the database
	if (!empty($_POST['title'])) {
			//use trim() function to remove whites pace before and after ?
		$title = filter_input(INPUT_POST, 'title', FILTER_SANITIZE_STRING);
		$date = filter_input(INPUT_POST, 'date', FILTER_SANITIZE_STRING);
		$time_spent = filter_input(INPUT_POST, 'timeSpent', FILTER_SANITIZE_NUMBER_INT);
		$learned = filter_input(INPUT_POST, 'whatILearned', FILTER_SANITIZE_STRING);
		$resources = filter_input(INPUT_POST, 'ResourcesToRemember', FILTER_SANITIZE_STRING);
		add_journal_entry($title, $date, $time_spent, $learned, $resources);

	} elseif($_POST && empty($_POST['title'])) {
			$blank_title_err = "You need at least a title in order to save an entry.";
	}

		// Function will add a new journal entry to the database
    function add_journal_entry($title, $date = NULL, $time_spent = NULL, $learned = NULL, $resources = NULL){
				include 'inc/dbconnection.php';
        
				$add_entry = "INSERT INTO entries (title, date, time_spent, learned, resources) VALUES(?, ?, ?, ?, ?)";

				try {
					$results = $db->prepare($add_entry); // Places the results of the prepare statement into the variable $results
					$results->bindValue(1, $title, PDO::PARAM_STR); // Associates the 1st ? with the $title var
					$results->bindValue(2, $date, PDO::PARAM_STR); // Associates the 2nd ? with the $date var
					$results->bindValue(3, $time_spent, PDO::PARAM_INT); // Associates the 3rd ? with the $time_spent var
					$results->bindValue(4, $learned, PDO::PARAM_STR); // Associates the 4th ? with the $learned var
					$results->bindValue(5, $resources, PDO::PARAM_STR); // Associates the 5th ? with the $resources var
					$results->execute(); // Executes the insert query after filtering & binding the input
				 	echo "Your journal entry was added successfully!"; // Prints confiramtion messaeg to the screen after adding entry to database

				} catch (Exception $e) {
						$e->getMessage();
				}
    }
?>
    <body>
        <header>
            <div class="container">
                <div class="site-header">
                    <a class="logo" href="index.php"><i class="material-icons">library_books</i></a>
                    <a class="button icon-right" href="new.html"><span>New Entry</span> <i class="material-icons">add</i></a>
                </div>
            </div>
        </header>
        <section>
            <div class="container">
                <div class="new-entry">
                    <h2>New Entry</h2>
										<!-- Print message to the screen if the form is blank -->
										<?php echo $blank_title_err; ?>
                    <form method="POST" action="#">
                        <label for="title"> Title</label>
                        <input id="title" type="text" name="title"><br>
                        <label for="date">Date</label>
                        <input id="date" type="date" name="date"><br>
                        <label for="time-spent"> Time Spent</label>
                        <input id="time-spent" type="text" name="timeSpent"><br>
                        <label for="what-i-learned">What I Learned</label>
                        <textarea id="what-i-learned" rows="5" name="whatILearned"></textarea>
                        <label for="resources-to-remember">Resources to Remember</label>
                        <textarea id="resources-to-remember" rows="5" name="ResourcesToRemember"></textarea>
                        <input type="submit" value="Publish Entry" class="button">
                        <a href="#" class="button button-secondary">Cancel</a>
                    </form>
                </div>
            </div>
        </section>
        <?php include 'inc/footer.php'; ?>