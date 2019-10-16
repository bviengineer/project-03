<?php include 'inc/header.php'; 

// Use prepared statements to add/edit/delete journal entries in the database.
// Create “add/edit” view for the "entry" page that allows the user to add or edit journal entries with the following fields: title, date, time_spent, learned, and resources. Each journal entry should have a unique primary key.

    if (!empty($_POST['title'])) {
        //use trim() function to remove whites pace before and after 
      $title = $_POST['title'];
      $date_written = $_POST['date'];
      $time_spent = $_POST['timeSpent'];
      $learned = $_POST['whatILearned'];
			$resources = $_POST['ResourcesToRemember'];
			add_journal_entry($title, $date, $time_spent, $learned, $resources);
			echo '<pre>';
				echo($_POST['title']);
				var_dump($_POST['date']);
				var_dump($_POST['timeSpent']);
				var_dump($_POST['whatILearned']);
				var_dump($_POST['ResourcesToRemember']);
			echo '</pre>';
      //echo "<br>Your title is: " . $title . "<br>";
    } elseif($_POST && empty($_POST['title'])) {
				$blank_form_err = "You didn't enter any data";
		}

		// Function will add a new journal entry to the database
    function add_journal_entry($title, $date, $time_spent, $learned, $resources){
        include 'inc/dbconnection.php';
        
				$addEntry = "INSERT INTO entries (title, date_written, time_spent, learned, resources) VALUE(?, ?, ?, ?, ?)";

				try {
					$results = $db->prepare($addEntry);
					$results->bindValue(1, $title, PDO::PARAM_STR);
					$results->bindValue(2, $date_written, PDO::PARAM_STR);
					$results->bindValue(3, $time_spent, PDO::PARAM_INT);
					$results->bindValue(4, $learned, PDO::PARAM_STR);
					$results->bindValue(5, $resources, PDO::PARAM_STR);
					$results->execute();
					echo "addition successful";

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
										<?php echo $blank_form_err; ?>
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