<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title>403 Error</title>
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="shortcut icon" type="image/x-icon" href="{{ asset('front/assets/images/favicon.svg') }}">

    <link rel="stylesheet" href="{{ asset('front/assets/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('front/assets/css/LineIcons.3.0.css') }}">
    <link rel="stylesheet" href="{{ asset('front/assets/css/main.css') }}">
</head>

<body>

    <div class="preloader" style="opacity: 0; display: none;">
        <div class="preloader-inner">
            <div class="preloader-icon">
                <span></span>
                <span></span>
            </div>
        </div>
    </div>


    <div class="error-area">
        <div class="d-table">
            <div class="d-table-cell">
                <div class="container">
                    <div class="error-content">
                        <h1>403</h1>
                        <h2>Oops! Forbidden!</h2>
                        <p>The page you are looking for forbidden. It might have been moved or deleted.</p>
                        <div class="button">
                            <a href="{{route('home_page')}}" class="btn">Back to Home</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <script src="{{ asset('front/assets/js/bootstrap.min.js') }}"></script>
    <script>
    window.onload = function() {
        window.setTimeout(fadeout, 500);
    }

    function fadeout() {
        document.querySelector('.preloader').style.opacity = '0';
        document.querySelector('.preloader').style.display = 'none';
    }
    </script>

</body>

</html>