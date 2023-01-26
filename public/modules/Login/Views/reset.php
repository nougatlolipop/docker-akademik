<?= $this->extend($config->viewLayout) ?>
<?= $this->section('main') ?>

<div class="col-lg-6">
    <h2 class="mb-2"><?= lang('Auth.resetYourPassword') ?></h2>
    <?= view('Myth\Auth\Views\_message_block') ?>
    <p><?= lang('Auth.enterCodeEmailPassword') ?></p>
    <form action="<?= route_to('reset-password') ?>" method="post">
        <?= csrf_field() ?>
        <div class="row">
            <div class="col-lg-6">
                <div class="floating-label form-group">
                    <input name="token" class="floating-input form-control <?php if (session('errors.token')) : ?>is-invalid<?php endif ?>" type="text" placeholder="<?= lang('Auth.token') ?>" value="<?= old('token', $token ?? '') ?>">
                    <div class="invalid-feedback">
                        <?= session('errors.token') ?>
                    </div>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="floating-label form-group">
                    <input name="email" aria-describedby="emailHelp" class="floating-input form-control <?php if (session('errors.email')) : ?>is-invalid<?php endif ?>" type="email" placeholder="<?= lang('Auth.email') ?>" value="<?= old('email') ?>">
                    <div class="invalid-feedback">
                        <?= session('errors.email') ?>
                    </div>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="floating-label form-group">
                    <input name="password" class="floating-input form-control <?php if (session('errors.password')) : ?>is-invalid<?php endif ?>" type="password" placeholder="<?= lang('Auth.password') ?>">
                    <div class="invalid-feedback">
                        <?= session('errors.password') ?>
                    </div>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="floating-label form-group">
                    <input name="pass_confirm" class="floating-input form-control <?php if (session('errors.pass_confirm')) : ?>is-invalid<?php endif ?>" type="password" placeholder="<?= lang('Auth.repeatPassword') ?>">
                    <div class="invalid-feedback">
                        <?= session('errors.pass_confirm') ?>
                    </div>
                </div>
            </div>
            <div class="col-lg-6">
                <button type="submit" class="btn btn-primary"><?= lang('Auth.resetPassword') ?></button>
            </div>
        </div>
    </form>
</div>

<?= $this->endSection() ?>