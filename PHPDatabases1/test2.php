<?php 
// display data in table
$end = 10;
echo "<table class='table table-bordered'>";
echo "<thead><tr><th>country code</th> <th>Country Name</th></tr></thead>";
// loop through results of database query, displaying them in the table
for ($i = 1; $i < $end; $i++) {
	// make sure that PHP doesn't try to show results that don't exist

	// echo out the contents of each row into a table
	echo "<tr " . "cls" . ">";
	echo '<td>' . "Hello" . '</td>';
	echo '<td>' . "Jacob" . '</td>';
	echo "</tr>";
}
?>