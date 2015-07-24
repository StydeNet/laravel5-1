@extends('layout')

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                @include('partials/success')
                <div class="panel panel-default">
                    <div class="panel-heading">Welcome!</div>
                    <div class="panel-body">
                        <h1>Laravel 5</h1>
                        <p>Welcome to our site!</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection