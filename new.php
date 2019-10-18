<?php
// Inclusion of files containing header tags and all functions need to run the application
	include 'inc/head.php'; 
	include 'inc/functions.php';

	// Conditional will ensure there is at least a title for a given entry before adding it to the database
	if (!empty($_POST['title'])) {
			//use trim() function to remove whites pace before and after ?
		$title = filter_input(INPUT_POST, 'title', FILTER_SANITIZE_STRING);
		$date = filter_input(INPUT_POST, 'date', FILTER_SANITIZE_STRING);
		$time_spent = filter_input(INPUT_POST, 'timeSpent', FILTER_SANITIZE_NUMBER_INT);
		$learned = filter_input(INPUT_POST, 'whatILearned', FILTER_SANITIZE_STRING);
		$resources = filter_input(INPUT_POST, 'ResourcesToRemember', FILTER_SANITIZE_STRING);

			if (add_journal_entry($title, $date, $time_spent, $learned, $resources)) {
						header('Location: index.php');
						exit;
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
										<!-- Print error message to the screen if the form is blank -->
										<?php 
											if ($_POST && empty($_POST['title'])) {
												echo print_blank_err_msg("You need at least a title in order to save an entry.");
											} 
										?>
                    <form method="POST" action="">
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
<?php include 'inc/footer.php';?>