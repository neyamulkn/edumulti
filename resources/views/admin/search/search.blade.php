@extends('admin.layouts.admin-master')
@section('title', 'Search Results')
@section('css')
    <link rel="stylesheet" type="text/css" href="{{asset('css/pages/other-pages.css')}}">

@endsection
@section('content')
     <div class="page-wrapper">
            <!-- ============================================================== -->
            <!-- Container fluid  -->
            <!-- ============================================================== -->
            <div class="container-fluid">
                <!-- ============================================================== -->
                <!-- Bread crumb and right sidebar toggle -->
                <!-- ============================================================== -->
                <div class="row page-titles">
                    <div class="col-md-5 align-self-center">
                        <h4 class="text-themecolor">Search Results</h4>
                    </div>
                    <div class="col-md-7 align-self-center text-right">
                        <div class="d-flex justify-content-end align-items-center">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                                <li class="breadcrumb-item active">Search Results</li>
                            </ol>
                            <a href="{{url()->previous()}}" class="btn btn-info btn-sm d-none d-lg-block m-l-15"><i class="fa fa-plus-circle"></i> Back</a>
                        </div>
                    </div>
                </div>
                <!-- ============================================================== -->
                <!-- End Bread crumb and right sidebar toggle -->
                <!-- ============================================================== -->
                <!-- ============================================================== -->
                <!-- Start Page Content -->
                <!-- ============================================================== -->
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body">
                                <h4 class="card-title">Search Result For "{{Request::get('q')}}"</h4>
                                <h6 class="card-subtitle">About 10 result </h6>
                                <ul class="search-listing">
                                    <li>
                                        <h3><a href="javacript:void(0)">AngularJs</a></h3>
                                        <a href="javascript:void(0)" class="search-links">http://www.google.com/angularjs</a>
                                        <p>Lorem Ipsum viveremus probamus opus apeirian haec perveniri, memoriter.Praebeat pecunias viveremus probamus opus apeirian haec perveniri, memoriter.</p>
                                    </li>
                                    <li>
                                        <h3><a href="javacript:void(0)">AngularJS — Superheroic JavaScript MVW Framework</a></h3>
                                        <a href="javascript:void(0)" class="search-links">http://www.google.com/angularjs</a>
                                        <p>Lorem Ipsum viveremus probamus opus apeirian haec perveniri, memoriter.Praebeat pecunias viveremus probamus opus apeirian haec perveniri, memoriter.</p>
                                    </li>
                                    <li>
                                        <h3><a href="javacript:void(0)">AngularJS Tutorial - W3Schools</a></h3>
                                        <a href="javascript:void(0)" class="search-links">http://www.google.com/angularjs</a>
                                        <p>Lorem Ipsum viveremus probamus opus apeirian haec perveniri, memoriter.Praebeat pecunias viveremus probamus opus apeirian haec perveniri, memoriter.</p>
                                    </li>
                                    <li>
                                        <h3><a href="javacript:void(0)">Introduction to AngularJS - W3Schools</a></h3>
                                        <a href="javascript:void(0)" class="search-links">http://www.google.com/angularjs</a>
                                        <p>Lorem Ipsum viveremus probamus opus apeirian haec perveniri, memoriter.Praebeat pecunias viveremus probamus opus apeirian haec perveniri, memoriter.</p>
                                    </li>
                                    <li>
                                        <h3><a href="javacript:void(0)">AngularJS Tutorial</a></h3>
                                        <a href="javascript:void(0)" class="search-links">http://www.google.com/angularjs</a>
                                        <p>Lorem Ipsum viveremus probamus opus apeirian haec perveniri, memoriter.Praebeat pecunias viveremus probamus opus apeirian haec perveniri, memoriter.</p>
                                    </li>
                                    <li>
                                        <h3><a href="javacript:void(0)">Angular 2: One framework.</a></h3>
                                        <a href="javascript:void(0)" class="search-links">http://www.google.com/angularjs</a>
                                        <p>Lorem Ipsum viveremus probamus opus apeirian haec perveniri, memoriter.Praebeat pecunias viveremus probamus opus apeirian haec perveniri, memoriter.</p>
                                    </li>
                                </ul>
                                <nav aria-label="Page navigation example" class="m-t-40">
                                    <ul class="pagination">
                                        <li class="page-item disabled">
                                            <a class="page-link" href="javascript:void(0)" tabindex="-1">Previous</a>
                                        </li>
                                        <li class="page-item"><a class="page-link" href="javascript:void(0)">1</a></li>
                                        <li class="page-item"><a class="page-link" href="javascript:void(0)">2</a></li>
                                        <li class="page-item"><a class="page-link" href="javascript:void(0)">3</a></li>
                                        <li class="page-item">
                                            <a class="page-link" href="javascript:void(0)">Next</a>
                                        </li>
                                    </ul>
                                </nav>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- ============================================================== -->
                <!-- End PAge Content -->
                <!-- ============================================================== -->
                <!-- ============================================================== -->
            
                <!-- ============================================================== -->
            </div>
            <!-- ============================================================== -->
            <!-- End Container fluid  -->
            <!-- ============================================================== -->
        </div>
@endsection

