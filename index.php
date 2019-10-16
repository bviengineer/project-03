<?php 
	// Inclusion of files containing header tags and the database connection
	include 'inc/header.php';
	include 'inc/dbconnection.php';

	// Retrieving entries from the database
	try {
			$results = $db->query("SELECT * FROM entries"); //TRY ADDING LIMIT 2 
	} catch (Exception $e) {
			echo $e->getMessage();
			die();
	}

	// Assignment of return values or PDOStatement object result set to a variable
	$entries = $results->fetchAll(PDO::FETCH_ASSOC);
	echo '<pre>';
	//var_dump($entries);
	echo '</pre>';

	// Print journal entries to the index page
	function get_journal_entries() {
		global $entries; // Grants function access to the $entries variable 

		foreach ($entries as $entry) {
			echo "<h2><a href='detail.php?id= ";
			echo $entry['id'] . '>';
			echo $entry['title'];
			echo "</a></h2>";
			echo "<time>";
			echo $entry['date'];
			echo "</time>";
			echo "<hr>";
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
                <div class="entry-list">
                    <article>
					<?php 
						get_journal_entries();
					?>	
                    </article>
                </div>
            </div>
        </section>

<?php include 'inc/footer.php'; ?>