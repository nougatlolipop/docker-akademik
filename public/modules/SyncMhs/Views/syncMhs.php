<?= $this->extend('layout/templateHome'); ?>

<?= $this->section('content'); ?>
<!-- Wrapper Start -->
<?= view('layout/templateSidebar', ['menus' => $menu]); ?>

<div class="content-page">
    <div class="container-fluid">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb bg-primary">
                <li class="breadcrumb-item"><a href="/syncMhs" class="text-white"><?= $breadcrumb[0]; ?></a></li>
                <li class="breadcrumb-item active text-white" aria-current="page"><?= $breadcrumb[1]; ?></li>
            </ol>
        </nav>
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between">
                        <div class="header-title">
                            <h4 class="card-title"><?= $title; ?></h4>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="progress mb-3">
                            <div id="progress-bar" class=" progress-bar progress-bar-striped bg-primary progress-bar-animated" role="progressbar" style="width: 0%" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                        </div>
                        <button class="btn btn-sm bg-primary float-right" onclick="sync()"><i class="las la-sync"><span class="pl-1"></span></i>Sync</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</div>
<!-- Wrapper End-->

<?= view('layout/templateFooter'); ?>

<?= $this->endSection(); ?>