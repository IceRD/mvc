<?php require APP_ROOT . '/views/inc/header.php' ?>

<a href="<?php echo URL_ROOT; ?>/tasks" class="btn btn-light"><i class="fa fa-backward"></i> Back</a>
<div class="card card-body bg-light mt-5">
	<h3>Add Post</h3>
	<p>Create a new task</p>
	<form action="<?php echo URL_ROOT; ?>/tasks/edit/<?php echo $data['id']; ?>" method="post">
		<div class="form-group">
			<label for="title">Name: <sup>*</sup></label>
			<input type="text" name="name" class="form-control form-control <?php echo (!empty($data['name_error'])) ? 'is-invalid' : ''; ?>" value="<?php echo $data['name']; ?>">
			<span class="invalid-feedback"><?php echo $data['name_error']; ?></span>
		</div>
		<div class="form-group">
			<label for="email">Email: <sup>*</sup></label>
			<input type="text" name="email" class="form-control form-control <?php echo (!empty($data['email_error'])) ? 'is-invalid' : ''; ?>" value="<?php echo $data['email']; ?>">
			<span class="invalid-feedback"><?php echo $data['email_error']; ?></span>
		</div>
		<div class="form-group">
			<label for="name">Body: <sup>*</sup></label>
			<textarea name="body" rows="<?php substr_count($data['body'], "\r\n"); ?>" class="form-control form-control <?php echo (!empty($data['body_error'])) ? 'is-invalid' : ''; ?>"><?php echo $data['body']; ?></textarea>
			<span class="invalid-feedback"><?php echo $data['body_error']; ?></span>
		</div>
		<div class="form-group">
			<label for="state">State: <sup>*</sup></label>
			<select name="state" class="custom-select <?php echo (!empty($data['state_error'])) ? 'is-invalid' : ''; ?>" id="state">
				<option>Choose...</option>
				<?php foreach ($data['state_map'] as $select) : ?>
					<option value="<?php echo $select->id ?> " <?php if ($select->id == $data['state']) {
																		echo 'selected';
																	} ?>>
						<?php echo $select->name; ?>
					</option>
				<?php endforeach; ?>
			</select>
			<span class="invalid-feedback"><?php echo $data['state_error']; ?></span>
		</div>
		<input type="submit" class="btn btn-success" value="Submit" />
	</form>
</div>

<?php require APP_ROOT . '/views/inc/footer.php' ?>