<!DOCTYPE html>
<html>
    <head>
        <title>Laravel</title>

        <link href="https://fonts.googleapis.com/css?family=Lato:100" rel="stylesheet" type="text/css">

        <style>
            html, body {
                height: 100%;
            }

            body {
                margin: 0;
                padding: 0;
                width: 100%;
                display: table;
                font-weight: 100;
                font-family: 'Lato';
            }

            .container {
                text-align: center;
                display: table-cell;
                vertical-align: middle;
            }

            .content {
                text-align: center;
                display: inline-block;
            }

            .title {
                font-size: 56px;
            }
             .subtitle {
                font-size: 36px;
            }
            image {
                background: url("/fashion.jpg");
            }
        </style>
    </head>
    <body style="background-image:url({{url('fashion.jpg')}})‌​">
        <div class="container">
            <div class="content">
                <div class="title"><b>FashionBook Application , Built with Laravel and Vue.js</b></div>
                 <div class="subtitle">Lead Engineer | abako220@gmail.com</div>
                 <div class="subtitle">Founder : Valentine Elijah Abako</div>
            </div>
        </div>
    </body>
</html>
