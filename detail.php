<?php 
	include 'inc/head.php'; 
	include 'inc/functions.php';
	
	// Variable will hold selected journal entry
	$single_entry = get_single_entry($_GET['id']);
	
	// Will check whether the form with the delete button was submitted & delete the journal entry 
	if ($_POST) {
		$_POST['id'] = $single_entry['id'];
		if (delete_single_entry($_POST['id'])) {
				header("Location: index.php?msg=Entry+Deleted");
				exit;
		} else {
				header("Location: index.php?msg=Entry+was+NOT+deleted");
				exit;
		}
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
                <div class="entry-list single">
                    <article>
												<!-- Printing of journal entry details to the page  -->
												<h1><?php echo $single_entry['title']; ?></h1>
                        <time datetime="2016-01-31"><?php echo $single_entry['date']; ?></time>
                        <div class="entry">
                            <h3>Time Spent: </h3>
                            <p><?php echo $single_entry['time_spent']; ?> minutes</p>
                        </div>
                        <div class="entry">
                            <h3>What I Learned:</h3>
                            <p><?php echo $single_entry['learned']; ?></p>
                        </div>
                        <div class="entry">
                            <h3>Resources to Remember:</h3>
                            <ul>
                                <li><?php echo $single_entry['resources']; ?></li>
                            </ul>
                        </div>
                    </article>
                </div>
            </div>
            <div class="edit">
								<!-- Pass request to edit journal entry to the edit.php page -->
                <p><a href="edit.php?id=<?php echo $single_entry['id'];?>">Edit Entry</a></p>

								<!-- From with delete button -->
								<form class='delete-form' method="POST" action="">
									<label for="delete-entry"></label>
									<input type="submit" class="delete-btn" name="deleteEntry" value="Delete Entry"> 
								</form>
            </div>
        </section>
				<?php include 'inc/footer.php'; ?>