<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="UTF-8">
        <meta name="description" content="ESL">
        <meta name="keywords" content="english,second,language,teacher,student,learning">
        <meta name="author" content="Benjamin Caceres">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">

        <!-- Bootrstrap -->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
        
        <!-- CSS -->
        <link rel="stylesheet" type="text/css" href="{{ asset('/css/app.css') }}">
        
        <!-- FontAwesome Icons -->
        <script src="https://kit.fontawesome.com/9c85c53d3e.js" crossorigin="anonymous"></script>

        <!-- Google Fonts -->
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Hind+Siliguri:wght@300;400;600&display=swap" rel="stylesheet"> 

        
        <title>ESL-IYLS - Login</title>

    </head>
    <body class="d-flex flex-column min-vh-100">

        <div class="container h-100">
            <div class="row align-items-center h-100">
                <div class="col-10 col-sm-10 col-md-8 col-lg-6 col-xl-4 mx-auto">
                    <div class="bg-white p-4 rounded border border-1 border-white shadow-md">
                        <form action="">
                            <h3 class="form-label mb-3">Login</h3>
                            <div class="mb-3">
                                <label for="email" name="email-label" class="form-label">E-mail</label>
                                <input type="email" name="email" class="form-control" required placeholder="Please enter your e-mail">
                            </div>
                            <div class="mb-3">
                                <label for="password" name="password-label" class="form-label">Password</label>
                                <input type="password" name="password" protected class="form-control" required aria-label placeholder="Please enter your password">
                            </div>
                            <div class="mb-3">
                                <a class="btn btn-primary" href="//localhost:8080/">Login</a>
                                <button class="btn btn-secondary" type="submit">Create account</button>
                            </div>
                            <a class="text-link form-link" href="#">Forgot my password</a>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        
    <!-- Lottie -->
    <script src="https://unpkg.com/@lottiefiles/lottie-player@latest/dist/lottie-player.js"></script>

    <!-- Bootstrap -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>

    </body>
</html>