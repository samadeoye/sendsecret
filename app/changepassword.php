<?php
require_once '../includes/utils.php';
checkIfUserSessionIsActive();

require_once DEF_DOC_ROOT.'includes/head.php';
require_once DEF_DOC_ROOT.'includes/header.php';
?>

<div class="container-fluid login-cta">
    <div class="row">
        <div class="col-md-12 pt-5 pb-4 text-center">
            <h4>Change Password</h4>
            <span><a href="" class="text-dark">Home</a> - Change Password</span>
        </div>
    </div>
</div>

<div class="container mt-4">
    <div class="row">
        <div class="col-md-6 mx-auto send-secret-form">
            <form id="changePasswordForm" onsubmit="return false;">
                <input type="hidden" id="action" name="action" value="changePassword">
                <div class="mb-3">
                    <label for="oldPassword" class="form-label"> Old Password </label>
                    <input type="password" class="form-control" id="oldPassword" name="oldPassword">
                </div>
                <div class="mb-3">
                    <label for="newPassword" class="form-label"> New Password </label>
                    <input type="password" class="form-control" id="newPassword" name="newPassword">
                </div>
                <div class="mb-3">
                    <label for="passwordConfirm" class="form-label"> Confirm New Password </label>
                    <input type="password" class="form-control" id="passwordConfirm" name="passwordConfirm">
                </div>
                <button type="submit" class="btn btn-dark" id="btnSubmit">SAVE CHANGES</button>
            </form>
        </div>

    </div>

</div>

<!-- Footer -->
<?php require_once DEF_DOC_ROOT.'includes/footer.php'; ?>
<!-- Footer -->

<?php
$arAdditionalJsOnLoad[] = <<<EOQ
    $('#changePasswordForm #btnSubmit').click(function(){
        var formId = '#changePasswordForm';
        var oldPassword = $(formId+' #oldPassword').val();
        var newPassword = $(formId+' #newPassword').val();
        var passwordConfirm = $(formId+' #passwordConfirm').val();

        if (oldPassword.length < 6 || newPassword.length < 6)
        {
            throwError('Password must contain at least six characters');
        }
        else if (newPassword != passwordConfirm)
        {
            throwError('Passwords do not match');
        }
        else
        {
            var form = $('#changePasswordForm');
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
                        throwSuccess('Password updated successfully.');
                        form[0].reset();
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

<?php require_once DEF_DOC_ROOT.'includes/foot.php'; ?>