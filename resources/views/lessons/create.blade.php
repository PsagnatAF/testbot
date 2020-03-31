@extends('dashboard')
@section('content_header')
    <h1>Создать урок</h1>
@stop
@section('content')
    {{ Form::open(['url' => 'lessons/', 'method' => 'POST', 'class' => 'col-md-6', 'files'=>'true']) }}
    {{Form::token()}}
        @if(count($errors) > 0)
            <div class="alert alert-warning" role="alert">
                @foreach($errors->messages() as $key => $message)
                <p>Поле <b>{{$field_names[$key]}}</b> обязательно к заполнению.</p>
                @endforeach
            </div> 
        @endif
        <div class="form-group row">
            {{ Form::label('Название', null, ['class' => 'col-sm-2 col-form-label']) }}
            <div class="col-sm-10">
                {{ Form::text('name', null, array_merge(['class' => 'form-control'])) }}
            </div>
        </div>
        <div class="form-group row">
            {{ Form::label('Видеофайл', null, ['class' => 'col-sm-2 col-form-label', ]) }}
            <div class="col-sm-10">
                {{ Form::file('video', ['accept' => 'video/*', 'onchange'=>'showFile(this)']) }}
                <video style="padding-top: 5px;display:none;" id="videodd" src="" width="240" height="180" controls></video>
            </div>
        </div>
        <div class="form-group row">
            {{ Form::label('Пол', null, ['class' => 'col-sm-2 col-form-label']) }}
            <div class="col-sm-10">
                @foreach($genders as $gender)
                    {{Form::checkbox("genders[]",$gender->id ,false, [ "class" => "form-group",])}}
                    {{ Form::label($gender->name, null, ['class' => 'control-label']) }}
                @endforeach  
            </div>
        </div>
        <div class="form-group row">
            {{ Form::label('Возраст', null, ['class' => 'col-sm-2 col-form-label']) }}
            <div class="col-sm-10">
                @foreach($ages as $age)
                    {{Form::checkbox("ages[]",$age->id ,false, [ "class" => "form-group",])}}
                    {{ Form::label($age->name, null, ['class' => 'control-label']) }}
                @endforeach  
            </div>
        </div>
        <div class="form-group row">
            {{ Form::label('Уровень', null, ['class' => 'col-sm-2 col-form-label']) }}
            <div class="col-sm-10">
                @foreach($englevels as $englevel)
                    {{Form::checkbox("englevels[]",$englevel->id ,false, [ "class" => "form-group",])}}
                    {{ Form::label($englevel->name, null, ['class' => 'control-label']) }}
                @endforeach  
            </div>
        </div>
        <div class="form-group row">
            {{ Form::label('Жанры', null, ['class' => 'col-sm-2 col-form-label']) }}
            <div class="col-sm-10 multiline">
                @foreach($genres as $genre)
                <div style="padding-right: 1rem;"> 
                    {{Form::checkbox("genres[]",$genre->id ,false, [ "class" => "form-group",])}}
                    {{ Form::label($genre->name, null, ['class' => 'control-label']) }}
                </div>
                @endforeach  
            </div>
        </div>
        <div class="form-group row">
            {{ Form::label('Диалог', null, ['class' => 'col-sm-2 col-form-label']) }}
            <div class="col-sm-10">
                {!! Form::textarea('dialog', null, ['rows' => 4, 'style' => 'resize:none', 'class' => 'form-control']) !!}
            </div>
        </div>
        <div class="form-group row">
            {{ Form::label('Слова', null, ['class' => 'col-sm-2 col-form-label']) }}
            <div class="col-sm-10">
                {!! Form::textarea('words', null, ['rows' => 4, 'style' => 'resize:none', 'class' => 'form-control']) !!}
            </div>
        </div>
        <div class="form-group row">
            <div class="col-sm-2"></div>
            <div class="col-sm-10">
                {{Form::submit('Сохранить', ['class' => 'btn btn-success'])}}
            </div>
        </div>
    {{ Form::close() }}
    <script>
    function showFile(input) {
        let file = input.files[0];
        var reader = new FileReader();
        let videoadd = document.getElementById('videodd');

        reader.onload = function(file) {
            let fileContent = reader.result;
            videoadd.src = fileContent;
            if(videoadd.src != '')
            {
                videoadd.style.display = 'block';
            }
        }
        if(file) {
            reader.readAsDataURL(file);
        } else {
            videoadd.src = '';
            videoadd.style.display = 'none';
        }
    }
    </script>
@endsection