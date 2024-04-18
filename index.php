

<!DOCTYPE html>
<html lang="en">
<head>
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Библиотека</title>
<style>	

html, body {
	height:100%;
	margin:0;
	padding:0;
	background-color:#939596;	

}


header {
	display: flex;
	text-align: center;	
	border: 2px solid black;
		
}

h1 {
    font-size: 7em;
    margin-top: 0;
    margin-bottom: 0;
    font-weight: bold;
}

footer {
	height:10%;
	left: 0;
	right: 0;
	bottom: 0;
	border: 2px solid black;
	text-align: center;
	margin:auto;
}


.column {
	padding: 0.1%;
	margin: 0.3%;
	background-color: #cccccc;

}

.left, .right {
	width: 15%;
}
.small_column {
	width: 32%;
}

.center {
	width: 100%;
}
.center_page_n {
	width: 68%;
}

.container {
	min-height:80%;
	display: flex;
}	

.btn_container {
	margin:auto;
	width: 80%;
	display: flex;
}
.btn
{
	width:100%;
	height: 50px;
	font-size:20px;
}


</style>
</head>  


<body>


<?php
session_start();
if (isset($_SESSION['last_activity']) && (time() - $_SESSION['last_activity'] > 60*3)) 
{

	if ($_SESSION['user_in_id']!="-1")
	echo "<script type='text/JavaScript'>  alert('Вас долго не было на сайте, не забудьте авторизоваться вновь!!');  </script> "; 
    // last request was more than 3 minutes ago
    session_unset();     // unset $_session variable for the run-time 
    session_destroy();   // destroy session data in storage
}


$_SESSION['last_activity'] = time();

if (!isset($_SESSION['user'])) 
{
  $_SESSION['user'] = "out"; // in out admin
  $_SESSION['edit_book_id'] = '-1';
}

if (!isset($_SESSION['edit_book_id'])) 
{
	$_SESSION['edit_book_id'] = '-1'; 
}

if (!isset($_SESSION['page'])) 
{
  $_SESSION['page'] = "index"; 
  
}

if (!isset($_SESSION['user_in_id']))
{
	$_SESSION['user_in_id']="-1";
	
}

?>

	<?php 
	include("setup.php");
	?>

	<?php
	if (isset($_POST["exit_btn"]))
	{$_SESSION['user'] = "out"; 
	$_SESSION['page'] = "index";
	$_SESSION['user_in_id']="-1";
	}
	
	if (isset($_POST["enter_admin"]))
		$_SESSION['user'] = "admin"; 
		
	if (isset($_POST["exit_admin"]))
	{
		$_SESSION['user'] = "out"; 
		$_SESSION['page'] = "index";
	}
	
	if (isset($_POST["register_btn"]))
	{
		$_SESSION['user'] = "out";
		$_SESSION['page'] = "register"; 
	}
	
	if (isset($_POST["send_UI"]))
		$_SESSION['page'] = $_POST["send_UI"];

	
	function login_user($login, $pass)
	{
		global $mysqli;
		$query = 
		"SELECT id FROM users WHERE login='$login' AND password='$pass'";
		$m_query = mysqli_query($mysqli, $query);
		if (!empty($m_query))
		{
			$res=mysqli_fetch_array($m_query);
		
			if (!empty($res))	
			{
				$_SESSION['user'] = "in"; 
				$_SESSION['page'] = "katalog"; 
				$_SESSION['user_in_id']= $res[id];
				header("Refresh:0");
			}
			else
				echo "<script type='text/JavaScript'>  alert('Ошибка авторизации!');  </script> "; 
		}		
	}
	?>
	

	<header>

	<div class="container column center_page_n">
	<div class="column small_column">
	<img src= 'mainimg.png' width='160' height='120'/>
	</div>
    <h1>БИБЛИОТЕКА</h1>
	</div>	

	<div class="column small_column" style="text-align: left; font-size:18px;">
	
	<form method="POST" >
	<?php
	if($_SESSION['user'] == "in")
		include("user_control_form.php");			
	else
		include("auth_form.php");
	
	?>	
	</form> 
	</div>

	</header>
	
<div class="container" style="text-align: left; font-size:18px;">

	<?php
	$_SESSION['edit_book_id'] = '-1';
	include("user_content.php");
	?>

</div>

<footer>
	<table style="margin:auto;" >
	<tr style="margin:auto;">
	<td><h2>Библиотека котика Ио (Михайлова Василиса 1044)</h2></td>
	<td><?php  include("ckeck.php"); ?></td>

	</tr>
</table>

</footer>



</body>
</html>
