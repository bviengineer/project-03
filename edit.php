<?php 
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
			<div class="edit-entry">
				<h2>Edit Entry</h2>
				<h5>
					<?php
						// Get the ID of the journal entry to be edited [from details.php] and aids in displaying it 
						if (isset($_GET['id'])) {
								$edit_entry = get_single_entry($_GET['id']);
						}
						// Checks whether a journal entry has been submitted for update via POST with a name of saveEdit 
						if ($_POST && $_POST['saveEdit']) {
							$_POST['id'] = $edit_entry['id']; // Passing the journal entry ID to the POST method 
							$title = filter_input(INPUT_POST, 'title', FILTER_SANITIZE_STRING);
							$date = filter_input(INPUT_POST, 'date', FILTER_SANITIZE_STRING);
							$time_spent = filter_input(INPUT_POST, 'timeSpent', FILTER_SANITIZE_NUMBER_INT);
							$learned = filter_input(INPUT_POST, 'whatILearned', FILTER_SANITIZE_STRING);
							$resources = filter_input(INPUT_POST, 'ResourcesToRemember', FILTER_SANITIZE_STRING);
								// Will ensure required fileds are completed before adding entry to the database
								if (empty($title) || empty($date) || empty($time_spent) || empty($learned)) {
										echo print_err_msg("I returned the initival values<br>because one or more of the required fields were blank<br><br> Please ensure the:<br> Title, Date, Time Spent & What I learned fields <br> are completed in order to update this entry");
								} else {
										if (update_journal_entry($title, $date, $time_spent, $learned, $resources)) { 
												if (isset($_POST['tags'])) {                                 
														delete_tags($_GET['id']); // Remove journal entyry tags 
														update_tags($_GET['id']); // Reinsert new/updated tags
												}
													header('Location: detail.php?id=' . $_POST['id']);
													exit;
										}
									}
							} elseif ($_POST && $_POST['cancelEdit']) {
									header('Location: detail.php?id=' . $edit_entry['id']);
								}
						?>
					</h5>
						<form method="POST" action="">
							<label for="title"> Title <span id="star">*</span></label>
							<input id="title" type="text" name="title" value="<?php echo $edit_entry['title']; ?> "><br>
							<label for="date">Date <span id="star">*</span></label>
							<input id="date" type="date" name="date" value="<?php echo $edit_entry['date']; ?>"><br>
							<label for="time-spent"> Time Spent (in minutes) <span id="star">*</span></label>
							<input id="time-spent" type="text" name="timeSpent" value="<?php echo $edit_entry['time_spent']; ?>"><br>
							<label for="what-i-learned">What I Learned <span id="star">*</span></label>
							<textarea id="what-i-learned" rows="5" name="whatILearned"><?php echo $edit_entry['learned']; ?></textarea>
							<label for="resources-to-remember">Resources to Remember</label>
							<textarea id="resources-to-remember" rows="5" name="ResourcesToRemember"><?php echo $edit_entry['resources']; ?></textarea>
							<fieldset>
								<legend>You may choose one or more tags for your entry</legend>
								<input type="checkbox" name="tags[]" value="1">Technology<br>
								<input type="checkbox" name="tags[]" value="2">Travel<br>
								<input type="checkbox" name="tags[]" value="3">Personal<br>
								<input type="checkbox" name="tags[]" value="4">Other<br>
								<input type="checkbox" name="tags[]" value="5">Health and Wellness<br>
							</fieldset>
							<input type="submit" value="Publish Entry" name="saveEdit" class="button"> 									
							<input type="submit" value="Cancel" name="cancelEdit" class="button button-secondary">
						</form>
				</div>
		</div>
</section>
<?php include 'inc/footer.php'; ?>