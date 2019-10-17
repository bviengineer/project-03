<?php 
// Inclusion of files containing header tags and all functions need to run the application
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
<?php include 'inc/footer.php';?>