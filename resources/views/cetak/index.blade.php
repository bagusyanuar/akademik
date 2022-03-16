<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <link href="style/bootstrap3.min.css" rel="stylesheet">
    <style>
        .report-title {
            font-size: 14px;
            font-weight: bolder;
        }

        .f-bold {
            font-weight: bold;
        }

        .footer{
            position: fixed;
            bottom: 0cm;
            right: 0cm;
            height: 2cm;
        }

    </style>
</head>
<body>
<div class="text-center f-bold report-title">LAPORAN HASIL BELAJAR</div>
<div class="text-center f-bold report-title" style="font-size: 16px">MA Al-MANSHUR POPONGAN KLATEN</div>
<div class="text-center">Popongan, RT.03/RW.03, Tegalgondo</div>
<br/>
@yield('content')
</body>
</html>
