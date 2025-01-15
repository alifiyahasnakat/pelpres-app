@if(auth()->check())
<header id="page-topbar">
    <div class="navbar-header">
        <div class="d-flex">
            <!-- LOGO -->
            <div class="navbar-brand-box">
                <a href="/" class="logo logo-dark">
                    <span class="logo-sm">
                        <img src="{{ asset('assets/img/logo-sipelpres.png') }}" alt="" height="30">
                    </span>
                    <span class="logo-lg">
                        <img src="{{ asset('assets/img/logo-sipelpres.png') }}" alt="" height="28">
                    </span>
                </a>

                <a href="/" class="logo logo-light">
                    <span class="logo-sm">
                        <img src="{{ asset('assets/img/logo-cendana.png') }}" alt="" height="50">
                    </span>
                    <span class="logo-lg">
                        <img src="{{ asset('assets/img/logo-sipelpres.png') }}" alt="" height="28">
                    </span>
                </a>
            </div>

            <button type="button" class="btn btn-sm px-3 font-size-16 header-item waves-effect vertical-menu-btn">
                <i class="fa fa-fw fa-bars"></i>
            </button>
        </div>

        <div class="d-flex">
            <div class="dropdown d-none d-lg-inline-block ms-1">
                <button type="button" class="btn header-item noti-icon waves-effect" data-bs-toggle="fullscreen">
                    <i class="uil-minus-path"></i>
                </button>
            </div>

            <div class="dropdown d-inline-block">
                <button type="button" class="btn header-item waves-effect" id="page-header-user-dropdown"
                    data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <img class="rounded-circle header-profile-user" src="{{ asset('assets/img/profile.gif') }}"
                        alt="Header Avatar">
                    <span class="d-none d-xl-inline-block ms-1 fw-medium font-size-15">{{ auth()->user()->name }}</span>
                    <i class="uil-angle-down d-none d-xl-inline-block font-size-15"></i>
                </button>
                <div class="dropdown-menu dropdown-menu-end">
                    <!-- item-->
                    <a href="" class="dropdown-item" data-bs-toggle="modal" data-bs-target=".gantiPassword">
                        <i class="uil uil-unlock-alt font-size-18 align-middle me-1 text-muted"></i> <span class="align-middle">Ganti Password</span>
                    </a>
                    <form action="/logout" method="POST">
                        @csrf
                        <button type="submit" class="dropdown-item"><i class="uil uil-sign-out-alt font-size-18 align-middle me-1 text-muted"></i> <span class="align-middle">Keluar</span></button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</header>
<!-- Modal Ganti Password -->
<div class="modal fade gantiPassword @if($errors->any()) show @endif" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true" @if($errors->any()) style="display:block;" @endif>
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Ganti Password</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form method="POST" action="{{ route('password.update') }}">
                    @csrf
                    <div class="row mb-4">
                        <label for="current_password" class="col-sm-4 col-form-label">{{ __('Password Lama') }}</label>
                        <div class="col-sm-8">
                            <input type="password" class="form-control @error('current_password') is-invalid @enderror" placeholder="Masukkan Password Lama" name="current_password" id="current_password" required>
                            @error('current_password')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>
                    <div class="row mb-4">
                        <label for="password" class="col-sm-4 col-form-label">Password Baru</label>
                        <div class="col-sm-8">
                            <input type="password" class="form-control @error('password') is-invalid @enderror" placeholder="Masukkan Password Baru" name="password" id="password" required>
                            @error('password')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>
                    <div class="row mb-4">
                        <label for="password_confirmation" class="col-sm-4 col-form-label">Konfirmasi Password Baru</label>
                        <div class="col-sm-8">
                            <input type="password" class="form-control" placeholder="Konfirmasi Password Baru" name="password_confirmation" id="password_confirmation" required>
                        </div>
                    </div>
                    <div class="row justify-content-end">
                        <div class="col-sm-8">
                            <div class="d-flex flex-wrap gap-3">
                                <button type="submit" class="btn btn-primary waves-effect waves-light w-md">Submit</button>
                                <button type="reset" class="btn btn-outline-danger waves-effect waves-light w-md">Reset</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div>
<!-- Modal Ganti Password -->
@endif

<script>
    document.addEventListener('DOMContentLoaded', function() {
        if (@json($errors->any())) {
            var gantiPasswordModal = new bootstrap.Modal(document.querySelector('.gantiPassword'));
            gantiPasswordModal.show();
        }
    });
</script>
