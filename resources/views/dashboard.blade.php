{{-- resources/views/admin/dashboard.blade.php --}}
<meta name="csrf-token" content="{{ csrf_token() }}">
@extends('adminlte::page')

@section('title', 'Dashboard')

@section('css')
    <link rel="stylesheet" href="{{ secure_asset('css/app.css') }}">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.20/css/jquery.dataTables.min.css">
    <style>
    .multiline {
        display:flex;
        flex-wrap: wrap;
    }
    </style>
@stop

@section('js')
    <script>
    var treeviews = document.getElementsByClassName('treeview');
    [].forEach.call(treeviews, function(treeview){
        treeview.addEventListener('mouseover', function(){
            if(this.classList.contains('menu-open')){
            } else {
                this.querySelector('ul.treeview-menu').style.display = 'block';
            }
        });
        treeview.addEventListener('mouseout', function(){
            if(this.classList.contains('menu-open')){
            } else {
                this.querySelector('ul.treeview-menu').style.display = 'none';
            }
        })
    });
    </script>
    <script src="https://cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#data-table').DataTable( {
                "order": [[ 0, "asc" ]],
                "searching": false,
                "pageLength": 50
            } );
            $('#users-table').DataTable( {
                "order": [[ 0, "asc" ]],
                "searching": false,
                "pageLength": 50
            } );
            $('#user-lessons-table').DataTable( {
                "order": [[ 1, "desc" ]],
                "searching": false,
                "pageLength": 50
            } );
        } );
    </script>
    <script>
        function setCount()
        {
            let elements = document.querySelectorAll('h3.title_count');
            [].forEach.call(elements, function(element){
                let parent = element.parentElement
                let count = parent.querySelectorAll('.form-group').length;
                parent.querySelector('.countable').innerText = count;
            });
        }
        document.addEventListener("DOMContentLoaded", setCount);
        function addField(e, key)
        {
            let el = e.target;
            let parent = el.closest('.categories')
            let row = document.createElement('div');
            let classes = ['form-group', 'row', key];
            classes.forEach((x)=>row.classList.add(x));
            row.innerHTML = `<div class="col-sm-6">
                                <input class="form-control" name="${key}[]" type="text" value="" maxlength="100">
                            </div>`
            parent.appendChild(row)
            let count = parent.querySelectorAll('.form-group').length;
            parent.querySelector('.countable').innerText = count;
        }
        function removeField(e)
        {
            let el = e.target;
            let parent = el.closest('.categories');
            let els = parent.querySelectorAll('.form-group');
            let count = els.length;
            if(count > 1) {
                els[count-1].remove();
                count--;
            }
            parent.querySelector('.countable').innerText = count;
        }
    </script>
    <script>
        document.addEventListener("DOMContentLoaded",function() {setTimeout(()=>{document.querySelector('.content-wrapper').style.minHeight = document.documentElement.scrollHeight;}, 200);});
        document.querySelector('a.logo').style.display = 'none';
    </script>
@stop