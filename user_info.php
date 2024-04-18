<div style = "margin: auto; width: 300px; text-align: center; background-color: #adadad; padding: 2%; margin-top: 1%;">
<form method="POST">
<h2 style="">Личный кабинет</h2> 
<?php

$q = "SELECT * FROM users WHERE id = ".$_SESSION['user_in_id'];

$query = mysqli_query($mysqli, $q);
if (!empty($query))
{
	$res=mysqli_fetch_array($query);
}
$read_only_state="readonly";
$hidden_change="";
$hidden_two="hidden";
$see_pass="password";

if (isset($_POST["cancel_changes_btn"]))
{
	$read_only_state="readonly";
	$hidden_change="";
	$hidden_two="hidden";
	$see_pass="password";
}

if (isset($_POST["change_btn"]))
{
	$read_only_state="";
	$hidden_two="";
	$hidden_change="hidden";
	$see_pass="text";
}

?>
<table style = "margin: auto; text-align: center; font-size: 20px;">
	<tr>

	<td>логин:</td>
	<td><input type="text" <?=$read_only_state;?> name="user_login" value="<?php 

		echo $res[login];?>">
</td>
	</tr>

	<tr>
	<td>пароль:</td>
	<td><input type="<?=$see_pass?>" <?=$read_only_state;?> name="user_password"  value="<?php echo $res[password];?>"></td>
	</tr>
	
	<tr>
	<td>имя:</td>
	<td><input type="text" <?=$read_only_state;?> name="user_name" value="<?php echo $res[name];?>"></td>
	</tr>	
	
	<tr>
	<td>email:</td>
	<td><input type="text" <?=$read_only_state;?> name="user_email" value="<?php echo $res[email];?>"></td>
	</tr>
	
	</table>
<br>
	<input class="btn" <?=$hidden_change?> style="width:100%;" type="submit" name="change_btn" value="Изменить данные"></input> 

	<div id="save_cancel_edit" <?=$hidden_two?>>
	<input class="btn" style="width:100%;" type="submit" name="save_changes_btn" value="Сохранить изменения"></input> 
	<br><br>
	<input class="btn" style="width:100%;" type="submit" name="cancel_changes_btn" value="Отмена"></input> 
</div>
</form>

</div>

<?php

if (isset($_POST["save_changes_btn"]))
{

	$q = "UPDATE users 
	SET login='".$_POST["user_login"]."', 
	password='".$_POST["user_password"]."', 
	name='".$_POST["user_name"]."', 
	email='".$_POST["user_email"]."' WHERE id =".$_SESSION['user_in_id'];
	$query = mysqli_query($mysqli, $q);
	echo "<script type='text/JavaScript'>  alert('Обновлено!');  </script> ";
	header("refresh:0");

}



?>
