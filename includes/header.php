<header>
    <nav class="navbar fixed-top">
        <div class="container-fluid">
            <a class="navbar-brand text-white text-decoration-none fw-bold pe-4" href="<?=SITE_URL;?>"><?=SITE_NAME;?></a>
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
                            <a class="nav-link active" aria-current="page" href="<?=SITE_URL;?>">Home</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="login">Login</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="register">Register</a>
                        </li>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                Account
                            </a>
                            <ul class="dropdown-menu">
                                <li><a class="dropdown-item" href="messages">Messages</a></li>
                                <li><a class="dropdown-item" href="profile">Profile</a></li>
                                <li>
                                    <hr class="dropdown-divider">
                                </li>
                                <li><a class="dropdown-item" href="logout">Logout</a></li>
                            </ul>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </nav>

    <div class="text-center bg-image">
        <div class="mask">
            <div class="d-flex justify-content-center align-items-center h-100">
                <div class="text-white">
                    <h1 class="mb-3"><?=SITE_NAME;?></h1>
                    <h5 class="mb-3 px-2">Encode and decode short messages in few clicks</h5>
                    <a class="btn btn-outline-light btn-lg" href="#encodeDecodeForm" role="button">Get Started</a>
                </div>
            </div>
        </div>
    </div>
</header>