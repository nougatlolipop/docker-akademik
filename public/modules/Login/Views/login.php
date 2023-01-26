<?= $this->extend($config->viewLayout) ?>
<?= $this->section('main') ?>

<div class="col-lg-6">
	<h2 class="mb-2"><?= lang('Auth.loginTitle') ?></h2>
	<p>Before you get started, you must login or register if you don't already have an account.</p>
	<?= view('Myth\Auth\Views\_message_block') ?>

	<form action="<?= route_to('login') ?>" method="post">
		<?= csrf_field() ?>

		<div class="row">
			<?php if ($config->validFields === ['email']) : ?>
				<div class="col-lg-12">
					<div class="floating-label form-group">
						<input name="login" class="floating-input form-control <?php if (session('errors.login')) : ?>is-invalid<?php endif ?>" type=" email" placeholder="<?= lang('Auth.email') ?>">
						<div class="invalid-feedback">
							<?= session('errors.login') ?>
						</div>
					</div>
				</div>
			<?php else : ?>
				<div class="col-lg-12">
					<div class="floating-label form-group">
						<input name="login" class="floating-input form-control <?php if (session('errors.login')) : ?>is-invalid<?php endif ?>" type=" email" placeholder="<?= lang('Auth.emailOrUsername') ?>">
						<div class="invalid-feedback">
							<?= session('errors.login') ?>
						</div>
					</div>
				</div>
			<?php endif; ?>
			<div class="col-lg-12">
				<div class="floating-label form-group">
					<input name="password" class="floating-input form-control <?php if (session('errors.password')) : ?>is-invalid<?php endif ?>" type="password" placeholder="<?= lang('Auth.password') ?>">
					<div class="invalid-feedback">
						<?= session('errors.password') ?>
					</div>
				</div>
			</div>
			<?php if ($config->allowRemembering) : ?>
				<div class="col-lg-6">
					<div class="custom-control custom-checkbox mb-3">
						<input name="remember" type="checkbox" class="custom-control-input" id="customCheck1">
						<label class="custom-control-label" for="customCheck1">Remember Me</label>
					</div>
				</div>
			<?php endif; ?>
			<?php if ($config->activeResetter) : ?>
				<div class="col-lg-6">
					<a href="<?= route_to('forgot') ?>" class="text-primary float-right">Forgot Password?</a>
				</div>
			<?php endif; ?>
		</div>
		<button type="submit" class="btn btn-primary"><?= lang('Auth.loginAction') ?></button>
		<?php if ($config->allowRegistration) : ?>
			<p class="mt-3">
				Create an Account <a href="<?= route_to('register') ?>" class="text-primary">Sign Up</a>
			</p>
		<?php endif; ?>
	</form>
</div>
<?= $this->endSection() ?>