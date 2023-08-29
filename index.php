<?php
require_once 'includes/utils.php';
require_once 'includes/head.php';
require_once 'includes/header.php';
?>

<div class="text-center header-bg-image">
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

<div class="container-fluid login-cta">
    <div class="row">
        <div class="col-md-12 pt-5 pb-4 text-center">
            <p>Like to sign up? When you do, you can see your sent messages</p>
            <a href="auth/register" class="btn btn-dark mb-3">SIGN UP</a>
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
                    <form id="encodeForm" onsubmit="return false;">
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
                        <button type="submit" class="btn btn-light" id="btnSubmit">ENCODE</button>
                    </form>
                </div>
                <div class="tab-pane fade" id="decode-tab-pane" role="tabpanel" aria-labelledby="decode-tab" tabindex="0">
                    <h3>Decode Message</h3>
                    <form id="decodeForm" onsubmit="return false;">
                        <input type="hidden" id="action" name="action" value="decodeMessage">
                        <div class="mb-3">
                            <label for="msgReference" class="form-label">Message Reference</label>
                            <input type="text" class="form-control" id="msgReference" name="msgReference">
                        </div>
                        <div class="mb-3">
                            <label for="secretKey" class="form-label">Secret Key</label>
                            <input type="text" class="form-control" id="secretKey" name="secretKey">
                        </div>
                        <button type="submit" class="btn btn-light" id="btnSubmit">DECODE</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Footer -->
<?php require_once 'includes/footer.php'; ?>
<!-- Footer -->

<?php require_once 'includes/foot.php'; ?>