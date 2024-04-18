	<?php
	include("catalog_table_manager.php");

echo "<div style = 'margin: auto; background-color: #adadad; padding: 0.5%; margin: 1%;'> ";
	echo "<h2 style='text-align: center;'>Каталог книг</h2>";
	$query_created = create_main();

	$query = mysqli_query($mysqli, $query_created);
	
	create_view_catalog($mysqli, $query);
	echo "</div>";

	?>

