<?php require APP_ROOT . '/views/inc/header.php' ?>

<?php message('access_denied_message'); ?>

<div class="row">
<div class="col-md-6 mx-auto">
  <div class="card card-body bg-light mt-5">
	 <form class="form-signin" action="<?php echo URL_ROOT; ?>/users/login" method="post">
		<div class="text-center mt-3"><img class="mb-4" src="../image/logo.png" alt=""></div>
		<h3 class="text-center">Authorization</h3>
		<div class="form-group">
           <label for="login">Login: </label>
           <input id="login" type="login" name="login" class="form-control form-control <?php echo (!empty($data['login_error'])) ? 'is-invalid' : '';?>" value="<?php echo $data['login']; ?>">
           <span class="invalid-feedback"><?php echo $data['login_error']; ?></span>
        </div>
        <div class="form-group">
           <label for="password">Password:</label>
           <input id="password" type="password" name="password" class="form-control form-control <?php echo (!empty($data['password_error'])) ? 'is-invalid' : '';?>" value="<?php echo $data['password']; ?>">
           <span class="invalid-feedback"><?php echo $data['password_error']; ?></span>
        </div>
		<div class="row justify-content-md-center">
           <div class="col-6">
              <input type="submit" value="Login" class="btn btn-primary btn-block"/>
           </div>
        </div>
		<p class="mt-5 mb-3 text-muted text-center">© 2019</p>
	</form>
  </div>
</div>

<?php require APP_ROOT . '/views/inc/footer.php' ?>