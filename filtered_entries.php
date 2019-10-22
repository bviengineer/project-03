<?php 
	// Inclusion of files containing header tags and all functions needed to run the application
	include 'inc/head.php';
	include 'inc/functions.php';

	$filtered_entries = get_filtered_entries($_GET['tag']);
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
				<h6>
					<?php
						echo "On filtered_entries page";
					?>
				</h6>
				<div class="entry-list">
          <article>
						<?php 
							// Will print the journal entries from the database, based on the tag the user selected 
							 echo $filtered_entries;
							 //print_journal_entries();
						?>	
					</article>
        </div>
      </div>
    </section>
<?php include 'inc/footer.php';?>