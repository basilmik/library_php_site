<div style = "margin: auto; width: 300px; text-align: center; background-color: #adadad; padding: 2%; margin-top: 1%;">
<form method="POST">
<?php

$q = "SELECT * FROM users WHERE id = ".$_SESSION['user_in_id'];

$query = mysqli_query($mysqli, $q);
if (!empty($query))
{
	$res=mysqli_fetch_array($query);
}

if ($_SESSION['user_in_id']!= "-1") // if logged in
$read_only_state="readonly";
else 
$read_only_state="";

?>
<h2>Обратная связь:</h2>
<table style = "margin: auto; text-align: center; font-size: 20px;">
	<tr>
	<tr>
	<td>имя:</td>
	<td><input type="text" <?=$read_only_state;?> name="letter_username" value="<?php echo $res[name];?>"></td>
	</tr>	
	
	<tr>
	<td>email:</td>
	<td><input type="text" <?=$read_only_state;?> name="letter_email" value="<?php echo $res[email];?>"></td>
	</tr>
	
		<tr>
	<td>Сообщение:</td>
	<td><textarea name="text_email" ></textarea></td>
	</tr>
	
	
	</table>
<br>
	<input class="btn" style="width:100%;" type="submit" name="send_btn" value="Отправить"></input> 
</form>

</div>

<?php

if (isset($_POST["send_btn"]))
{
$message = "Имя: ".$_POST["letter_username"]."\nemail: ".$_POST["letter_email"]."\nСообщение： ".$_POST["text_email"];	

$headers="From: egbasilmik@mail.ru\r\n";
$headers.="Reply-To: egbasilmik@mail.ru\r\n";
$headers.="X-Mailer: PHP/".phpversion();
$to ='egbasilmik@mail.ru';
$subject=' feedback from: '.$_POST["letter_email"];
if (mail($to, $subject, $message, $headers))
{
	echo "<script type='text/JavaScript'>  alert('Отправлено!');  </script> ";
}
else
{
	echo "<script type='text/JavaScript'>  alert('Ошибка отправки :(');  </script> ";

}
	header("refresh:0");
}



?>
