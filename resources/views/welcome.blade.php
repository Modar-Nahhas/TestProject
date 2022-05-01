<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>{{env('APP_NAME')}}</title>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.1.3/dist/css/bootstrap.min.css"
          integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.1.3/dist/js/bootstrap.min.js"
            integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy"
            crossorigin="anonymous"></script>

    <style>

        #user_table {
            border: 2px lightgray solid;
        }

        td {
            margin: 2px 0;
            padding: 2px 0;
        }
    </style>

</head>
<body class="antialiased">
<div style="display: flex; justify-content: center; align-items: center; flex-direction: row; height: 100vh;">
    <div style="width: 50%;height: 80vh; overflow-y: auto;">
        <table id="user_table" class="table table-borderless">
            <thead style="position: sticky; top: 0; z-index: 1; background-color: white;">
            <tr>
                <th>#</th>
                <th>Name</th>
                <th>Score</th>
            </tr>
            </thead>
            <tbody>
            @foreach($users as $user)
                @php $u = request()->route('id') == $user->id @endphp
                <tr style="background-color: {{$u?'#fbebeb':'white'}};">
                    <td style="font-weight: bold; color: {{$u?'#c95660':'black'}}">{{ $user->position}}</td>
                    <td>
                        <img src="{{$user->image_url}}" width="40" height="40" style="border-radius: 50%;">
                        <span>{{ $user->username}}</span>
                    </td>
                    <td style="color: {{$u?'#c95660':'black'}}">{{ $user->karma_score}}</td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
</div>

<script>
    $(document).ready(function () {
        // $('#user_table').DataTable({
        //     'paging': false,
        //     'searching': false,
        //     serverSide: true,
        //     ajax: {
        //         url: '/aoi/v1/user/5/karma-score',
        //         type: 'GET'
        //     }
        // });
    });
</script>
</body>
</html>
