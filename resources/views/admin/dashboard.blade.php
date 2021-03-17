@extends('admin.layouts.admin-master')
@section('title', 'Dashboard')
@section('css')
    <link href="{{ asset('assets/node_modules') }}/morrisjs/morris.css" rel="stylesheet">
    <!--Toaster Popup message CSS -->

    <link href="{{ asset('css') }}/pages/dashboard1.css" rel="stylesheet">
    <style type="text/css">.round{font-size:25px;}    .display-5{font-size: 2rem !important;}</style>
@endsection
@section('content')
    <!-- ============================================================== -->
    <!-- Main wrapper - style you can find in pages.scss -->
    <!-- ============================================================== -->
    <div id="main-wrapper">
      <!-- Page wrapper  -->
        <!-- ============================================================== -->
        <div class="page-wrapper">
            <!-- ============================================================== -->
            <!-- Container fluid  -->
            <!-- ============================================================== -->
            <div class="container-fluid dashboard1"><br/>
                <div class="row">
                    
                    <!-- Column -->
                    <div class="col-md-3">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Total Course</h5>
                            <div class="d-flex  no-block align-items-center">
                                <span class="display-5 text-purple"><i class="fa fa-book"></i></span>
                                <a href="{{route('admin.course.list')}}" class="link display-5 ml-auto">{{$Course}}</a>
                            </div>
                        </div>
                    </div>
                    </div>
                    <div class="col-md-3">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Total Lessons</h5>
                            <div class="d-flex  no-block align-items-center">
                                <span class="display-5 text-info"><i class="fa fa-file-video"></i></span>
                                <a href="{{route('admin.course.list')}}" class="link display-5 ml-auto">{{$CourseLesson}}</a>
                            </div>
                        </div>
                    </div>
                    </div>

                    <div class="col-md-3">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Enrolled</h5>
                            <div class="d-flex  no-block align-items-center">
                                <span class="display-5 text-success"><i class="fa fa-street-view"></i></span>
                                <a href="{{route('admin.orderList')}}" class="link display-5 ml-auto">{{$Order}}</a>
                            </div>
                        </div>
                    </div>
                    </div>

                    <div class="col-md-3">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Total Student</h5>
                            <div class="d-flex  no-block align-items-center">
                                <span class="display-5 text-danger"><i class="fa fa-users"></i></span>
                                <a href="{{route('student.list')}}" class="link display-5 ml-auto">{{$AllStudent}}</a>
                            </div>
                        </div>
                    </div>
                    </div>
                </div>
               
                <div class="row">
                    <!-- Column -->
                    <div class="col-lg-3 col-md-6">
                        <div class="card">
                            <div class="d-flex flex-row">
                                <div class="p-10 bg-info">
                                    <h3 class="text-white box m-b-0"><i class="fa  fa-boxes"></i></h3></div>
                                <div class="align-self-center m-l-20">
                                    <h3 class="m-b-0 text-info">{{$AllClass}}</h3>
                                    <h5 class="text-muted m-b-0">Total Class</h5></div>
                            </div>
                        </div>
                    </div>
                    <!-- Column -->
                    <!-- Column -->
                    <div class="col-lg-3 col-md-6">
                        <div class="card">
                            <div class="d-flex flex-row">
                                <div class="p-10 bg-success">
                                    <h3 class="text-white box m-b-0"><i class="fa fa-book"></i></h3></div>
                                <div class="align-self-center m-l-20">
                                    <h3 class="m-b-0 text-success">{{$Subject}}</h3>
                                    <h5 class="text-muted m-b-0">Total Subject</h5></div>
                            </div>
                        </div>
                    </div>
                    <!-- Column -->
                    <!-- Column -->
                    <div class="col-lg-3 col-md-6">
                        <div class="card">
                            <div class="d-flex flex-row">
                                <div class="p-10 bg-inverse">
                                    <h3 class="text-white box m-b-0"><i class="ti-wallet"></i></h3></div>
                                <div class="align-self-center m-l-20">
                                    <h3 class="m-b-0">{{$Category}}</h3>
                                    <h5 class="text-muted m-b-0">Total Category</h5></div>
                            </div>
                        </div>
                    </div>
                    <!-- Column -->
                    <!-- Column -->
                    <div class="col-lg-3 col-md-6">
                        <div class="card">
                            <div class="d-flex flex-row">
                                <div class="p-10 bg-primary">
                                    <h3 class="text-white box m-b-0"><i class="fa fa-comment-dots"></i></h3></div>
                                <div class="align-self-center m-l-20">
                                    <h3 class="m-b-0 text-primary">0</h3>
                                    <h5 class="text-muted m-b-0">Message</h5></div>
                            </div>
                        </div>
                    </div>
                    <!-- Column -->
                </div>
                
                <div class="row">
                    <div class="col-md-6">
                        <div class="card">
                            <div class="card-body">
                                <h5 class="card-title">Popular Courses</h5>
                                <div class="table-responsive">
                                    <table class="table course-overview">
                                        <thead>
                                            <tr>
                                                <th>Course</th>
                                                <th>Lesson</th>
                                                <th>Price</th>
                                                <th>#</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @if(count($popularCourse)>0)
                                            @foreach($popularCourse as $course)
                                            <tr>
                                                <td><a target="_blank" href="{{ route('course_details', $course->slug) }}"> <img src="{{asset('upload/images/course/'.$course->thumbnail_image)}}" alt="Image" width="42"> {{Str::limit($course->title, 30)}}</a> </td>
                                                 <td>{{count($course->course_lessons)}}</td>
                                                <td>{{Config::get('siteSetting.currency_symble')}}{{$course->price}}</td>
                                                 <td><a  href="{{ route('course_details', $course->slug) }}" class="text-inverse p-r-10"><i class="ti-eye"></i></a> </td>
                                            </tr>
                                           @endforeach
                                        @else <tr><td colspan="8"> <h1>No courses found.</h1></td></tr> @endif
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="card">
                            <div class="card-body">
                                <h5 class="card-title">Recent Enrolled</h5>
                                <div class="table-responsive ">
                                    <table class="table course-overview">
                                        <thead>
                                            <tr>
                                                <th>Student</th>
                                                <th>Qty</th>
                                                <th>Price</th>
                                                <th>Status</th>
                                                <th>#</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            
                                             @if(count($recentOrders)>0)
                                                @foreach($recentOrders as $order)
                                                <tr>
                                                    <td>#{{$order->order_id}}<br/>{{\Carbon\Carbon::parse($order->created_at)->format(Config::get('siteSetting.date_format'))}}
                                                    
                                                   </td>
                                                   <td>{{ $order->total_qty }}</td>
                                                    <td>{{$order->currency_sign . ($order->total_price)  }}</td>

                                                    <td> 
                                                        @if($order->shipping_status == 'delivered')
                                                        <span class="label label-success"> {{ str_replace('-', ' ', $order->shipping_status)}} </span>@elseif($order->shipping_status == 'accepted')
                                                        <span class="label label-warning"> {{ str_replace('-', ' ', $order->shipping_status)}} </span>
                                                        @elseif($order->shipping_status == 'cancel')
                                                        <span class="label label-danger"> {{ str_replace('-', ' ', $order->shipping_status)}} </span>
                                                        @elseif($order->shipping_status == 'ready-to-ship')
                                                        <span class="label label-primary"> {{ str_replace('-', ' ', $order->shipping_status)}} </span>
                                                        @else
                                                        <span class="label label-info"> Pending </span>
                                                        @endif
                                                    </td>
                                                    <td> <a target="_blank" href="{{route('admin.orderInvoice', $order->order_id)}}" class="text-inverse" title="View Order Invoice" data-toggle="tooltip"><i class="ti-eye"></i></a></td>

                                                </tr>
                                               @endforeach
                                            @else <tr><td colspan="8"> <h1>No orders found.</h1></td></tr> @endif
                            
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div> 
            
            </div>
            <!-- ============================================================== -->
            <!-- End Container fluid  -->
            <!-- ============================================================== -->
        </div>
        <!-- ============================================================== -->
        <!-- End Page wrapper  -->
       
    </div>
    <!-- ============================================================== -->
    <!-- End Wrapper -->
@endsection
@section('js')
    <!-- ============================================================== -->
    <!-- This page plugins -->
    <!-- ============================================================== -->
    <!--morris JavaScript -->
    <script src="{{ asset('assets/node_modules') }}/raphael/raphael-min.js"></script>
    <script src="{{ asset('assets/node_modules') }}/morrisjs/morris.min.js"></script>
    <script src="{{ asset('assets/node_modules') }}/jquery-sparkline/jquery.sparkline.min.js"></script>
    <!-- Popup message jquery -->
    <script src="{{ asset('assets/node_modules') }}/toast-master/js/jquery.toast.js"></script>
    <!-- Chart JS -->
    <script src="{{ asset('js') }}/dashboard1.js"></script>
   
@endsection