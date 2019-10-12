<?php 
	// Including the file with the header tags and the database connection
	include 'inc/header.php';
	include 'inc/dbconnection.php';

	// Retrieving entries from the database
	try {
			$results = $db->query("SELECT * FROM entries"); //TRY ADDING LIMIT 2 
	} catch (Exception $e) {
			echo $e->getMessage();
			die();
	}

	// Assigning PDOStatement object result set to a variable
	$entries = $results->fetchAll(PDO::FETCH_ASSOC);
	echo '<pre>';
	//var_dump($entries);
	echo '</pre>';

	// Looping through the array of entries & printing title and date to the index page
	// function print_entries(){	
	// 	global $entries;
	
	// 	foreach ($entries as $entry) {	
	// 		$title = strtolower($entry['title']);

	// 		echo "<h2><a href=' ";
	// 		if ($title == strtolower("The best day I ever had") ) {
	// 				echo "detail.php' >";

	// 		} elseif ($title == strtolower("The absolute worst day I’ve ever had")) {
	// 				echo "detail_2.php' >";

		 //} elseif ($title == strtolower("That time at the mall")) {
			// 	echo "detail_3.php' >";

			// } elseif ($title == strtolower("Dude, where’s my car?")) {
			// 	echo "detail_4.php' >";
			// } else {
			// 		echo "#";
			// }
			//echo "detail.php' >";
			//echo $entry['title'];
			//echo $entry["title"] . "</a></h2>";
			//echo "</a></h2>";
			// echo "<time datetime=" . $entry["date"] . '>' . $entry["date"] . "</time> <br>";
			//}
		//}
	//}

	//print_entries();

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
                <div class="entry-list">
                    <article>
										<h2><a href="detail.php"><?php echo $entries[0]['title']; ?> </a></h2>
                        <time datetime=<?php echo $entries[0]['date']; ?> > <?php strtotime($entries[0]['date']); ?></time> <!-- "2018-01-31" January 31, 2016-->
                    </article>
                    <article>
                        <h2><a href="detail_2.html"><?php echo $entries[1]['title']; ?></a></h2>
                        <time datetime="2016-01-31">January 31, 2016</time>
                    </article>
                    <article>
                        <h2><a href="detail_3.php"> <?php echo $entries[2]['title']; ?></a></h2>
                        <time datetime="2016-01-31">January 31, 2016</time>
                    </article>
                    <article>
                        <h2><a href="detail_4.php"><?php echo $entries[3]['title']; ?></a></h2>
                        <time datetime="2016-01-31">January 31, 2016</time>
                    </article>
                </div>
            </div>
        </section>

<?php include 'inc/footer.php'; ?>