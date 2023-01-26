<?= $this->extend($config->viewLayout) ?>
<?= $this->section('main') ?>

<div class="col-lg-6">
    <h2 class="mb-2"><?= lang('Auth.register') ?></h2>
    <?= view('Myth\Auth\Views\_message_block') ?>
    <form action="<?= route_to('register') ?>" method="post">
        <?= csrf_field() ?>
        <div class="row">
            <div class="col-lg-6">
                <div class="floating-label form-group">
                    <input name="email" class="floating-input form-control <?php if (session('errors.email')) : ?>is-invalid<?php endif ?>" type="email" placeholder="<?= lang('Auth.email') ?>" value="<?= old('email') ?>">
                    <small id="emailHelp" class="form-text text-muted"><?= lang('Auth.weNeverShare') ?></small>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="floating-label form-group">
                    <input name="username" class="floating-input form-control <?php if (session('errors.username')) : ?>is-invalid<?php endif ?>" type="text" placeholder="<?= lang('Auth.username') ?>" value="<?= old('username') ?>">
                </div>
            </div>
            <div class="col-lg-6">
                <div class="floating-label form-group">
                    <input name="password" class="floating-input form-control <?php if (session('errors.password')) : ?>is-invalid<?php endif ?>" type="password" placeholder="<?= lang('Auth.password') ?>" autocomplete="off">
                </div>
            </div>
            <div class="col-lg-6">
                <div class="floating-label form-group">
                    <input name="pass_confirm" class="floating-input form-control <?php if (session('errors.pass_confirm')) : ?>is-invalid<?php endif ?>" type="password" placeholder="<?= lang('Auth.repeatPassword') ?>" autocomplete="off">
                </div>
            </div>
            <div class="col-lg-6">
                <button type="submit" class="btn btn-primary"><?= lang('Auth.register') ?></button>
            </div>
            <div class="col-lg-6 mt-2">
                <p><?= lang('Auth.alreadyRegistered') ?> <a href="<?= route_to('login') ?>"><?= lang('Auth.signIn') ?></a></p>
            </div>
        </div>
    </form>
</div>

<?= $this->endSection() ?>