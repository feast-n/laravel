<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>SB Admin 2 - Register</title>

    <!-- Custom fonts for this template-->
    <link href="{{ asset('asset_admin/vendor/fontawesome-free/css/all.min.css') }}" rel="stylesheet" type="text/css">
    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="{{ asset('asset_admin/css/sb-admin-2.min.css') }}" rel="stylesheet">

    <style>
        /* Style untuk efek fadeoff pada tombol submit saat disabled */
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

        <div class="card o-hidden border-0 shadow-lg my-5">
            <div class="card-body p-0">
                <!-- Nested Row within Card Body -->
                <div class="row">
                    <div class="col-lg-5 d-none d-lg-block bg-register-image"></div>
                    <div class="col-lg-7">
                        <div class="p-5">
                            <div class="text-center">
                                <h1 class="h4 text-gray-900 mb-4">Create an Account!</h1>
                            </div>

                            @if ($errors->any())
                                <div class="alert alert-danger">
                                    <ul class="mb-0">
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif

                            <form class="user" action="{{ route('action-register') }}" method="POST">
                                @csrf
                                <div class="form-group row">
                                    <div class="col-sm-6 mb-3 mb-sm-0">
                                        <input type="text" class="form-control form-control-user" id="exampleFirstName"
                                            name="fname" value="{{ old('fname') }}" placeholder="First Name" required>
                                    </div>
                                    <div class="col-sm-6">
                                        <input type="text" class="form-control form-control-user" id="exampleLastName"
                                            name="lname" value="{{ old('lname') }}" placeholder="Last Name" required>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <input type="email" class="form-control form-control-user" id="exampleInputEmail"
                                        name="email" value="{{ old('email') }}" placeholder="Email Address" required>
                                </div>
                                <div class="form-group row">
                                    <div class="col-sm-6 mb-3 mb-sm-0">
                                        <input type="password" class="form-control form-control-user"
                                            id="exampleInputPassword" name="password" placeholder="Password" required>
                                        <small id="passwordError" class="text-danger ml-2 mt-1 d-block" style="visibility: hidden;">
                                            Password minimal harus 6 karakter.
                                        </small>
                                    </div>
                                    <div class="col-sm-6">
                                        <input type="password" class="form-control form-control-user"
                                            id="exampleRepeatPassword" name="password_confirmation" placeholder="Repeat Password" required>
                                        <small id="matchError" class="text-danger ml-2 mt-1 d-block" style="visibility: hidden;">
                                            Password belum sama.
                                        </small>
                                    </div>
                                </div>
                                <button type="submit" id="btnSubmit" class="btn btn-primary btn-user btn-block" disabled>
                                    Register Account
                                </button>
                            </form>
                            <hr>
                            <div class="text-center">
                                <a class="small" href="forgot-password.html">Forgot Password?</a>
                            </div>
                            <div class="text-center">
                                <a class="small" href="{{ route('login') }}">Already have an account? Login!</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>

    <!-- Bootstrap core JavaScript-->
    <script src="{{ asset('asset_admin/vendor/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('asset_admin/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>

    <!-- Core plugin JavaScript-->
    <script src="{{ asset('asset_admin/vendor/jquery-easing/jquery.easing.min.js') }}"></script>

    <!-- Custom scripts for all pages-->
    <script src="{{ asset('asset_admin/js/sb-admin-2.min.js') }}"></script>

    <!-- Script validasi password & konfirmasi password -->
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

                // Jika panjang password kurang dari 6, tampilkan error (visibility: visible),
                // jika sudah 6 atau lebih, sembunyikan teks tanpa merubah formasi layout (visibility: hidden)
                if (passwordVal.length > 0 && !isLengthValid) {
                    $passwordError.css('visibility', 'visible');
                } else {
                    $passwordError.css('visibility', 'hidden');
                }

                // Jika password belum sama, tampilkan error (visibility: visible),
                // jika sudah sama, sembunyikan teks tanpa merubah formasi layout (visibility: hidden)
                if (repeatVal.length > 0 && !isMatchValid) {
                    $matchError.css('visibility', 'visible');
                } else {
                    $matchError.css('visibility', 'hidden');
                }

                // Tombol aktif jika password minimal 6 karakter DAN kedua password cocok
                if (isLengthValid && isMatchValid) {
                    $btnSubmit.prop('disabled', false);
                } else {
                    $btnSubmit.prop('disabled', true);
                }
            }

            // Jalankan validasi secara real-time saat pengguna mengetik
            $passwordInput.on('input keyup', validatePassword);
            $repeatPasswordInput.on('input keyup', validatePassword);
        });
    </script>

</body>

</html>
