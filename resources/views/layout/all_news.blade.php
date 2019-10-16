<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Laravel</title>

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet">

    <!-- Styles -->
    <style>
        html, body {
            background-color: #fff;
            color: #636b6f;
            font-family: 'Nunito', sans-serif;
            font-weight: 200;
            height: 100vh;
            margin: 0;
        }
        table, th, td {
            border: 1px solid black;
        }

        .full-height {
            height: 100vh;
        }

        .flex-center {
            align-items: center;
            display: flex;
            justify-content: center;
        }

        .position-ref {
            position: relative;
        }

        .top-right {
            position: absolute;
            right: 10px;
            top: 18px;
        }

        .content {
            text-align: center;
        }

        .title {
            font-size: 84px;
        }

        .links > a {
            color: #636b6f;
            padding: 0 25px;
            font-size: 13px;
            font-weight: 600;
            letter-spacing: .1rem;
            text-decoration: none;
            text-transform: uppercase;
        }

        .m-b-md {
            margin-bottom: 30px;
        }
    </style>
</head>
<body>
<div class="flex-center position-ref full-height">
    @if (Route::has('login'))
        <div class="top-right links">
            @auth
                <a href="{{ url('/home') }}">Home</a>
            @else
                <a href="{{ route('login') }}">Login</a>

                @if (Route::has('register'))
                    <a href="{{ route('register') }}">Register</a>
                @endif
            @endauth
        </div>
    @endif

        <form  method="POST" action="{{url('insert/news')}}">
            <input type="hidden" name="_token" value="{{ csrf_token() }}">


            <input type="text" name="title"><br>

            <input type="text" name="add_by"><br>
            <input type="text" name="description"><br>
            <input type="text" name="content"><br>
            <select name="status" id=""><br>
                <option value="active">active</option>
                <option value="pending">pending</option>
                <option value="deactivate">deactivate</option>
            </select>
            <input type="submit" name="send" value="send data"><br>
        </form>

    <div class="content">
        <table style="width:100%">
            <tr>
                <th>title</th>
                <th>add_br</th>
                <th>state</th>
                <th>description</th>
                <th>content</th>
            </tr>
           @foreach($all_news as $news)
               <tr>
                   <td>{{$news->title}}</td>
                   <td>{{$news->add_by}}</td>
                   <td>{{$news->status}}</td>
                   <td>{{$news->description}}</td>
                   <td>{{$news->content}}</td>
                   <form  method="POST" action="{{url('del/news/'.$news->id)}}">
                       <input type="hidden" name="_token" value="{{ csrf_token() }}">
                       <input type="hidden" name="_method" value="DELETE">
                       <input type="submit" name="send" value="Delete this">


                   </form>
               </tr>


               @endforeach
        </table>
    </div>
</div>
</body>
</html>
