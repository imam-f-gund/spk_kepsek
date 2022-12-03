<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Login</title>

    <!-- Custom fonts for this template-->
    <link href="{{ asset('sbadmin/vendor/fontawesome-free/css/all.min.css') }}" rel="stylesheet" type="text/css">


    <!-- Custom styles for this template-->
    <link href="{{ asset('sbadmin/css/sb-admin-2.min.css') }}" rel="stylesheet">

    <style>
        .bg-gradient-success {
            background-color: #009241;
            background-image: linear-gradient(180deg, #009241 10%, #034b31 100%);
            background-size: cover;
        }

        input {
            font-size: 11pt !important;
            padding: 10px 10px;
        }

    </style>

</head>

<body class="bg-gradient-success">

    <div class="container">

        <!-- Outer Row -->
        <div class="row justify-content-center">

            <div class="col-md-6">

                <div class="card my-3">
                    <div class="card-body">
                        <div class="p-3">
                            <div class="text-center">
                                <img src="{{ asset('img/logo.png') }}" width="30%" class="mb-3" />
                                <h2 class="h4 text-gray-900">SPK Penilaian Kepala Sekolah</h2>
                                <h2 class="h4 text-gray-900 mb-5">PC LP Ma’arif NU Lamongan</h2>
                            </div>
                            <form class="user" action="{{ url('cek-login') }}" method="POST">
                                @csrf
                                <div class="form-group">
                                    <input type="text" class="form-control form-control-user" name="username"
                                        placeholder="Username">
                                </div>
                                <div class="form-group">
                                    <input type="password" class="form-control form-control-user" name="password"
                                        placeholder="Password">
                                </div>
                                <div class="form-group">
                                    <div class="custom-control custom-checkbox small">
                                        <input type="checkbox" class="custom-control-input" id="customCheck">
                                    </div>
                                </div>
                                <button type="submit" class="btn btn-success btn-user btn-block mt-1"
                                    style="font-size:1rem;">
                                    Login
                                </button>
                                <hr>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>

    <!-- Bootstrap core JavaScript-->
    <script src="{{ asset('sbadmin/vendor/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('sbadmin/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>

    <!-- Core plugin JavaScript-->
    <script src="{{ asset('sbadmin/vendor/jquery-easing/jquery.easing.min.js') }}"></script>

    <!-- Custom scripts for all pages-->
    <script src="{{ asset('sbadmin/js/sb-admin-2.min.js') }}"></script>


    @if ($errors->any())
        <div id="ERROR_COPY" style="display: none;" class="alert alert-danger">
            @foreach ($errors->all() as $error)
                <h6>{{ $error }}</h6>
            @endforeach
        </div>
    @endif

    @if (config('sweetalert.animation.enable'))
        <link rel="stylesheet" href="{{ config('sweetalert.animatecss') }}">
    @endif
    <script src="{{ $cdn ?? asset('vendor/sweetalert/sweetalert.all.js') }}"></script>

    <script type="text/javascript">
        var cekError = {{ $errors->any() > 0 ? 'true' : 'false' }};
        var ht = $("#ERROR_COPY").html();
        if (cekError) {
            Swal.fire({
                title: 'Errors',
                icon: 'error',
                html: ht,
                showCloseButton: true,
            });
        }
    </script>

    @include('sweetalert::alert')
</body>

</html>
