<?php require APP_ROOT . '/views/inc/header.php' ?>

<a href="<?php echo URL_ROOT; ?>/tasks" class="btn btn-light"><i class="fa fa-backward"></i> Back</a>
<br/>

<h1><?php echo $data['task']->name; ?></h1>

<div class="bg-secondary text-white p-2 mb-3">
Written by <?php echo $data['user']->name; ?> on <?php echo helper_format_date($data['task']->created_at); ?>
</div>

<p class="breakline"><?php echo htmlspecialchars($data['task']->body); ?></p>
	
<?php if( $data['allow_edit'] ): ?>
	<hr>

	<a href="<?php echo URL_ROOT; ?>/tasks/edit/<?php echo $data['task']->id; ?>" class="btn btn-dark">Edit</a>

	<form class="pull-right" action="<?php echo URL_ROOT; ?>/tasks/delete/<?php echo $data['task']->id; ?>" method="post">
		<input type="submit" value="Delete" class="btn btn-danger">
	</form>
<?php endif; ?>

<?php require APP_ROOT . '/views/inc/footer.php' ?>

