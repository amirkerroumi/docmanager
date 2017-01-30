@extends('layouts.layout')


@section('header')
    @include('layouts.navbar')
@endsection

@section('content')
    <!--MAIN SECTION-->
    <div class="container-fluid dm-homepage">
        <div class="row dm-homepage-content">
            <div class="col-lg-12">
                <img src="pics/dm-icon.png" class="medium-logo">
                <p class="p-jumbotron">
                    DocManager is a modern effective app that helps you organize your documents.
                </p>
                <p class="p-jumbotron">
                    Equipped with a powerful search engine, DocManager is the perfect tool
                    to classify your documents.
                </p>

            </div>
        </div>
    </div>

    <!--SUB SECTION-->
    <div class="container-fluid">

    </div>
@endsection

@section('footer')
    @include('layouts.footer')
@endsection