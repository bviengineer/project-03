<?php 
	include 'inc/head.php'; 
	include 'inc/functions.php';
	
	// Holds selected journal entry passed to the detail.php page from index.php via $_GET
	$single_entry = get_single_entry($_GET['id']);

	// Verifies the form [content] was submitted for deletion 
	if ($_POST) {
		$_POST['id'] = $single_entry['id'];
		$_POST['title'] = $single_entry['title'];

		if (delete_single_entry($_POST['id'])) {
				header("Location: index.php?msg=Okie+dokie!+I+deleted+the+'" . $_POST['title'] . "'+journal+entry+as+requested!");
				exit;
		// Redirects to the index page if something goes wrong with the deletion request 
		} else {
				header("Location: index.php?msg=Entry+was+NOT+deleted!");
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
					<time datetime="2016-01-31"><?php echo date('F d, Y', strtotime($single_entry['date'])); ?></time>
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
						<p><?php echo $single_entry['resources']; ?></p>
					</div>
					<!-- Tag implementation -->
					<div> 
						<p class="tags">Tag(s): <a href="filtered_entries.php?tag=<?php echo $single_entry['tags']; ?>"><?php echo $single_entry['tags']; ?></p>
					</div>
				</article>
			</div>
		</div>
		<div class="edit">
			<!-- Pass request to edit journal entry to the edit.php page -->
			<p><a href="edit.php?id=<?php echo $single_entry['id'];?>">Edit Entry</a></p>
			<!-- From with delete button -->
			<form class='delete-form' method="POST" action="">
				<label for="delete-entry">&#128073; CANNOT BE UNDONE &#128400;</label>
				<input type="submit" class="delete-btn" name="deleteEntry" value="Delete Entry"> 
			</form>
		</div>
	</section>
<?php include 'inc/footer.php'; ?>