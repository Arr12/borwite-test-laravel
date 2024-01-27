<!DOCTYPE html>
<html>
<head>
    <title></title>
    <script src="{{ asset('js/app.js') }}" defer></script>
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-ui-bootstrap/0.5pre/assets/css/bootstrap.min.css" integrity="sha512-UVQYZVYu7WhHEaO2xGEmc4/3F8ctnXt4jwfGl2MCIHKc95RMgYS8yfNJ3j6wUe0UGiTK0S3vcmh3Ml9h278x5w==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <script src="//ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    @livewireStyles
</head>
<body style="height: 100vh;">
    <div class="container d-flex justify-content-center align-items-center">
        <div class="mt-5 justify-content-center">
            <div class="mt-5 d-flex align-items-center" style="height: 100vh;">
                @livewire('login-register')
            </div>
        </div>
    </div>
    @livewireScripts

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-ui-bootstrap/0.5pre/assets/js/bootstrap.min.js" integrity="sha512-ZPmDPQf8gWl5YoEwyPZMWi/kam9NTb2+jeChvhX8rfuUw0KCGlWt4HuWu5JQIo3/LWTuHLNZ2DqKFy8niqR6Sw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-ui-bootstrap/0.5pre/js/jquery-1.8.3.min.js" integrity="sha512-J9QfbPuFlqGD2CYVCa6zn8/7PEgZnGpM5qtFOBZgwujjDnG5w5Fjx46YzqvIh/ORstcj7luStvvIHkisQi5SKw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
</body>
</html>
