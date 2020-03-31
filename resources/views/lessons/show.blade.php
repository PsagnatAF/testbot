@extends('dashboard')
@section('content_header')
    <h1>Редактировать урок</h1>
@stop
@section('content')
    @if(count($errors) > 0)
        <div class="alert alert-warning" role="alert">
            @foreach($errors->messages() as $key => $message)
            <p>Поле <b>{{$field_names[$key]}}</b> обязательно к заполнению.</p>
            @endforeach
        </div> 
    @endif
    {{ Form::open(['url' => 'lessons/' . $lesson->id, 'method' => 'PUT', 'class' => 'col-md-6', 'files'=>'true']) }}
    {{Form::token()}}
        <div class="form-group row">
            {{ Form::label('Название', null, ['class' => 'col-sm-2 col-form-label']) }}
            <div class="col-sm-10">
                {{ Form::text('name', $lesson->name, array_merge(['class' => 'form-control'])) }}
            </div>
        </div>
        <div class="form-group row">
            {{ Form::label('Видеофайл', null, ['class' => 'col-sm-2 col-form-label']) }}
            <div class="col-sm-10">
                {{ Form::file('video', ['accept' => 'video/*', 'onchange'=>'showFile(this)']) }}
                <video style="padding-top: 5px;display:none;" id="videodd" src="{{$videolink}}" data-src="{{$lesson->link}}" width="240" height="180" controls download></video>
                <a style="display:none;" id="delvid" class="btn btn-danger" onclick="deleteVideo(event)">удалить</a>
            </div>

        </div>
        <div class="form-group row">
            {{ Form::label('Пол', null, ['class' => 'col-sm-2 col-form-label']) }}
            <div class="col-sm-10">
                @foreach($genders as $gender)
                    {{Form::checkbox("genders[]",$gender->id ,in_array($gender->id, array_column($lesson->genders->toArray(), 'id')), [ "class" => "form-group",])}}
                    {{ Form::label($gender->name, null, ['class' => 'control-label']) }}
                @endforeach  
            </div>
        </div>
        <div class="form-group row">
            {{ Form::label('Возраст', null, ['class' => 'col-sm-2 col-form-label']) }}
            <div class="col-sm-10">
                @foreach($ages as $age)
                    {{Form::checkbox("ages[]",$age->id ,in_array($age->id, array_column($lesson->ages->toArray(), 'id')), [ "class" => "form-group",])}}
                    {{ Form::label($age->name, null, ['class' => 'control-label']) }}
                @endforeach  
            </div>
        </div>
        <div class="form-group row">
            {{ Form::label('Уровень', null, ['class' => 'col-sm-2 col-form-label']) }}
            <div class="col-sm-10">
                @foreach($englevels as $englevel)
                    {{Form::checkbox("englevels[]",$englevel->id ,in_array($englevel->id, array_column($lesson->englevels->toArray(), 'id')), [ "class" => "form-group",])}}
                    {{ Form::label($englevel->name, null, ['class' => 'control-label']) }}
                @endforeach  
            </div>
        </div>
        <div class="form-group row">
            {{ Form::label('Жанры', null, ['class' => 'col-sm-2 col-form-label']) }}
            <div class="col-sm-10 multiline">
                @foreach($genres as $genre)
                    <div style="padding-right: 1rem;"> 
                    {{Form::checkbox("genres[]",$genre->id ,in_array($genre->id, array_column($lesson->genres->toArray(), 'id')), [ "class" => "form-group",])}}
                    {{ Form::label($genre->name, null, ['class' => 'control-label']) }}
                    </div>
                @endforeach  
            </div>
        </div>
        <div class="form-group row">
            {{ Form::label('Диалог', null, ['class' => 'col-sm-2 col-form-label']) }}
            <div class="col-sm-10">
                {!! Form::textarea('dialog', $lesson->dialog, ['rows' => 4, 'style' => 'resize:none', 'class' => 'form-control']) !!}
            </div>
        </div>
        <div class="form-group row">
            {{ Form::label('Слова', null, ['class' => 'col-sm-2 col-form-label']) }}
            <div class="col-sm-10">
                {!! Form::textarea('words', $lesson->words, ['rows' => 4, 'style' => 'resize:none', 'class' => 'form-control']) !!}
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
    document.addEventListener("DOMContentLoaded", function(event) {
        let videodd = document.getElementById('videodd');
        if(videodd.src && videodd.dataset && videodd.dataset['src'] != "")
        {
            videodd.style.display = 'block';
            document.getElementById('delvid').style.display = '';
        }
    });
    function showFile(input) {
        let file = input.files[0];
        var reader = new FileReader();
        let videoadd = document.getElementById('videodd');
        let delvid = document.getElementById('delvid');
        reader.onload = function(file) {
            let fileContent = reader.result;
            videoadd.src = fileContent;
            if(videoadd.src != '')
            {
                videoadd.style.display = 'block';
                delvid.style.display = '';
            }
        }
        if(file) {
            reader.readAsDataURL(file);
        } else {
            videoadd.src = '';
            videoadd.style.display = 'none';
            delvid.style.display = 'none';
        }
    }
    function deleteVideo(e)
    {
        var el = document.querySelector("#videodd");
        var delvid = document.querySelector("#delvid");
        $.get( "{{secure_url('api/lessons/deletevideo')}}",{lesson_id: '{{$lesson->id}}'}).done(res=>{
            if(res.result && res.result == 'success')
            {
                el.style.display = 'none';
                delvid.style.display = 'none';
            }
        });        
    }
    </script>
@endsection