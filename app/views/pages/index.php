<?php require APP_ROOT . '/views/inc/header.php' ?>

<div class="jumbotron jumbrotron-fluid">
	<div class="container">
		<h1 class="display-3"><?php echo $data['title']; ?></h1>
		<p class="lead">
			<?php echo $data['description']; ?>
		</p>
		<p class="mb-0 mt-5">Version: <?php echo APP_VERSION ?></p>
		<p>Date create: <?php echo APP_DATE ?></p>
	</div>
</div>

<?php require APP_ROOT . '/views/inc/footer.php' ?>