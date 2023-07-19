@extends('adminlte::page')

@section('title', 'Admin Panel')

@section('content_header')
    <h1 class="m-0 text-dark">Feedback</h1>
@stop

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <table class="table table-bordered table-stripped table-responsive-sm text-center">
                        <thead>
                            <tr>
                                <th style="width:50px;">S.no</th>
                                <th style="width:120px;">User Name</th>
                                <th>Title</th>
                                <th>Description</th>                               
                            </tr>
                        </thead>
                        <tbody>
                            <?php $i=1; ?>
                            @foreach($feedback as $feed)
                                <tr>
                                    <td>{{$i++}}</td>
                                    <td>{{$feed->user_id}}</td>
                                    <td>{{$feed->title}}</td>
                                    <td>{{$feed->description}}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@stop
