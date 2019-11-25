<?php require APP_ROOT . '/views/inc/header.php' ?>
<a href="<?php echo URL_ROOT; ?>/tasks" class="btn btn-light"><i class="fa fa-backward"></i> Back</a>
<div class="card card-body bg-light mt-5">
   <h3>Add Post</h3>
   <p>Create a new task</p>
   <form action="<?php echo URL_ROOT; ?>/tasks/add" method="post">
		<div class="form-group">
			<label for="name">Name: <sup>*</sup></label>
			<input type="text" name="name" class="form-control form-control <?php echo (!empty($data['name_error'])) ? 'is-invalid' : '';?>" value="<?php echo $data['name']; ?>">
			<span class="invalid-feedback"><?php echo $data['name_error']; ?></span>
		</div>

		<div class="form-group">
			<label for="email">E-mail: <sup>*</sup></label>
			<input type="text" name="email" class="form-control form-control <?php echo (!empty($data['email_error'])) ? 'is-invalid' : '';?>" value="<?php echo $data['email']; ?>">
			<span class="invalid-feedback"><?php echo $data['email_error']; ?></span>
		</div>

		<div class="form-group">
			<label for="name">Body: <sup>*</sup></label>
			<textarea name="body"  class="form-control form-control <?php echo (!empty($data['body_error'])) ? 'is-invalid' : ''; ?>"><?php echo $data['body']; ?></textarea>
			<span class="invalid-feedback"><?php echo $data['body_error']; ?></span>
		</div>

		<div class="text-center"><input type="submit" class="btn btn-success" value="Submit"/></div>
   </form>
</div>
<?php require APP_ROOT . '/views/inc/footer.php' ?>
