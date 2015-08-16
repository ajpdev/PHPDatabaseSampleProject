<?php
require_once('database.php');

try{
    $result = $db->query('select * from film');
    
} catch (Exception $e) {
    $e->getMessage();
    die();
}

$films = $result->fetchAll(PDO::FETCH_ASSOC);

// ADDED FOR PAGINATION OF RESULTS


$row_count = count($films);
// number of rows in a page
$page_rows = 10; 
//getting the last page
$last_page = ceil($row_count/$page_rows);
//makes sure the last_page cannot be less than 1
if($last_page < 1){
  $last_page = 1;
}

//establishing the $pagenum variable
$pagenum = 1;
//get pagenum from URL vars if it is present, else it is 1
if(isset($_GET['pn'])) {
  $pagenum = preg_replace('#[^0-9]#','',$_GET['pn']);
}

//this makes sure that the page num is not < 1, and not > lastpage
if ($pagenum < 1) {
  $pagenum = 1;
} else if ($pagenum > $last_page) {
  $pagenum = $last_page;
}

// This sets the range of rows to query for the chosen $pagenum
$limit = 'LIMIT ' .($pagenum-1) * $page_rows . ',' .$page_rows;
$sql = "SELECT * FROM FILM ORDER BY film_id " . $limit;

try{
    $result2 = $db->query($sql);
    
} catch (Exception $e2) {
    
    $e2->getMessage();
    die();
}

$paginated_films = $result2->fetchAll(PDO::FETCH_ASSOC);
$textline1 = "Total Records <b>$row_count</b>";
$textline2 = "Page <b>$pagenum</b> of <b>$last_page</b>";

// establishing the $pagination controls variable
$paginationCtrls = '';

if ($last_page != 1){
/* First we check if we are on page 1. If we are, then we don't need a link
 for the previous page or the 1st page so we do nothing. Else, generate a 
 link to the previous page and or the 1st page. 
 */
	if ($pagenum > 1){
		$previous = $pagenum - 1;
		//TODO check what is $_SERVER['PHP_SELF']
		$paginationCtrls .= '<a href="'. $_SERVER['PHP_SELF'].'?pn='.$previous.'">Previous</a> &nbsp; &nbsp;';
		//Render clickable number links that would apper on the LEFT side of the target page number
		for($i = $pagenum-4; $i < $pagenum; $i++){
			//e.g. if you are on page 7, there are 4 little link 6,5,4,3 on the left side
			if($i>0){
				$paginationCtrls .= '<a href="'. $_SERVER['PHP_SELF'].'?pn='.$i.'">'.$i.'</a> &nbsp; ';
			}
		}
	}
	//render the target page number, but without it being a link (no need bec user is already ON THAT page)
	$paginationCtrls .= ''.$pagenum.' &nbsp; ';
	//Render clickable number links that would apper on the RIGHT side of the target page number
	for($i = $pagenum+1; $i <= $last_page; $i++){
		//e.g. if you are on page 7, there are 4 little link 6,5,4,3 on the left side
		$paginationCtrls .= '<a href="'. $_SERVER['PHP_SELF'].'?pn='.$i.'">'.$i.'</a> &nbsp; ';
		if($i >= $pagenum+4 ){
			// stops the loop after it has run 4 times, so that only 4 links are seen
			break;
		}
	}
	if ($pagenum != $last_page){
		$next = $pagenum + 1;
		$paginationCtrls .= '<a href="'. $_SERVER['PHP_SELF'].'?pn='.$next.'">Next</a> &nbsp; ';	
	}
}


?>

<!DOCTYPE html>

<html lang="en">

	<head>
	
	  <meta charset="UTF-8">
	  <title>PHP Data Objects</title>
	  <link rel="stylesheet" href="style.css">
	
	</head>

	<body id="home">
	
		<h1>Sakila Sample Database</h1>
	
		<h2>Films by Title</h2>
	 	<div>
			<ol>
			    <?php
			        foreach ($paginated_films as $film) {
			          echo '<li><i class="lens"></i><a href="films.php?id='.$film['film_id'].'">'. $film['title'] .'</a></li>';
			        }
			      ?>
		  </ol>
	   </div>
	   <br>
		<h1>Table Format of the above.....</h1>
	 	<div>
	 		<table border="1" id="table1">
	 			<thead>
					<tr>
						<th>Film_ID</th>
						<th>Title</th>
						<th>Description</th>
						<th>Release_Year</th>
						<th>Film Length (mins)</th>
					</tr>
				</thead>
				<?php
					//paginated films are the films filtered already that you should work on
			        foreach ($paginated_films as $film) {
			        	echo '<tr>';
			        	//column count = 5 shown above in thead values
// 			        	for($columnNum = 1; $columnNum <= 5; $columnNum++){
			        	echo '<td>'.$film['film_id'].'</td>';
			        	echo '<td>'.$film['title'].'</td>';
			        	echo '<td>'.$film['description'].'</td>';
			        	echo '<td>'.$film['release_year'].'</td>';
			        	echo '<td>'.$film['length'].'</td>';
// 			        	}
			        	echo '</tr>';
			          }
			      ?>
				
			</table>
			    
	   </div>	
		<div id="bottom_div">
			<h2><?php echo $textline1; ?> Paged</h2>
			<p><?php echo $textline2; ?></p>
			<div id="pagination_controls"><?php echo $paginationCtrls; ?></div>
		</div>
	
	</body>

</html>