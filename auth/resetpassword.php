<?php
require_once '../includes/utils.php';

/*
check that a valid token is passed to the url
redirect back to the reset password starting page if not valid
*/
if (isset($_GET['token']))
{
    $token = trim($_GET['token']);
    if (strlen($token) != 36)
    {
        header('location: '.DEF_ROOT_PATH.'/auth/forgotpassword');
    }
}
else
{
    header('location: '.DEF_ROOT_PATH.'/auth/forgotpassword');
}

require_once DEF_DOC_ROOT.'includes/head.php';
require_once DEF_DOC_ROOT.'includes/header.php';
?>

<div class="container">
    <div class="row">
        <div class="col-md-12 pt-5 pb-4 text-center">
            <h3>Password Reset</h3>
            <p>Enter your new password to continue</p>
        </div>
        <div class="col-md-6 mx-auto send-secret-form">
            <div id="resetPassMsgDiv"></div>
            <form id="resetPasswordForm" onsubmit="return false;">
                <input type="hidden" id="action" name="action" value="resetPassword">
                <input type="hidden" id="token" name="token" value="<?=$token;?>">
                <div class="mb-3">
                    <label for="newPassword" class="form-label"> New Password </label>
                    <input type="password" class="form-control" id="newPassword" name="newPassword">
                </div>
                <div class="mb-3">
                    <label for="passwordConfirm" class="form-label"> New Password </label>
                    <input type="password" class="form-control" id="passwordConfirm" name="passwordConfirm">
                </div>
                <button type="submit" class="btn btn-dark" id="btnSubmit">PROCEED</button>
            </form>
        </div>
    </div>
</div>

<!-- Footer -->
<?php require_once DEF_DOC_ROOT.'includes/footer.php'; ?>
<!-- Footer -->

<!-- Additional JavaScript -->
<?php
$arAdditionalJsOnLoad[] = <<<EOQ
$('#resetPasswordForm #btnSubmit').click(function(){
    var formId = '#resetPasswordForm';
    var newPassword = $(formId+' #newPassword').val();
    var passwordConfirm = $(formId+' #passwordConfirm').val();

    if (newPassword.length < 6)
    {
        throwError('Password must contain at least six characters.');
    }
    else if (newPassword != passwordConfirm)
    {
        throwError('Passwords do not match');
    }
    else
    {
        var form = $('#resetPasswordForm');
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
                    throwAlert('Password reset successfully! Proceed to login.', 'resetPassMsgDiv', 'successs');
                    form[0].reset();
                }
                else
                {
                    throwAlert(data.msg, 'resetPassMsgDiv');
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