@extends('dashboard')
@section('content_header')
    <h1>Список уроков</h1>
@stop
@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <table id="data-table" class="display" style="width:100%">
                <thead>
                    <tr>
                        <th>Название</th>
                        <th>Дата</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($lessons as $lesson)
                        <tr>
                            <td><a href="{{url('lessons', $lesson->id)}}">{{$lesson->name}}</a></td>
                            <td>{{$lesson->created_at->format('d.m.Y')}}</td>
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
@endsection
