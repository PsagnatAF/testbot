@extends('dashboard')
@section('content_header')
    <h1>Категории</h1>
@stop
@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            {{ Form::open(['url' => 'categories/', 'method' => 'POST']) }}
                @foreach($categories as $key => $category)
                <div class="categories">
                    <hr />
                    <h3 class="title_count">{{$translates[$key]}}
                        <div style="display: inline-block;">
                            <a style="cursor: pointer;" onclick="removeField(event)"><i class="fas fa-arrow-alt-circle-up"></i></a>
                            <span class="countable">{{count($category) > 0 ? count($category) : 1}}</span>
                            <a style="cursor: pointer;" onclick="addField(event, '{{$key}}')"><i class="fas fa-arrow-alt-circle-down"></i></a>
                        </div>
                    </h3>
                    @if (count($category) > 0)
                        @foreach($category as $cat)
                        <div class="form-group row {{$key}}">
                            <div class="col-sm-6">
                                {{ Form::text($key . '['. $cat->id .']', $cat->name, array_merge(['class' => 'form-control', 'maxlength' => '100'])) }}
                            </div>
                        </div>
                        @endforeach
                    @else
                        <div class="form-group row {{$key}}">
                            <div class="col-sm-6">
                                <input class="form-control" name="{{$key}}[]" type="text" value="" maxlength="100">
                            </div>
                        </div>  
                    @endif
                </div>
                @endforeach
                <div class="form-group row"></div>
                    {{Form::submit('Сохранить', ['class' => 'btn btn-success'])}}
                </div>
            {{ Form::close() }}
        </div>
    </div>
</div>
@endsection