@extends('dashboard')
@section('content_header')
    <h1>Тексты</h1>
@stop
@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
        {{ Form::open(['url' => 'texts/', 'method' => 'POST', 'class' => 'col-md-6']) }}
        {{Form::token()}}
            @foreach ($texts as $key => $text)
                <div class="form-group row">
                {{ Form::label('Текст'. ($key + 1) , null, ['class' => 'col-sm-2 col-form-label']) }}
                <div class="col-sm-10">
                    {{ Form::text($text->role, $text->content, array_merge(['class' => 'form-control'])) }}
                </div>
            </div>
            @endforeach         
            <div class="form-group row">
                <div class="col-sm-2"></div>
                <div class="col-sm-10">
                    {{Form::submit('Сохранить', ['class' => 'btn btn-success'])}}
                </div>
            </div>
        {{ Form::close() }}
        </div>
    </div>
</div>
@endsection
