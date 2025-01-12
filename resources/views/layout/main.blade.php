<!DOCTYPE html>
<html lang="en">

<head>
    @include('includes.metas')
    @include('includes.styles')
    @stack('styles')
</head>

<body class="bg-white dark:bg-gray-900">
    @include('includes.navbar')
    @yield('content')
    @include('includes.scripts')
    @stack('scripts')
</body>

</html>