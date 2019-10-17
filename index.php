<?php 
	// Inclusion of files containing header tags and the database connection
	include 'inc/header.php';
	include 'inc/functions.php';

	// Assignment of return values or PDOStatement object result set to a variable
	//$entries = $results->fetchAll(PDO::FETCH_ASSOC);
	echo '<pre>';
	//var_dump($entries);
	echo '</pre>';

	// Print journal entries to the index page
	function print_journal_entries() {
		//global $entries; // Grants function access to the $entries variable 

		foreach (get_journal_entries() as $entry) {
			echo "<h2><a href='detail.php?id= ";
			echo $entry['id'] . " '> ";
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
						// Will print the journal entries to the page
						print_journal_entries();
					?>	
                    </article>
                </div>
            </div>
        </section>

<?php include 'inc/footer.php'; ?>