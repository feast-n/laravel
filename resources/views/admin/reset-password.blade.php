<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>SB Admin 2 - Reset Password</title>

    <link href="{{ asset('asset_admin/vendor/fontawesome-free/css/all.min.css') }}" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">
    <link href="{{ asset('asset_admin/css/sb-admin-2.min.css') }}" rel="stylesheet">

    <style>
        #btnSubmit {
            transition: opacity 0.3s ease, background-color 0.3s ease;
        }
        #btnSubmit:disabled {
            opacity: 0.4;
            cursor: not-allowed;
            pointer-events: none;
        }
    </style>
</head>

<body class="bg-gradient-primary">

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-xl-10 col-lg-12 col-md-9">
                <div class="card o-hidden border-0 shadow-lg my-5">
                    <div class="card-body p-0">
                        <div class="row">
                            <div class="col-lg-6 d-none d-lg-block bg-password-image"></div>
                            <div class="col-lg-6">
                                <div class="p-5">
                                    <div class="text-center">
                                        <h1 class="h4 text-gray-900 mb-2">Buat Password Baru</h1>
                                        <p class="mb-4">Reset password untuk email: <br><strong>{{ $email }}</strong></p>
                                    </div>

                                    @if ($errors->any())
                                        <div class="alert alert-danger small">
                                            <ul class="mb-0 pl-3">
                                                @foreach ($errors->all() as $error)
                                                    <li>{{ $error }}</li>
                                                @endforeach
                                            </ul>
                                        </div>
                                    @endif

                                    <form class="user" action="{{ route('action-reset-password') }}" method="POST">
                                        @csrf
                                        <div class="form-group">
                                            <input type="password" name="password" class="form-control form-control-user"
                                                id="exampleInputPassword" placeholder="Password Baru" required>
                                            <small id="passwordError" class="text-danger ml-2 mt-1 d-block" style="visibility: hidden;">
                                                Password minimal harus 6 karakter.
                                            </small>
                                        </div>
                                        <div class="form-group">
                                            <input type="password" name="password_confirmation" class="form-control form-control-user"
                                                id="exampleRepeatPassword" placeholder="Ulangi Password Baru" required>
                                            <small id="matchError" class="text-danger ml-2 mt-1 d-block" style="visibility: hidden;">
                                                Password belum sama.
                                            </small>
                                        </div>
                                        <button type="submit" id="btnSubmit" class="btn btn-primary btn-user btn-block" disabled>
                                            Simpan Password Baru
                                        </button>
                                    </form>
                                    <hr>
                                    <div class="text-center">
                                        <a class="small" href="{{ route('login') }}">Kembali ke Login</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="{{ asset('asset_admin/vendor/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('asset_admin/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('asset_admin/vendor/jquery-easing/jquery.easing.min.js') }}"></script>
    <script src="{{ asset('asset_admin/js/sb-admin-2.min.js') }}"></script>

    <script>
        $(document).ready(function () {
            const $passwordInput = $('#exampleInputPassword');
            const $repeatPasswordInput = $('#exampleRepeatPassword');
            const $btnSubmit = $('#btnSubmit');
            const $passwordError = $('#passwordError');
            const $matchError = $('#matchError');

            function validatePassword() {
                const passwordVal = $passwordInput.val();
                const repeatVal = $repeatPasswordInput.val();

                const isLengthValid = passwordVal.length >= 6;
                const isMatchValid = (passwordVal === repeatVal) && repeatVal.length > 0;

                if (passwordVal.length > 0 && !isLengthValid) {
                    $passwordError.css('visibility', 'visible');
                } else {
                    $passwordError.css('visibility', 'hidden');
                }

                if (repeatVal.length > 0 && !isMatchValid) {
                    $matchError.css('visibility', 'visible');
                } else {
                    $matchError.css('visibility', 'hidden');
                }

                if (isLengthValid && isMatchValid) {
                    $btnSubmit.prop('disabled', false);
                } else {
                    $btnSubmit.prop('disabled', true);
                }
            }

            $passwordInput.on('input keyup', validatePassword);
            $repeatPasswordInput.on('input keyup', validatePassword);
        });
    </script>

</body>

</html>
