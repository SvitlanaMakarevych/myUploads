<?php
	ini_set('display_errors', 1);
	ini_set('display_startup_errors', 1);
	error_reporting(E_ALL);

	function prTable($upwd) {
		$dh = scandir($upwd);
		//echo '<table border=1>';
		?>
		<table border=1>
		<tr>
			<td>Назва файлу</td>
			<td>Розмір файлу(байти)</td>
			<td>Скачати</td>
			<td>Видалити</td>
		</tr>
		<?php
		//print_r($dh);
		foreach ($dh as $v) {
			if ($v == '.') continue;
			if ($v == '..') continue;
			echo '<tr>';
			
			echo '<td>', $v, '</td>';
			echo '<td>', filesize($upwd.$v), '</td>';
			echo '<td><a href=\'', $upwd.$v ,'\' download>Скачати</a></td>';
			echo '<td><a href=\'?remove=',$v,'\'>Видалити</a></td>';
			
			echo '</tr>';
		}
		//echo '</table>';
		?>
		</table>
		<?php
	}

?>
<form enctype="multipart/form-data" action="index.php" method="POST">
  
    <input type="hidden" name="MAX_FILE_SIZE" value="30000" />
    Надіслати цей файл: <input name="userfile" type="file" />
    <input type="submit" value="Надіслати" />
</form>

<?php
$uploaddir = './files/';

if (isset($_GET['remove'])) {
	if (file_exists($uploaddir.$_GET['remove'])) {
		unlink($uploaddir.$_GET['remove']);
	}
}

if (isset($_FILES['userfile']['tmp_name'])) {
	$uploadfile = $uploaddir . basename($_FILES['userfile']['name']);
	//echo '<pre>';
	if (move_uploaded_file($_FILES['userfile']['tmp_name'], $uploadfile)) {
		echo "Файл коректний і був успішно завантажений.\n";
	} else {
		echo "Неправильний формат, або файл занадто великий\n";
	}

	}
prTable($uploaddir);