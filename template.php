<!DOCTYPE html>
<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>
	<title></title>
</head>
<body>

	<?php 

	require_once __DIR__."/Paginator.php";

	$pdo = new \PDO("mysql:host=localhost;port=3306;dbname=users", "root", "");

	$stmt = $pdo->prepare("select * from users");

	$stmt->execute();

	$result = $stmt->fetchAll(\PDO::FETCH_ASSOC);

	$paginator = new Paginator("/Paginator/template.php", 5);

	$paginator->setData($result);

	$paginator->setNumberLinks(5);

	$results = $paginator->resultFromPage();

	?>

	<table class="table table-bordered col-6">
	<?php foreach($results as $item): ?>
		<tr>
			<td><?= $item['id']; ?></td>
			<td><?= $item['first_name']; ?></td>
			<td><?= $item['last_name']; ?></td>
			<td><?= $item['email']; ?></td>
		</tr>
	<?php endforeach; ?>
	</table>
	<div class="pagination bordered rounded-3">
	
		<?php echo $paginator->links(); ?>

	</div>

</body>
</html>
