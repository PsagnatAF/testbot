@extends('dashboard')
@section('content_header')
    <h1>Пользователи</h1>
@stop
@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <table id="users-table" class="display" style="width:100%">
                <thead>
                    <tr>
                        <th>Имя</th>
                        <th>Дата</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($telegramusers as $user)
                        <tr>
                            <td><a href="{{url('telegramusers', $user->id)}}">{{$user->name}}</a></td>
                            <td>{{$user->created_at->format('d.m.Y')}}</td>
                        </tr>
                    @endforeach
                </tbody>
                <tfoot>
                    <tr>
                        <th>Имя</th>
                        <th>Дата</th>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>
    <script>

    </script>
</div>
@endsection
