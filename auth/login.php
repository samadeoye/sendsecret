<?php
require_once '../includes/utils.php';
require_once DEF_DOC_ROOT.'includes/head.php';
require_once DEF_DOC_ROOT.'includes/header.php';
?>

<div class="container">
    <div class="row">
        <div class="col-md-12 pt-5 pb-4 text-center">
            <h3>Login</h3>
            <p>Enter your credentials to continue</p>
        </div>
        <div class="col-md-6 mx-auto send-secret-form">
            <form id="loginForm" onsubmit="return false;">
                <input type="hidden" id="action" name="action" value="login">
                <div class="mb-3">
                    <label for="email" class="form-label"> Email </label>
                    <input type="email" class="form-control" id="email" name="email">
                </div>
                <div class="mb-3">
                    <label for="password" class="form-label"> Password </label>
                    <input type="password" class="form-control" id="password" name="password">
                </div>
                <button type="submit" class="btn btn-light" id="btnSubmit">LOGIN</button>
            </form>
            <a href="auth/register" class="text-white text-decoration-none">Don't have an account? <span class="btn btn-sm btn-light">Sign up</span></a>
        </div>
    </div>
</div>

<!-- Footer -->
<?php require_once DEF_DOC_ROOT.'includes/footer.php'; ?>
<!-- Footer -->

<!-- Additional JavaScript -->
<?php
$arAdditionalJsOnLoad[] = <<<EOQ
    $('loginForm #btnSubmit').click(function(){
        alert('working');
    });
EOQ;
?>
<!-- Additional JavaScript -->

<!-- JavaScript and page end -->
<?php require_once DEF_DOC_ROOT.'includes/foot.php'; ?>
<!-- JavaScript and page end -->