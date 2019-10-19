<?php 
	include 'inc/head.php'; 
	include 'inc/functions.php';

	//$id = $_GET['id'];
	//get_single_entry($id=null);
	//var_dump($db);
	// Use prepared statements to edit/delete journal entries in the database.
	if (isset($_GET['id'])) {
			echo "it is " . $_GET['id'];
	} else {
			echo "no id passed";
	}

	//get_single_entry($_POST['id']);

	// function edit_journal_entry() {
	//   try {
	// 			$results = $db->query("SELECT title, date, time_spent, learned, resources FROM entries WHERE title LIKE '%Today%");
	// 		} catch (Exception $e) {
	//     $e->getMessage();
	//    }
	// }
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