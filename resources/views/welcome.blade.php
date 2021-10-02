<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>DPUNUM GROUP NO Auth</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap" rel="stylesheet">

        <!-- Styles -->


        <style>
            body {
                font-family: 'Nunito';
            }
        </style>
    </head>
    <body class="antialiased">
<div style="margin-top:120">
  <br>
  <br>
  <br>
  <br>
  <br>
  <br>
  <br>
    <table class="table table-bordered" align="center" >
        <tr>
            <th><a class="btn btn-info" href="{{ route('events.index') }}">Просмотреть события</a></th>
            <th></th>
            <th>Зарегистрироваться</th>
            <th></th>
            <th>Войти</th>
        </tr>

    </table>
</div>
    </body>
</html>
