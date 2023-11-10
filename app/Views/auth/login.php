<?= $this->extend('auth/template') ?>

<?= $this->section('content') ?>
<main>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-5">
                <div class="card shadow-lg border-0 rounded-lg mt-5">
                    <div class="card-header">
                        <h3 class="text-center font-weight-light my-4">Login Robo Petshop</h3>
                    </div>
                    <div class="card-body">
                        <form action="/login/auth" method="post">
                            <?= csrf_field() ?>
                            <div class="form-floating mb-3">
                                <input class="form-control <?php if (session('msg')) : ?>is-invalid<?php endif ?>" name="email" placeholder="Email atau Username" type="text" />
                                <label for="inputEmail">Email atau Username</label>
                                <div class="invalid-feedback">
                                    <?= session('msg') ?>
                                </div>
                            </div>
                            <div class="form-floating mb-3">
                                <input class="form-control <?php if (session('msg')) : ?>is-invalid<?php endif ?>" name="password" type="password" placeholder="Password" />
                                <label for="inputPassword">Password</label>
                                <div class="invalid-feedback">
                                    <?= session('msg') ?>
                                </div>
                                  <div class="d-grip gap-2">
                                </div>  
                                <div class="mt-4 mb-0">
                                    <div class="d-grid">
                                        <button type="submit" class="btn btn-primary btn-block">Login</button>
                                    </div>
                                </div>
                        </form>
                    </div>
                    <div class="card-footer text-center py-3">
                        <div class="small"><a href="login/register">Register</a></div>
                    </div>
                </div>
                <div class="card-footer text-center py-3">
                </div>
            </div>
        </div>
    </div>
    </div>
</main>
<?= $this->endSection() ?>