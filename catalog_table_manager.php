
<?php
	$query_created_base = 
	"
	SELECT DISTINCT 
	books.id as book_id,
	books.name as book_name,
	books.year_published as book_year_published,
	books.description as book_description,
	books.file_name as book_picture
	FROM books
	";
?>



<?php
function create_view_catalog($mysqli, $query)
{
	
	echo '<form method="POST">';
	echo '<table>';
	echo '<tr>';
	echo '<th style="text-align: center; width:10%;">Обложка</th>';
	echo '<th style="text-align: center; width:15%;">Название</th>';
	echo '<th style="text-align: center; width:20%;">Авторы</th>';
	echo '<th style="text-align: center; width:20%;">Жанры</th>';
	echo '<th style="text-align: left; width:10%;">Год публикации</th>';
	echo '<th width="25%"  style="text-align: center;">Описание</th>';
	if ($_SESSION['user'] == "in")
		{
			echo '<th width="5%">Добавить в корзину</th>';
		}
	echo '</tr>';
$counter = 0;
	if (!empty(	$query))
	while($res=mysqli_fetch_array($query))
	{
		if ($counter %2 == 0)
			echo "<tr style='background-color: #cccccc;'>";
		else
			echo "<tr style='background-color: #e3e3e3;'>";
		$counter+=1;

		create_simple_row($mysqli, $res);
		
		if ($_SESSION['user'] == "in")
		{
			echo "<td style='text-align: center; height:100%;'>
			<button type='submit' name='add_this_book_btn' value='$res[book_id]' style='width:70px; height:70px;'>Добавить</button>
			</td>";
			
		}
				
		echo "</tr>";
			
	}
	
	echo "</table>";	
	echo "</form>";	
}

	
	function create_cell($content, $type, $name = '')
	{

		echo "<td>";
		if ($type == "value")
		{
			echo $content;
		}
		else
		if ($type == "input_text")
		{		
			echo "<input type='text' name='$name' value = '$content' size='12'/>";
		}
		else
		if ($type == "input_number")
		{		
			echo "<input type='number' name='$name' value = '$content' size='12'/>";
		}
		elseif ($type == "textarea")
		{
		echo "<textarea name='$name' rows='5' cols='20'/>$content</textarea>";
		}
		echo "</td>";
	}
	

	function create_simple_row($mysqli, $res)
	{
		if (!empty($res[book_picture]))
			$pic_name =$res[book_picture]; 
		else
			$pic_name ='none.jpg';
		
		$pic_content="<img src= '".$pic_name."'width='100' height='100' style='display: block;margin-left: auto; margin-right: auto;'/>";
		$authors_list = create_authors_list($mysqli, $res);
		$genres_list = create_genres_list($mysqli, $res);
				
		create_cell($pic_content, "value");
		create_cell($res[book_name], "value");
		create_cell($authors_list, "value");	
		create_cell($genres_list, "value");
		create_cell($res[book_year_published], "value");
		create_cell($res[book_description], "value");
	}	

	function create_authors_cheked_list($mysqli,$res)
	{
		$query_this_book = query_books_authors($mysqli,$res[book_id]);
			
		while($this_book_res=mysqli_fetch_array($query_this_book))
			$this_book_list[]=$this_book_res[id];

		$query=mysqli_query($mysqli, "select authors.id, CONCAT(authors.name, ' ', authors.surname) as name from authors");
		$i = 0;
		while($all_list=mysqli_fetch_array($query))
		{
			echo "<input type='checkbox' name='authors_list[]' value='$all_list[id]' ";
			if (!empty($this_book_list) and in_array($all_list[id], $this_book_list))
				echo " checked ";
			echo ">".$all_list[name]."<br>";
		}
	}	

	function create_genres_cheked_list($mysqli,$res)
	{
		$query_this_book = query_books_genres($mysqli,$res[book_id]);
			
		while($this_book_res=mysqli_fetch_array($query_this_book))
			$this_book_list[]=$this_book_res[id];

		$query=mysqli_query($mysqli, "SELECT genres.id, genres.name FROM genres");
		$i = 0;
		while($all_list_g=mysqli_fetch_array($query))
		{
			echo "<input type='checkbox' name='genres_list[]' value='$all_list_g[id]' ";
			if (!empty($this_book_list) and in_array($all_list_g[id], $this_book_list))
				echo " checked ";
			echo ">".$all_list_g[name]."<br>";			
		}	
	}
		
	
	function create_edit_row($mysqli = 0, $res = 0)
	{
		if (!empty($res[book_picture]))
			$pic_name =$res[book_picture]; 
		else
			$pic_name ='none.jpg';
		
		$pic_content="<img src= '".$pic_name."'width='100' height='100'/>";

				
		$authors_list = create_authors_list($mysqli, $res);
		$genres_list = create_genres_list($mysqli, $res);
		
		create_cell($res[book_picture], "input_text", "book_picture");
		create_cell($res[book_name], "input_text", "book_name_e");

		echo "<td>";
		create_authors_cheked_list($mysqli,$res);
		echo "</td>";
		
		echo "<td>";
		create_genres_cheked_list($mysqli,$res);
		echo "</td>";

		create_cell($res[book_year_published], "input_number", "book_year_published");
		create_cell($res[book_description], "textarea", "book_description");
	}		

	function query_books_authors($mysqli, $book_id)
	{
		$query_created_this_book_author = 
		"SELECT authors.id, CONCAT(authors.name, ' ', authors.surname) as name 
		FROM authors 
		JOIN book_author 
		ON book_author.author_id = authors.id
		WHERE
		book_author.book_id = $book_id
		";
		return  mysqli_query($mysqli, $query_created_this_book_author);
			
	}	

	function query_books_genres($mysqli, $book_id)
	{
		$query_created_this_book_genre = 
		"SELECT genres.id, genres.name 
		FROM genres 
		JOIN book_genre 
		ON book_genre.genre_id = genres.id
		AND
		book_genre.book_id = $book_id
		";
		return mysqli_query($mysqli, $query_created_this_book_genre);
	}	

	
	function create_authors_list($mysqli, $res)
	{
		$i = 0;
		$query_this_book_authors = query_books_authors($mysqli, $res[book_id]);
		$list ="";
		while($res_this_book_author=mysqli_fetch_array($query_this_book_authors))
		{
			if ($i > 0)
				$list.=", ";
			$list.= $res_this_book_author[name];
			$i++;
		}	
		return $list;
	}
	
	function create_genres_list($mysqli, $res)
	{
		$i = 0;
		$query_this_book_genres = query_books_genres($mysqli,$res[book_id]);

		$list ="";
		while($res_this_book_genres=mysqli_fetch_array($query_this_book_genres))
		{
			if ($i > 0)
				$list.=", ";
			$list.= $res_this_book_genres[name];
			$i++;
		}	
		return $list;
	}


