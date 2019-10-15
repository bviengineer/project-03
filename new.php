<?php include 'inc/header.php'; 

// Use prepared statements to add/edit/delete journal entries in the database.
// Create “add/edit” view for the "entry" page that allows the user to add or edit journal entries with the following fields: title, date, time_spent, learned, and resources. Each journal entry should have a unique primary key.

    if ($_POST && $_POST !='') {
        //use trim() function to remove whites pace before and after 
      $title = $_POST['title'];
      $title = $_POST['date'];
      $title = $_POST['timeSpent'];
      $title = $_POST['whatILearned'];
      $title = $_POST['ResourcesToRemember'];
			echo '<pre>';
				var_dump($_POST);
			echo '</pre>';
      //echo "<br>Your title is: " . $title . "<br>";
    } elseif($_POST && $_POST == '') {
				echo "you didn't enter any data";
		}

//     // Function will add a new journal entry to the database
//     function add_journal_entry($title, $date, $time_spent, $learned, $resources){
//         include 'inc/dbconnection.php';
        
//         $addEntry = "INSERT INTO entries (title, date, time_spent, learned, resources) VALUES($title, $date, $time_spent, $learned, $resources)";
//     }
?>
    <body>
        <header>
            <div class="container">
                <div class="site-header">
                    <a class="logo" href="index.php"><i class="material-icons">library_books</i></a>
                    <a class="button icon-right" href="new.html"><span>New Entry</span> <i class="material-icons">add</i></a>
                </div>
            </div>
        </header>
        <section>
            <div class="container">
                <div class="new-entry">
                    <h2>New Entry</h2>
                    <form method="POST" action="#">
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