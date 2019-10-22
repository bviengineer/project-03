<?php
	// Inclusion of files containing header tags and all functions needed to run the application
	include 'inc/head.php'; 
	include 'inc/functions.php';
?>
	<body>
		<header>
			<div class="container">
				<div class="site-header">
					<a class="logo" href="index.php"><i class="material-icons">library_books</i></a>
					<a class="button icon-right" href="new.php"><span>New Entry</span> <i class="material-icons">add</i></a>
				</div>
			</div>
		</header>
    <section>
    	<div class="container">
				<div class="new-entry">
					<h2>New Entry</h2>
					<h5>
						<?php 
							if ($_POST && $_POST['addEntry']) {
								$title = trim(filter_input(INPUT_POST, 'title', FILTER_SANITIZE_STRING));
								$date = trim(filter_input(INPUT_POST, 'date', FILTER_SANITIZE_STRING));
								$time_spent = trim(filter_input(INPUT_POST, 'timeSpent', FILTER_SANITIZE_NUMBER_INT));
								$learned = trim(filter_input(INPUT_POST, 'whatILearned', FILTER_SANITIZE_STRING));
								$resources = trim(filter_input(INPUT_POST, 'ResourcesToRemember', FILTER_SANITIZE_STRING));
													
								// Will ensure required fileds are completed before adding entry to the database
								if (empty($title) || empty($date) || empty($time_spent) || empty($learned)) {
										echo print_err_msg("Please ensure the:<br> Title, Date, Time Spent & What I learned fields <br> are completed in order to save this entry");
								} else {
											if (add_journal_entry($title, $date, $time_spent, $learned, $resources)) {
												header('Location: index.php?msg=Cool!+I+added+that+journal+entry+for+you!');
												exit;
								} else {
											echo print__err_msg("Could not add journal entry. Please try again!");
									}
								}
							} elseif ($_POST && $_POST['cancelEntry']) { 
								header('Location: index.php?msg=OK!+That+entry+was+discarded!');
							}
					?>
				</h5>
				<form method="POST" action="">
						<label for="title"> Title <span id="star">*</span></label>
						<input id="title" type="text" name="title"><br>
						<label for="date">Date <span id="star">*</span></label>
						<input id="date" type="date" name="date"><br>
						<label for="time-spent"> Time Spent (in minutes) <span id="star">*</span></label>
						<input id="time-spent" type="text" name="timeSpent"><br>
						<label for="what-i-learned">What I Learned <span id="star">*</span></label>
						<textarea id="what-i-learned" rows="5" name="whatILearned"></textarea>
						<label for="resources-to-remember">Resources to Remember</label>
						<textarea id="resources-to-remember" rows="5" name="ResourcesToRemember"></textarea>
						<input type="submit" value="Publish Entry" name="addEntry" class="button">
						<input type="submit" value="Cancel" name="cancelEntry" class="button button-secondary">
				</form>
		</div>
</div>
</section>
<?php include 'inc/footer.php';?>