<?php
require_once '../includes/utils.php';
require_once DEF_DOC_ROOT.'includes/head.php';
require_once DEF_DOC_ROOT.'includes/header.php';
?>

<div class="container-fluid login-cta">
    <div class="row">
        <div class="col-md-12 pt-5 pb-4 text-center">
            <h4>Profile</h4>
            <span><a href="" class="text-dark">Home</a> - Profile</span>
        </div>
    </div>
</div>

<div class="container mt-4">
    <div class="row">
        <div class="col-md-6 mx-auto send-secret-form">
            <form id="profileForm" onsubmit="return false;">
                <input type="hidden" id="action" name="action" value="updateProfile">
                <div class="mb-3">
                    <label for="fname" class="form-label"> First Name </label>
                    <input type="text" class="form-control" id="fname" name="fname" value="<?=$arUser['first_name'];?>">
                </div>
                <div class="mb-3">
                    <label for="lname" class="form-label"> Last Name </label>
                    <input type="text" class="form-control" id="lname" name="lname" value="<?=$arUser['last_name'];?>">
                </div>
                <div class="mb-3">
                    <label for="email" class="form-label"> Email </label>
                    <input type="email" class="form-control" id="email" name="email" value="<?=$arUser['email'];?>" readonly>
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
    $('#profileForm #btnSubmit').click(function(){
        var formId = '#profileForm';
        var fname = $(formId+' #fname').val();
        var lname = $(formId+' #lname').val();
        var email = $(formId+' #email').val();

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
        else
        {
            var form = $('#profileForm');
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
                        throwSuccess('Profile updated successfully.');
                        $(formId+' #fname').val(data.data.first_name);
                        $(formId+' #lname').val(data.data.last_name);
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