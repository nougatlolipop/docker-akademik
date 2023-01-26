<?= $this->extend($config->viewLayout) ?>
<?= $this->section('main') ?>

<div class="col-lg-6">
    <h2 class="mb-2"><?= lang('Auth.forgotPassword') ?></h2>
    <?= view('Myth\Auth\Views\_message_block'); ?>
    <p><?= lang('Auth.enterEmailForInstructions'); ?></p>
    <form action="<?= route_to('forgot') ?>" method="post">
        <div class="row">
            <div class="col-lg-12">
                <div class="floating-label form-group">
                    <input name="email" class="floating-input form-control <?php if (session('errors.email')) : ?>is-invalid<?php endif ?>" type="email" aria-describedby="emailHelp" placeholder="<?= lang('Auth.emailAddress') ?>">
                    <div class="invalid-feedback">
                        <?= session('errors.email') ?>
                    </div>
                </div>
            </div>
            <div class="col-lg-6">
                <button type="submit" class="btn btn-primary"><?= lang('Auth.sendInstructions') ?></button>
            </div>
            <div class="col-lg-6 mt-2">
                <a href="<?= route_to('login') ?>" class="text-primary float-right"><?= lang('Auth.changeMind') ?></a>
            </div>
        </div>
    </form>
</div>

<?= $this->endSection() ?>