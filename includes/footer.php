<footer class="text-center text-lg-start text-white">
    <div class="container p-4 pb-0">
        <section>
            <div class="row">
                <div class="col-md-12">
                    <h5 class="text-uppercase text-center">Useful Links</h5>
                    <div class="d-flex justify-content-center align-items-center">
                        <ul class="list-inline list-unstyled">
                            <li class="list-inline-item">
                                <a href="<?=DEF_FULL_BASE_PATH_URL;?>" class="text-white text-decoration-none">Home</a> | 
                            </li>
                            <li class="list-inline-item">
                                <a href="auth/login" class="text-white text-decoration-none">Login</a> | 
                            </li>
                            <li class="list-inline-item">
                                <a href="auth/register" class="text-white text-decoration-none">Register</a> | 
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </section>

        <hr class="mb-4" />

        <section class="mb-4 text-center">
            <a class="btn btn-outline-light btn-floating m-1" href="https://github.com/samadeoye/sendsecret" role="button"><i class="fab fa-github"></i></a>
        </section>
    </div>

    <div class="text-center p-3" style="background-color: rgba(0, 0, 0, 0.2)">
        © <?=date('Y');?> Copyright <a class="text-white" href="<?=SITE_URL;?>"> <?=SITE_NAME;?> </a>
    </div>
</footer>