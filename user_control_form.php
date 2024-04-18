<div style="padding: 1%; padding-top: 2%;">

<table style="width:100%;" >
<tr>
<td><input class="btn" style="width:100%;"type="submit" name="see_info_btn" value=" <?php
 echo "Личный кабинет @";
$query = "SELECT name FROM users WHERE id='".$_SESSION['user_in_id']."'";
$m_query = mysqli_query($mysqli, $query);
if (!empty($m_query))
	$res=mysqli_fetch_array($m_query);
echo $res[name];
?>"></input> </td>

<td><input class="btn"  type="submit" name="exit_btn" value="Выйти"></input></td>

</tr></table>

<table  style="width:100%;" >

<tr>
<td><input class="btn"  type="submit" name="busket_btn" value="Корзина"></input> </td>
<td><input class="btn" type="submit" name="history_btn" value="История заказов"></input> </td>
</tr>
</table>
</div>
<?php
if (isset($_POST["see_info_btn"]))
{
	$_SESSION['page'] = "info"; 
}

if (isset($_POST["history_btn"]))
{
	$_SESSION['page'] = "history"; 
}

if (isset($_POST["busket_btn"]))
{
	$_SESSION['page'] = "busket"; 
}


?>