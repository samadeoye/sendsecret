<?php
require_once '../includes/utils.php';
checkIfUserSessionIsActive();

$arAdditionalCSS[] = <<<EOQ
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css">
EOQ;
require_once DEF_DOC_ROOT.'includes/head.php';
require_once DEF_DOC_ROOT.'includes/header.php';
$acceptSenderName = false;
?>

<div class="container-fluid login-cta">
    <div class="row">
        <div class="col-md-12 pt-5 pb-4 text-center">
            <h4>Dashboard</h4>
            <span><a href="" class="text-dark">Home</a> - Dashboard </span>
        </div>
    </div>
</div>

<div class="container mt-4">
    <div class="row">
        <div class="col-md-8 mx-auto send-secret-form-light" id="encodeDecodeForm">
            <ul class="nav nav-tabs" id="sendSecretMessageTab" role="tablist">
                <li class="nav-item" role="presentation">
                    <button class="nav-link active text-dark" id="encode-tab" data-bs-toggle="tab" data-bs-target="#encode-tab-pane" type="button" role="tab" aria-controls="encode-tab-pane" aria-selected="true">Encode</button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link text-dark" id="decode-tab" data-bs-toggle="tab" data-bs-target="#decode-tab-pane" type="button" role="tab" aria-controls="decode-tab-pane" aria-selected="false">Decode</button>
                </li>
            </ul>
            <div class="tab-content">
                <div class="tab-pane fade show active" id="encode-tab-pane" role="tabpanel" aria-labelledby="encode-tab" tabindex="0">
                    <h3>Encode Message</h3>
                    <form id="encodeForm" onsubmit="return false;">
                        <input type="hidden" id="action" name="action" value="encodeMessage">
                        <?php
                            if (!isset($_SESSION['sendSecretUser']))
                            {
                                $acceptSenderName = true; ?>
                                <div class="mb-3">
                                    <label for="senderName" class="form-label">Your Name</label>
                                    <p><small>This will be shown to the receiver</small></p>
                                    <input type="text" class="form-control" id="senderName" name="senderName">
                                </div>
                            <?php
                            }
                        ?>
                        <div class="mb-3">
                            <label for="plainMsg" class="form-label">Your Message</label>
                            <textarea class="form-control" id="plainMsg" name="plainMsg" cols="30" rows="10"></textarea>
                        </div>
                        <div class="mb-3">
                            <label for="secretKey" class="form-label">Secret Key <small>(Only 4 characters)</small></label>
                            <p><small>You give this to the receiver</small></p>
                            <input type="text" class="form-control" id="secretKey" name="secretKey">
                        </div>
                        <button type="submit" class="btn btn-dark" id="btnSubmit">ENCODE</button>
                        <input type="hidden" id="encodedMessageReference">
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
                        <button type="submit" class="btn btn-dark" id="btnSubmit">DECODE</button>
                        <div id="message" class="mt-3"></div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="row mt-4">
        <div class="col-md-8 mx-auto send-secret-table">
            <h4>Your Sent Messages</h4>
            <table id="messagesTable" class="table table-striped" style="width:100%">
                <thead>
                    <tr>
                        <th>S.N</th>
                        <th>Message Reference</th>
                        <th>Date Created</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                        $arSentMessages = SendSecret\Message\Message::getSentMessages();
                        $count = 1;
                        foreach($arSentMessages as $r)
                        {
                            $messageRefWrapperId = 'messageRef'.$r['id'];
                            $reference = $r['reference']; ?>
                            <tr>
                                <td><?=$count;?></td>
                                <td>
                                    <?=$reference;?>
                                    <div class="sendSecretTooltip" onclick="copyMessageRef('<?=$messageRefWrapperId;?>')">
                                        <i class="fas fa-copy text-primary cursor-pointer"></i>
                                        <span class="tooltiptext">Copy Reference</span>
                                    </div>
                                    <input type="hidden" id="<?=$messageRefWrapperId;?>" value="<?=$reference;?>">
                                </td>
                                <td><?=getFormattedDate($r['cdate']);?></td>
                            </tr>
                            <?php $count++;
                        }
                    ?>
                </tbody>
                <tfoot>
                    <tr>
                        <th>S.N</th>
                        <th>Message Reference</th>
                        <th>Date Created</th>
                    </tr>
                </tfoot>
            </table>
        </div>

    </div>

</div>

<!-- Footer -->
<?php require_once DEF_DOC_ROOT.'includes/footer.php'; ?>
<!-- Footer -->

<?php
$arAdditionalJsScript[] = <<<EOQ
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>
EOQ;

$arAdditionalJsFunctions[] = <<<EOQ
    function invokeMessageEncoding(formId)
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
                    $(formId+' #encodedMessageReference').val(data.data.reference);
                    throwAlert(
                        'Message Reference:<br><b>'+data.data.reference+'</b> '+
                        '<div class="sendSecretTooltip" onclick="copyMessageRef()"> '+
                            '<i class="fas fa-copy text-primary cursor-pointer"></i> '+
                            '<span class="tooltiptext">Copy Reference</span> '+
                        '</div>'
                        , 'messageRef', 'warning'
                    );
                }
                else
                {
                    throwError(data.msg);
                }
            }
        });
    }

    function copyMessageRef(messageRefWrapperId)
    {
        if (messageRefWrapperId == undefined || messageRefWrapperId == '')
        {
            messageRefWrapperId = 'encodedMessageReference';
        }
        var messageRefWrapper = $('#'+messageRefWrapperId);
        messageRefWrapper.attr('type', 'text');
        messageRefWrapper.select();
        document.execCommand('copy');
        throwSuccess('Copied to clipboard');
        messageRefWrapper.attr('type', 'hidden');
    }
EOQ;

$arAdditionalJsOnLoad[] = <<<EOQ
    new DataTable('#messagesTable');

    $('#encodeForm #btnSubmit').click(function(){
        var formId = '#encodeForm';
        var plainMsg = $(formId+' #plainMsg').val();
        var secretKey = $(formId+' #secretKey').val();

        if ('{$acceptSenderName}' == true)
        {
            var senderName = $(formId+' #senderName').val();
            if (senderName.length < 3 || senderName.length > 150)
            {
                throwError('Please enter a valid sender\'s name');
            }
            else
            {
                invokeMessageEncoding(formId);
            }
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
            invokeMessageEncoding(formId);
        }
    });

    $('#decodeForm #btnSubmit').click(function(){
        var formId = '#decodeForm';
        var messageRef = $(formId+' #messageRef').val();
        var secretKey = $(formId+' #secretKey').val();

        if (messageRef.length < 24 || messageRef.length > 24)
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
                        throwAlert(data.data.message, 'message', 'success');
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