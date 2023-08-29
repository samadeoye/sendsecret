<?php
require_once '../includes/utils.php';
require_once DEF_DOC_ROOT.'includes/head.php';
require_once DEF_DOC_ROOT.'includes/header.php';
?>


<div class="container">
    <div class="row">
        <div class="col-md-12 pt-5 pb-4 text-center">
            <h3>Register</h3>
            <p>Enter your credentials to sign up</p>
        </div>
        <div class="col-md-6 mx-auto send-secret-form">
            <form id="registerForm" onsubmit="return false;">
                <input type="hidden" id="action" name="action" value="register">
                <div class="mb-3">
                    <label for="fname" class="form-label"> First Name </label>
                    <input type="fname" class="form-control" id="fname" name="fname">
                </div>
                <div class="mb-3">
                    <label for="lname" class="form-label"> Last Name </label>
                    <input type="lname" class="form-control" id="lname" name="lname">
                </div>
                <div class="mb-3">
                    <label for="email" class="form-label"> Email </label>
                    <input type="email" class="form-control" id="email" name="email">
                </div>
                <div class="mb-3">
                    <label for="password" class="form-label"> Password </label>
                    <input type="password" class="form-control" id="password" name="password">
                </div>
                <div class="mb-3">
                    <label for="password" class="form-label"> Password </label>
                    <input type="password" class="form-control" id="passwordConfirm" name="passwordConfirm">
                </div>
                <button type="submit" class="btn btn-light" id="btnSubmit">REGISTER</button>
            </form>
            <a href="auth/login" class="text-white text-decoration-none">Already have an account? <span class="btn btn-sm btn-light">Sign in</span></a>
        </div>
    </div>
</div>

<!-- Footer -->
<?php require_once DEF_DOC_ROOT.'includes/footer.php'; ?>
<!-- Footer -->

<!-- Additional JavaScript -->
<?php
$arAdditionalJsOnLoad[] = <<<EOQ
    $('#registerForm #btnSubmit').click(function(){
        var formId = '#registerForm';
        var fname = $(formId+' #fname').val();
        var lname = $(formId+' #lname').val();
        var email = $(formId+' #email').val();
        var password = $(formId+' #password').val();
        var passwordConfirm = $(formId+' #passwordConfirm').val();

        if (fname.length < 3 || fname.length > 100)
        {
            throwError('Please enter a valid first name');
        }
        else if (lname.length < 3 || lname.length > 100)
        {
            throwError('Please enter a valid last name');
        }
        else if (email.length < 13 || email.length > 100)
        {
            throwError('Please enter a valid email');
        }
        else if (password.length < 6)
        {
            throwError('Password must contain at least six characters');
        }
        else if (password != passwordConfirm)
        {
            throwError('Passwords do not match');
        }
        else
        {
            var form = $('#registerForm');
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
                        throwSuccess('Registration successful. Logging you in...');
                        form[0].reset();
                        //redirect to dashboard
                        window.location.href = "/app/";
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