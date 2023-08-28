<?php
require_once 'includes/utils.php';
?>

<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title> <?=SITE_NAME;?> - Home </title>
    <meta name="author" content="Samuel Adeoye">
    <link href="assets/css/style.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/css/all.min.css" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Nunito:ital,wght@0,200;0,300;0,400;0,500;0,600;0,700;1,200;1,300;1,400;1,500;1,700&display=swap" rel="stylesheet">
</head>
<body>

<header>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg fixed-top">
        <div class="container-fluid">
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#sendSecretNavBar" aria-controls="sendSecretNavBar" aria-expanded="false" aria-label="Toggle navigation">
                <i class="fas fa-bars"></i>
            </button>
            <a class="text-white text-decoration-none fw-bold pe-4" href="<?=SITE_URL;?>">SendSecret</a>
            <div class="collapse navbar-collapse" id="sendSecretNavBar">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item active">
                        <a class="nav-link" aria-current="page" href="<?=SITE_URL;?>">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="login">Login</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="register">Register</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="messages">Messages</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
    <!-- Navbar -->

    <!-- Background image -->
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
    <!-- Background image -->
</header>

<div class="container-fluid login-cta">
    <div class="row mb-4">
        <div class="col-md-12 pt-5 pb-4 text-center">
            <p>Like to sign up? When you do, you can see your sent messages</p>
            <a href="register" class="btn btn-dark mb-3">SIGN UP</a>
        </div>
    </div>
</div>

<div class="container">
    <div class="row">
        <div class="col-md-6 mx-auto send-secret-form" id="encodeDecodeForm">
            <ul class="nav nav-tabs" id="sendSecretMessageTab" role="tablist">
                <li class="nav-item" role="presentation">
                    <button class="nav-link active" id="encode-tab" data-bs-toggle="tab" data-bs-target="#encode-tab-pane" type="button" role="tab" aria-controls="encode-tab-pane" aria-selected="true">Encode</button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="decode-tab" data-bs-toggle="tab" data-bs-target="#decode-tab-pane" type="button" role="tab" aria-controls="decode-tab-pane" aria-selected="false">Decode</button>
                </li>
            </ul>
            <div class="tab-content" id="sendSecretMessageForms">
                <div class="tab-pane fade show active" id="encode-tab-pane" role="tabpanel" aria-labelledby="encode-tab" tabindex="0">
                    <h3>Encode Message</h3>
                    <form id="teamForm" onsubmit="return false;">
                        <input type="hidden" id="action" name="action" value="encodeMessage">
                        <div class="mb-3">
                            <label for="name" class="form-label">Your Name</label>
                            <p><small>This will be shown to the receiver</small></p>
                            <input type="text" class="form-control" id="name" name="name">
                        </div>
                        <div class="mb-3">
                            <label for="encodeMsg" class="form-label">Your Message</label>
                            <textarea class="form-control" id="encodeMsg" name="encodeMsg" cols="30" rows="10"></textarea>
                        </div>
                        <div class="mb-3">
                            <label for="secretKey" class="form-label">Secret Key</label>
                            <p><small>You give this to the receiver</small></p>
                            <input type="text" class="form-control" id="secretKey" name="secretKey">
                        </div>
                        <button type="submit" class="btn btn-secondary" id="btnSubmit">Encode</button>
                    </form>
                </div>
                <div class="tab-pane fade" id="decode-tab-pane" role="tabpanel" aria-labelledby="decode-tab" tabindex="0">
                    <h3>Decode Message</h3>
                    <form id="teamForm" onsubmit="return false;">
                        <input type="hidden" id="action" name="action" value="decodeMessage">
                        <div class="mb-3">
                            <label for="msgReference" class="form-label">Message Reference</label>
                            <input type="text" class="form-control" id="msgReference" name="msgReference">
                        </div>
                        <div class="mb-3">
                            <label for="secretKey" class="form-label">Secret Key</label>
                            <input type="text" class="form-control" id="secretKey" name="secretKey">
                        </div>
                        <button type="submit" class="btn btn-secondary" id="btnSubmit">Decode</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Footer -->
<footer class="text-center text-lg-start text-white">
    <div class="container p-4 pb-0">
        <section>
            <div class="row">
                <div class="col-md-12">
                    <h5 class="text-uppercase text-center">Useful Links</h5>
                    <div class="d-flex justify-content-center align-items-center">
                        <ul class="list-inline list-unstyled">
                            <li class="list-inline-item">
                                <a href="<?=SITE_URL;?>" class="text-white text-decoration-none">Home</a> | 
                            </li>
                            <li class="list-inline-item">
                                <a href="login" class="text-white text-decoration-none">Login</a> | 
                            </li>
                            <li class="list-inline-item">
                                <a href="register" class="text-white text-decoration-none">Register</a> | 
                            </li>
                            <li class="list-inline-item">
                                <a href="messages" class="text-white text-decoration-none">Messages</a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </section>

        <hr class="mb-4" />

        <section class="mb-4 text-center">
            <a class="btn btn-outline-light btn-floating m-1" href="https://github.com/samadeoye/sendsecret" role="button"><i class="fab fa-github"></i></a>
        </section>
    </div>

    <div class="text-center p-3" style="background-color: rgba(0, 0, 0, 0.2)">
        © <?=date('Y');?> Copyright <a class="text-white" href="<?=SITE_URL;?>"> <?=SITE_NAME;?> </a>
    </div>
</footer>
<!-- Footer -->



<script src="https://code.jquery.com/jquery-3.7.0.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js"></script>
<script src="assets/js/functions.js"></script>
</body>
</html>