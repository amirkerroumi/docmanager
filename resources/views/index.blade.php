@extends('layouts.layout')



@section('content')

@include('layouts.navbar')

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

<!--FOOTER-->
<footer class="footer">
    <div class="container">
        <div class="row">
            <div class="col-xs-4 footer-left">
                <img src="pics/dm-icon.png" class="small-logo">
            </div>
            <div class="col-xs-4 footer-center">
                About | Contact | Home
            </div>
            <div class="col-xs-4 footer-right">
                &copy;2017 DocManager, Inc.
            </div>
        </div>
    </div>
</footer>
@endsection