<?php
require_once '../includes/utils.php';

//redirect user to the dashboard if already logged in
if (isset($_SESSION['sendSecretUser']))
{
    header('location: '.DEF_ROOT_PATH.'/app');
}

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
                <button type="submit" class="btn btn-dark" id="btnSubmit">LOGIN</button>
            </form>
            <div><a href="auth/forgotpassword" class="text-white">Forgot password</a></div>
            <span class="text-white text-decoration-none">Don't have an account? <a href="auth/register" class="btn btn-sm btn-light">Sign up</a></span>
        </div>
    </div>
</div>

<!-- Footer -->
<?php require_once DEF_DOC_ROOT.'includes/footer.php'; ?>
<!-- Footer -->

<!-- Additional JavaScript -->
<?php
$arAdditionalJsOnLoad[] = <<<EOQ
$('#loginForm #btnSubmit').click(function(){
    var formId = '#loginForm';
    var email = $(formId+' #email').val();
    var password = $(formId+' #password').val();

    if (email.length < 13 || email.length > 100)
    {
        throwError('Please enter a valid email');
    }
    else if (password.length < 6)
    {
        throwError('Password must contain at least six characters');
    }
    else
    {
        var form = $('#loginForm');
        $.ajax({
            url: 'includes/actions',
            type: 'POST',
            dataType: 'json',
            data: form.serialize(),
            beforeSend: function() {
                enableDisableBtn(formId+' #btnSubmit', 0);
            },
            complete: function() {
                enableDisableBtn(formId+' #btnSubmit', 1);
            },
            success: function(data)
            {
                if(data.status)
                {
                    throwSuccess('Logging you in...');
                    form[0].reset();
                    //redirect to dashboard
                    window.location.href = "app/";
                }
                else
                {
                    throwError(data.msg);
                }
            }
        });
    }
});
EOQ;
?>
<!-- Additional JavaScript -->

<!-- JavaScript and page end -->
<?php require_once DEF_DOC_ROOT.'includes/foot.php'; ?>
<!-- JavaScript and page end -->