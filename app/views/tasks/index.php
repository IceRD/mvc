<?php require APP_ROOT . '/views/inc/header.php' ?>

<?php message('task_message'); ?>

<div class="row mb-3">
	<div class="col-md-6">
		<h1>Tasks</h1>
	</div>
	<div class="col-md-6">
		<a href="<?php echo URL_ROOT; ?>/tasks/add" class="btn btn-primary pull-right">
			<i class="fa fa-pencil"></i> Add Task
		</a>
	</div>
</div>

<div class="row">
	<div class="col-md-4">
		<?php require APP_ROOT . '/views/inc/sort.php' ?>
	</div>
</div>

<?php foreach ($data['tasks'] as $task) : ?>
	<div class="card card-body mb-3">
		<div class="card-block">
			<div class="row">
				<div class="col">
					<h4 class="card-title mb-0">
						<?php echo htmlspecialchars($task->name); ?>
						<?php if (!empty($task->email)) : ?> <small>(<a href="mailto:info@lds.ua"><?php echo htmlspecialchars($task->email); ?></a>)</small><?php endif; ?>
					</h4>
					<div class="mb-4">Create: <?php echo $task->role; ?></div>
				</div>
				<div class="col-md-auto text-right">
					<div class="card-subtitle mb-2 text-muted"> <?php echo helper_format_date($task->created_at); ?></div>
					<span class="badge <?php echo (['1' => 'badge-warning', '2' => 'badge-danger', '3' => 'badge-success'])[$task->state]; ?>"><?php echo $task->state_name; ?></span>
				</div>
			</div>

			<p class="card-text breakline"><?php echo htmlspecialchars($task->body); ?></p>

			<?php if ($data['allow_edit']) : ?>
				<a href="<?php echo URL_ROOT; ?>/tasks/show/<?php echo $task->task_id; ?>" class="btn btn-outline-dark">More</a>
			<?php endif; ?>
		</div>
	</div>
<?php endforeach; ?>

<div class="text-right  text-muted">Total task: <?php echo $data['pagination']['total']; ?></div>

<?php require APP_ROOT . '/views/inc/pagination.php' ?>


<?php require APP_ROOT . '/views/inc/footer.php' ?>