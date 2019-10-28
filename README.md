# Project 03
 Treehouse PHP Techdegree ~ Personal Learning Journal App

# About Project
### Under the Hood
The PHP Personal Learning Journal is constructed using HTML, CSS, PHP and MySQL. Base files were provided and included HTML, CSS and a database with sample about four sample entries. Two tables were added for use with this project.


### I'll Show You Around
![screenshot of the home page](img/screenshot.png)
On the index or home page, there is a list view of journal entires with category tags. The journal entries are stored in and pulled from a MySQL database. 
1. Clicking on one of the entries from the home page will provide a detail view of the entry. 
2. While on the detail view of the entry, it can be *deleted or edited.*
3. Also while on the home page or from the deatails page for a given entry, clicking on a a tag name will redirect to another page with a list view of all entries with the same tag. 
4. From the filtered page, you can click on a given entry and be redirected to its corresponding detils page.
5. There is also the abillity to add a new entry from any page, even while in edit mode.
6. If a page is deleted, the editing or deletion of an entry is cancelled, the user is redirected back to the index apge and an action appropraite confirmation message is provided. 


### The Logic
Hilighting a few important files:
```functions.php``` contains the functions that are at the core of the application.

```dbconnection.php``` provides the connection to the MYSQl database.

```index.php``` displays a list view of the journal entries.

```details.php``` displays the detailed view for each entry.

```edit.php``` allows a user to edit the journal entry.

```filtered_entries.php``` displays a list view of all categorically related entries.