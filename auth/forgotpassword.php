<?php
require_once '../includes/utils.php';
require_once DEF_DOC_ROOT.'includes/head.php';
require_once DEF_DOC_ROOT.'includes/header.php';
?>

<div class="container">
    <div class="row">
        <div class="col-md-12 pt-5 pb-4 text-center">
            <h3>Password Reset</h3>
            <p>Enter your email to continue</p>
        </div>
        <div class="col-md-6 mx-auto send-secret-form">
            <div id="forgotPassMsgDiv"></div>
            <form id="forgotPasswordForm" onsubmit="return false;">
                <input type="hidden" id="action" name="action" value="forgotPassword">
                <div class="mb-3">
                    <label for="email" class="form-label"> Email </label>
                    <input type="email" class="form-control" id="email" name="email">
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
$('#forgotPasswordForm #btnSubmit').click(function(){
    var formId = '#forgotPasswordForm';
    var email = $(formId+' #email').val();

    if (email.length < 13 || email.length > 100)
    {
        throwError('Please enter a valid email');
    }
    else
    {
        var form = $('#forgotPasswordForm');
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
                    throwAlert('A password reset email has been sent to you. Please proceed from there.', 'forgotPassMsgDiv', 'success');
                    form[0].reset();
                }
                else
                {
                    throwAlert(data.msg, 'forgotPassMsgDiv');
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