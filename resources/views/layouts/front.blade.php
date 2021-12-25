<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    @include('includes.landing.meta')

    <title>@yield('title') | SERV</title>

    @stack('before-style')
    @include('includes.landing.style')
    @stack('after-style')
</head>

<body class="antialiased">
    <div class="relative">

        @include('sweetalert::alert')

        @yield('content')

        @include('includes.landing.footer')
    </div>

    @stack('before-script')
    @include('includes.landing.script')
    @stack('after-script')

    @include('components.modal.login')
    @include('components.modal.register')
    @include('components.modal.register-success')
</body>

</html>