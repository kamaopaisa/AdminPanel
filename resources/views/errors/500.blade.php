@extends('adminlte::page')

@section('title', '500 Error')

@section('content_header')
    <h1 class="m-0 text-dark">500 Error</h1>
@stop

@section('content')

    <div class="error-page">
        <h2 class="headline text-danger">500</h2>
        <div class="error-content">
            <h3><i class="fas fa-exclamation-triangle text-danger"></i> Oops! Something went wrong.</h3>
            <p>
                We will work on fixing that right away.
                Meanwhile, you may <a href="{{URL('/home')}}">return to dashboard</a> or try using the search form.
            </p>
            <form class="search-form">
                <div class="input-group">
                    <input type="text" name="search" class="form-control" placeholder="Search">
                    <div class="input-group-append">
                        <button type="submit" name="submit" class="btn btn-danger"><i class="fas fa-search"></i></button>
                    </div>
                </div>

            </form>
        </div>
    </div>
@stop    