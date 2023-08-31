<?php
require_once '../includes/utils.php';
$arAdditionalCSS[] = <<<EOQ
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css">
EOQ;
require_once DEF_DOC_ROOT.'includes/head.php';
require_once DEF_DOC_ROOT.'includes/header.php';
?>

<div class="container-fluid login-cta">
    <div class="row">
        <div class="col-md-12 pt-5 pb-4 text-center">
            <h4>Dashboard</h4>
            <span><a href="" class="text-dark">Home</a> - Dashboard</span>
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
                        <button type="submit" class="btn btn-dark" id="btnSubmit">ENCODE</button>
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
                        <button type="submit" class="btn btn-dark" id="btnSubmit">DECODE</button>
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
                    <tr>
                        <td>1</td>
                        <td>System Architect</td>
                        <td>Edinburgh</td>
                    </tr>
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
$arAdditionalJsOnLoad[] = <<<EOQ
    new DataTable('#messagesTable');
EOQ;
?>

<?php require_once DEF_DOC_ROOT.'includes/foot.php'; ?>