<!doctype html>
<html lang="en">

@include('partials.head-css')

<body class="authentication-bg">

    <div class="account-pages my-5 pt-sm-5">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    
                </div>
            </div>
            <div class="row align-items-center justify-content-center">
                <div class="col-md-8 col-lg-6 col-xl-5">
                    <div class="card">

                        <div class="card-body p-4">
                            <div class="text-center mt-2">
                                <h5 class="text-primary">Sistem Informasi</h5>
                                <p class="text-muted">Pelanggaran dan Prestasi SMA CENDANA</p>
                                <div class="text-center">
                                    <a href="/" class="mb-5 d-block auth-logo">
                                        <img src="{{ asset('assets/img/logo-cendana.png') }}" alt="Logo Cendana" height="100" class="logo logo-dark">
                                    </a>
                                </div>

                            </div>
                            @if(session()->has('loginError'))
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                {{ session('loginError') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                            @endif
                            <div class="p-2 mt-4">
                                <form action="/" method="POST">
                                    @csrf   
                                    <div class="mb-3">
                                        <label class="form-label" for="nips">NIK / NISN</label>
                                        <input type="text" name="nips" id="nips" class="form-control" id="nips" placeholder="Masukkan NIK / NISN" autofocus>
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label" for="password"> Kata Sandi</label>
                                        <input type="password" name="password" id="password" class="form-control" id="password" placeholder="Masukkan Kata Sandi">
                                    </div>


                                    <div class="mt-3 text-end">
                                        <button class="btn btn-primary w-sm waves-effect waves-light" type="submit">Masuk</button>
                                    </div>

                                </form>
                            </div>
                        </div>
                    </div>

                    <div class="mt-5 text-center">
                        <p>© <script>
                                document.write(new Date().getFullYear())
                            </script> SIPilPres. Crafted with <i class="mdi mdi-heart text-danger"></i> by Politeknik Caltex Riau</p>
                    </div>

                </div>
            </div>
            <!-- end row -->
        </div>
        <!-- end container -->
    </div>

    <!-- JAVASCRIPT -->
    @include('partials.vendor-scripts')

</body>

</html>