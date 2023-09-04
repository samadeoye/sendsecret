<header>
    <nav class="navbar fixed-top">
        <div class="container-fluid">
            <a class="navbar-brand text-white text-decoration-none fw-bold pe-4" href="<?=DEF_FULL_BASE_PATH_URL;?>"><?=SITE_NAME;?></a>
            <button class="navbar-toggler" type="button" data-bs-toggle="offcanvas" data-bs-target="#sendSecretNavBar" aria-controls="sendSecretNavBar" aria-label="Toggle navigation">
                <i class="fas fa-bars"></i>
            </button>
            <div class="offcanvas offcanvas-end" tabindex="-1" id="sendSecretNavBar" aria-labelledby="sendSecretNavBarLabel">
                <div class="offcanvas-header">
                    <h5 class="offcanvas-title fw-bold" id="sendSecretNavBarLabel"><?=SITE_NAME;?></h5>
                    <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
                </div>
                <div class="offcanvas-body">
                    <ul class="navbar-nav justify-content-end flex-grow-1 pe-3">
                        <li class="nav-item">
                            <a class="nav-link <?=markAsActivePage('index.php');?>" aria-current="page" href="<?=DEF_ROOT_PATH;?>">Home</a>
                        </li>
                        <?php
                        if (!isset($_SESSION['sendSecretUser']))
                        { ?>
                            <li class="nav-item">
                                <a class="nav-link <?=markAsActivePage('login.php');?>" href="auth/login">Login</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link <?=markAsActivePage('register.php');?>" href="auth/register">Register</a>
                            </li>
                        <?php
                        }
                        else
                        { ?>
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle <?=markAsActivePage('account');?>" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                    Account
                                </a>
                                <ul class="dropdown-menu">
                                    <li><a class="dropdown-item" href="app/">Dashboard</a></li>
                                    <li><a class="dropdown-item" href="app/profile">Profile</a></li>
                                    <li><a class="dropdown-item" href="app/changepassword">Change Password</a></li>
                                    <li>
                                        <hr class="dropdown-divider">
                                    </li>
                                    <li><a class="dropdown-item cursor-pointer" onclick="doOpenLogoutModal()">Logout</a></li>
                                </ul>
                            </li>
                        <?php
                        }
                        ?>
                    </ul>
                </div>
            </div>
        </div>
    </nav>
</header>