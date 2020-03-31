@extends('dashboard')
@section('content_header')
    <h1>{{$telegramuser->name}}</h1>
@stop
@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-4">
        @foreach ($categories as $index => $name)
            <div class="panel panel-default">
                <div class="panel-heading">{{$name}}</div>
                    @foreach($telegramuser->$index()->get() as $cat)
                        <div class="panel-body">
                            {{$cat->name}}
                        </div>
                    @endforeach
            </div>
        @endforeach
        </div>
        <div class="col-md-8">
            <div class="panel panel-default">
                <table id="user-lessons-table" class="display" style="width:100%">
                    <thead>
                        <tr>
                            <th>Название</th>
                            <th>Дата</th>
                        </tr>
                    </thead>
                    <tbody>
                    @foreach($telegramuser->lessons as $lesson)
                        <tr>
                            <td><a href="{{url('lessons', $lesson->id)}}">{{$lesson->name}}</a></td>
                            <td>{{$lesson->pivot->created_at}}</td>
                        </tr>
                    @endforeach
                    </tbody>
                    <tfoot>
                        <tr>
                            <th>Название</th>
                            <th>Дата</th>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection