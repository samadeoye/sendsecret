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
                            <label for="senderName" class="form-label">Your Name</label>
                            <p><small>This will be shown to the receiver</small></p>
                            <input type="text" class="form-control" id="senderName" name="senderName">
                        </div>
                        <div class="mb-3">
                            <label for="plainMsg" class="form-label">Your Message</label>
                            <textarea class="form-control" id="plainMsg" name="plainMsg" cols="30" rows="10"></textarea>
                        </div>
                        <div class="mb-3">
                            <label for="secretKey" class="form-label">Secret Key</label>
                            <p><small>You give this to the receiver</small></p>
                            <input type="text" class="form-control" id="secretKey" name="secretKey">
                        </div>
                        <button type="submit" class="btn btn-light" id="btnSubmit">ENCODE</button>
                        <div id="messageRef" class="mt-3"></div>
                    </form>
                </div>
                <div class="tab-pane fade" id="decode-tab-pane" role="tabpanel" aria-labelledby="decode-tab" tabindex="0">
                    <h3>Decode Message</h3>
                    <form id="decodeForm" onsubmit="return false;">
                        <input type="hidden" id="action" name="action" value="decodeMessage">
                        <div class="mb-3">
                            <label for="messageRef" class="form-label">Message Reference</label>
                            <input type="text" class="form-control" id="messageRef" name="messageRef">
                        </div>
                        <div class="mb-3">
                            <label for="secretKey" class="form-label">Secret Key</label>
                            <input type="text" class="form-control" id="secretKey" name="secretKey">
                        </div>
                        <button type="submit" class="btn btn-light" id="btnSubmit">DECODE</button>
                        <div id="message" class="mt-3"></div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Footer -->
<?php require_once 'includes/footer.php'; ?>
<!-- Footer -->

<!-- Additional JavaScript -->
<?php
$arAdditionalJsOnLoad[] = <<<EOQ
$('#encodeForm #btnSubmit').click(function(){
    var formId = '#encodeForm';
    var senderName = $(formId+' #senderName').val();
    var plainMsg = $(formId+' #plainMsg').val();
    var secretKey = $(formId+' #secretKey').val();

    if (senderName.length < 3 || senderName.length > 150)
    {
        throwError('Please enter a valid name');
    }
    else if (plainMsg.length < 5)
    {
        throwError('Please enter a valid message');
    }
    else if (plainMsg.length > 500)
    {
        throwError('Your message cannot comtain more than 500 characters.');
    }
    else if (secretKey.length < 4 || secretKey.length > 4)
    {
        throwError('Secret key must contain exactly four characters.');
    }
    else
    {
        var form = $('#encodeForm');
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
                    throwSuccess('Message successfully encoded. Please copy your reference and keep it safe.');
                    form[0].reset();
                    throwAlert('Message Reference: <b>'+data.data.reference+'</b>', 'messageRef', 'warning');
                }
                else
                {
                    throwError(data.msg);
                }
            }
        });
    }
});

$('#decodeForm #btnSubmit').click(function(){
    var formId = '#decodeForm';
    var messageRef = $(formId+' #messageRef').val();
    var secretKey = $(formId+' #secretKey').val();

    if (messageRef.length < 13 || messageRef.length > 13)
    {
        throwError('Please enter a valid reference');
    }
    else if (secretKey.length < 4 || secretKey.length > 4)
    {
        throwError('Please enter a valid secret key');
    }
    else
    {
        var form = $('#decodeForm');
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
                    throwSuccess('Message successfully decoded. See your message below.');
                    form[0].reset();
                    throwAlert('Plain Message:<br>'+data.data.message, 'message', 'success');
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

<?php require_once 'includes/foot.php'; ?>