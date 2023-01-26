<div class="wrapper">
    <div class="iq-sidebar sidebar-bg-box">
        <div class="iq-fitness-info bg-primary mb-3">
            <div class="user-background text-left">
                <a href="/dashboard" class="collapsed" data-toggle="collapse" aria-expanded="false">
                    <div class="d-flex align-items-center justify-content-between">
                        <div class="user-text d-flex align-items-center">
                            <img src="<?= base_url() ?>/assets/images/layouts/layout-3/logo-umsu.jpg" class="img-fluid rounded avatar-40 mr-3" alt="user-2">
                            <div class="user-text-info line-height">
                                <span>UMSU Academy</span>
                            </div>
                        </div>
                        <div class="iq-menu-bt-sidebar">
                            <div class="iq-menu-bt align-self-center">
                                <div class="wrapper-menu">
                                    <div class="main-circle"><i class="las la-bars"></i></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </a>
            </div>
        </div>
        <div id="sidebar-scrollbar" class="data-scrollbar" data-scroll="1">
            <nav class="iq-sidebar-menu">
                <ul id="iq-sidebar-toggle" class="iq-menu">
                    <?= $menus; ?>
                </ul>
            </nav>
            <div id="sidebar-bottom" class="position-relative">
                <div class="card bg-primary rounded">
                    <div class="card-body">
                        <div class="sidebarbottom-content">
                            <div class="image"><img src="<?= base_url() ?>/assets/images/layouts/layout-3/side-bkg.png" alt="side-bkg"></div>
                            <h5 class="mb-3 text-white">Version Number</h5>
                            <p class="mb-0 text-white">1.0.0+1</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="iq-top-navbar">
        <div class="iq-navbar-custom">
            <nav class="navbar navbar-expand-lg navbar-light p-0">
                <div class="iq-navbar-logo d-flex align-items-center justify-content-between">
                    <i class="ri-menu-line wrapper-menu"></i>
                    <a href="/dashboard" class="header-logo">
                        <img src="<?= base_url() ?>/assets/images/logo.png" class="img-fluid rounded-normal" alt="logo">
                    </a>
                    <div class="navbar-breadcrumb">
                        <h4>Dashboard</h4>
                    </div>
                </div>
                <div class="iq-search-bar device-search">
                </div>
                <div class="d-flex align-items-center">
                    <div class="change-mode">
                        <div class="custom-control custom-switch custom-switch-icon custom-control-inline">
                            <div class="custom-switch-inner">
                                <p class="mb-0"> </p>
                                <input type="checkbox" class="custom-control-input" id="dark-mode" data-active="true">
                                <label class="custom-control-label" for="dark-mode" data-mode="toggle">
                                    <span class="switch-icon-left"><i class="a-left"></i></span>
                                    <span class="switch-icon-right"><i class="a-right"></i></span>
                                </label>
                            </div>
                        </div>
                    </div>
                    <h4 class="current-time text-primary mr-md-4 mr-3">14:34:16</h4>
                    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-label="Toggle navigation">
                        <i class="ri-menu-3-line"></i>
                    </button>
                    <div class="collapse navbar-collapse" id="navbarSupportedContent">
                        <ul class="navbar-nav ml-auto navbar-list align-items-center">
                            <li class="nav-item nav-icon dropdown iq-full-screen">
                                <a href="#" class="toggle-icon-effect bg-danger-light rounded" id="btnFullscreen"><i class="ri-fullscreen-line"></i></a>
                            </li>
                            <li class="caption-content">
                                <a href="#" class="iq-user-toggle">
                                    <img src="<?= base_url() ?>/assets/images/layouts/layout-3/avatar-3.png" class="img-fluid rounded" alt="user">
                                </a>
                                <div class="iq-user-dropdown">
                                    <div class="card">
                                        <div class="card-header d-flex justify-content-between align-items-center mb-0">
                                            <div class="header-title">
                                                <h4 class="card-title mb-0">Profile</h4>
                                            </div>
                                            <div class="close-data text-right badge badge-primary cursor-pointer"><i class="ri-close-fill"></i></div>
                                        </div>
                                        <div class="data-scrollbar" data-scroll="2">
                                            <div class="card-body">
                                                <div class="profile-header">
                                                    <div class="cover-container text-center">
                                                        <img src="<?= base_url() ?>/assets/images/layouts/layout-3/avatar-3.png" alt="profile-bg" class="rounded img-fluid avatar-80">
                                                        <div class="profile-detail mt-3">
                                                            <h3><?= user()->username; ?></h3>
                                                            <p class="mb-1"><?= user()->email; ?></p>
                                                        </div>
                                                        <br>
                                                        <form action="/logout" method="POST">
                                                            <button type="submit" class="btn btn-primary">Sign Out</button>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </li>
                        </ul>
                    </div>
                </div>
            </nav>
        </div>
    </div>
</div>