<?php 
// Inclusion of files containing header tags and all functions needed to run the application
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
		<h1 class='page-heading'><span class='index-title'>The Minimalistic</span> <span class="index-title2">Journal</span></h1>
			<h6>
				<?php
					if (isset($_GET['msg'])) {
						echo $_GET['msg'];
					} else {
						echo '';
					}
				?>
			</h6>
			<div class="entry-list">
				<article>
					<?php 
						// Will print the journal entries from the database, to the page
						print_journal_entries();
					?>	
				</article>
			</div>
		</div>
	</section>
<?php include 'inc/footer.php';?>