<?php
require_once('liblcsg.php');
header('Content-Type: text/html; charset=UTF-8');
?>
<html>
<head>
	<title>liblcsg usage example</title>
</head>
<body>
<h3>Loto card set generator</h3>

<?php foreach (\liblcsg\createCardSet() as $card): ?>
	<table border="1px">
		<?php foreach ($card as $line): ?>
			<tr>
				<?php foreach ($line as $num): ?>
					<td width="20px"><?= ($num ? $num : '') ?></td>
				<?php endforeach; ?>
			</tr>
		<?php endforeach; ?>
	</table><br/>
<?php endforeach; ?>

</body>
</html>
