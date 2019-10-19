<?php 
	include 'inc/head.php'; 
	include 'inc/functions.php';

	if (isset($_GET['id'])) {
		$edit_entry = get_single_entry($_GET['id']);
	}
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
                    <form method="POST" action="">
                        <label for="title"> Title</label>
                        <input id="title" type="text" name="title" value="<?php echo $edit_entry['title']; ?>"><br>
                        
												<label for="date">Date</label>
                        <input id="date" type="date" name="date" value="<?php echo $edit_entry['date']; ?>"><br>
                        
												<label for="time-spent"> Time Spent</label>
                        <input id="time-spent" type="text" name="timeSpent" value="<?php echo $edit_entry['time_spent']; ?>"><br>
                        
												<label for="what-i-learned">What I Learned</label>
                        <textarea id="what-i-learned" rows="5" name="whatILearned"><?php echo $edit_entry['learned']; ?></textarea>
                        
												<label for="resources-to-remember">Resources to Remember</label>
                        <textarea id="resources-to-remember" rows="5" name="ResourcesToRemember"><?php echo $edit_entry['resources']; ?></textarea>
                       
											  <input type="submit" value="Publish Entry" class="button">
                        <a href="#" class="button button-secondary">Cancel</a>
                    </form>
                </div>
            </div>
        </section>
        <?php include 'inc/footer.php'; ?>