function create_main()
{
	global $query_created_base;
	$query_created = $query_created_base;

	if (isset($_POST['send_spec']))
	{

		if (count($_POST["author_name"]) > 0)
		{
			$query_created.= "JOIN book_author 
				ON book_author.book_id = books.id ";	
		}		
		
		if (count($_POST["genre"]) > 0)
		{
			$query_created.= "JOIN book_genre 
				ON book_genre.book_id = books.id ";	
		}
		
		$where_flag = false;
		
		for ($i = 0; $i < count($_POST["author_name"]); $i++)
		{
			$ath=$_POST["author_name"][$i];

			if ($i == 0)
			{	
				$query_created.= " WHERE (";	
				$where_flag = true;
			}
			
			if ($i > 0)
			{
				$query_created.=" OR ";
			}
			
			$query_created.=" book_author.author_id = $ath ";
			
			
			if ($i == count($_POST["author_name"])-1)
			{	
				$query_created.=") ";
			}
		}	

			
		for ($i = 0; $i < count($_POST["genre"]); $i++)
		{
			$g=$_POST["genre"][$i];

			if ($i == 0)
			{	
				if ($where_flag == false)
				{
					$query_created.= " WHERE (";
					$where_flag = true;
				}
				else
					$query_created.= " AND (";
			}
			
			if ($i > 0)
			{
				$query_created.=" OR ";
			}
			
			$query_created.=" book_genre.genre_id = $g ";
			
			
			if ($i == count($_POST["genre"])-1)
			{	
				$query_created.=") ";
			}
		}	
		
				
// years
		if (!empty($_POST['min_year']) or !empty($_POST['max_year']))
		{
			if ($where_flag == false)
				{
					$query_created.= " WHERE ";
					$where_flag = true;
				}
				else
					$query_created.= " AND ";
		
			if (!empty($_POST['min_year']))
			{
				$min_year = $_POST['min_year'];
				$query_created.= " books.year_published >= $min_year ";
			}
			if (!empty($_POST['min_year']) and !empty($_POST['max_year']))
			{
				$query_created.= "AND ";
			} 
			if (!empty($_POST['max_year']))
			{
				$max_year = $_POST['max_year'];
				$query_created.= "books.year_published <= $max_year ";
			}
		}
	}
	
	if (!empty($_POST['book_name']))
		{
			$val = $_POST["book_name"];
			$pattern = "\"%".$val."%\"";
			
			if ($where_flag == false)
					$query_created.= " WHERE (";
				else
					$query_created.= " AND (";
			$query_created .=" books.name LIKE $pattern ";	
		}
	
	//echo $query_created;
	return $query_created;
}





	
?>
	
