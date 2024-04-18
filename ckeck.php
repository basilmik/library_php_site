<?php

$page=substr(basename($_SERVER["REQUEST_URI"]), 0, -4);
$today=date("d.m");
$ip=$_SERVER["REMOTE_ADDR"];
$file_ips="ip".$page.".txt";
$file_count="count".$page.".txt";
$ip_c=$ip."\n";
#echo $today;
if(!file_exists($file_count))
{
	$out="1\n".$today."\n1\n";
	#echo $out;
	$fpout_count=fopen($file_count, "w+");
	fwrite($fpout_count,$out);
	fclose($fpout_count);
	$ip_count = 1;
	$fpout_ips=fopen($file_ips, "w+");
	fwrite($fpout_ips,$ip_c);
	fclose($fpout_ips);
	$total = 1;
	$today_in = 1;
}
else
{
	$file=file($file_count);
	foreach ($file as $s)
	{
		$arr[]=$s;
	}
	
	$total=(int)$arr[0];
	$that_day=(float)$arr[1];
	$today_in=(int)$arr[2];
	$total+=1;
	
	if($today!=$that_day)
		$today_in=1;
	else
		$today_in+=1;
	
	$out=$total."\n";
	$out.=$today."\n";
	$out.=$today_in."\n";
	
	$fpout_count=fopen($file_count, "w+");
	flock($fpout_count, LOCK_EX);
	fwrite($fpout_count,$out);
	flock($fpout_count, LOCK_UN);
	fclose($fpout_count);
	
	$file=file($file_ips);
	$ip_count=count($file);
	if(in_array($ip."\n", $file)== false)
	{
		$fpout_ips=fopen($file_ips, "a");
		flock($fpout_ips, LOCK_EX);
		fwrite($fpout_ips,$ip_c);
		flock($fpout_ips, LOCK_UN);
$ip_count+=1;
		fclose($fpout_ips);

	}
	
}



?>

<table>
<thead>
<th>Всего</th>
<th>Сегодня</th>
</thead>
<tbody><tr>
<td><?=$total;?></td>
<td><?=$today_in;?></td>

</tr>
<tr>

<td colspan="2">Уникальных: <?=$ip_count;?></td>
</tr>
</tbody>
</table>