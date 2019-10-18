<?php 
	include 'inc/head.php'; 
	include 'inc/functions.php';
	
	$single_entry = get_single_entry($_GET['id']); // Will hold selected journal entry
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
												<h1><?php echo $single_entry['title']; ?></h1>
                        <time datetime="2016-01-31"><?php echo $single_entry['date']; ?></time>
                        <div class="entry">
                            <h3>Time Spent: </h3>
                            <p><?php echo $single_entry['time_spent']; ?></p>
                        </div>
                        <div class="entry">
                            <h3>What I Learned:</h3>
                            <p><?php echo $single_entry['learned']; ?></p>
                        </div>
                        <div class="entry">
                            <h3>Resources to Remember:</h3>
                            <ul>
                                <li><?php echo $single_entry['resources']; echo $single_entry['id'];?></li>
                            </ul>
                        </div>
                    </article>
                </div>
            </div>
            <div class="edit">
                <p><a href="edit.php?=<?php echo $single_entry['id']; ?>">Edit Entry</a></p>
            </div>
        </section>
				<?php include 'inc/footer.php'; ?>