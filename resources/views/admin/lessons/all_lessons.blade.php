@extends('admin.layouts.admin-master')
@section('title', 'Course list')
@section('css-top')
    <link href="{{asset('assets')}}/node_modules/select2/dist/css/select2.min.css" rel="stylesheet" type="text/css" />
@endsection
@section('css')

    <link href="{{asset('assets')}}/node_modules/dropify/dist/css/dropify.min.css" rel="stylesheet" type="text/css" />
    <link href="{{asset('assets')}}/node_modules/bootstrap-switch/bootstrap-switch.min.css" rel="stylesheet">
    <link href="{{asset('css')}}/pages/bootstrap-switch.css" rel="stylesheet">

    <style type="text/css">
        .dropify_image{
            position: absolute;top: -12px!important;left: 12px !important; z-index: 9; background:#fff!important;padding: 3px;
        }
        .dropify-wrapper{
            height: 100px !important;
        }
        svg{width: 20px}
     
    </style>

@endsection
@section('content')
        <?php 
            $all_courses = $pending_course = $active_courses = $deactive_courses = $free_course = $paid_course = 0;
            foreach($courseCount as $status){

                if($status->status == 'active'){ $active_courses +=1 ; }
                if($status->status == 'deactive'){ $deactive_courses +=1 ; }
                if($status->status == 'pending'){ $pending_course +=1 ; }
                if($status->price_type == 'free'){ $free_course +=1 ; }
                if($status->price_type == 'paid'){ $paid_course +=1 ; }
               
            }
            $all_courses = $pending_course+$active_courses+$deactive_courses;

        ?>
        <!-- Page wrapper  -->
        <!-- ============================================================== -->
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
                        <h4 class="text-themecolor">Course List</h4>
                    </div>
                    <div class="col-md-7 align-self-center text-right">
                        <div class="d-flex justify-content-end align-items-center">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="javascript:void(0)">Course</a></li>
                                <li class="breadcrumb-item active">list</li>
                            </ol>
                            <a class="btn btn-info d-none d-lg-block m-l-15" href="{{ route('admin.course.create') }}"><i
                                    class="fa fa-plus-circle"></i> Add New course</a>
                        </div>
                    </div>
                </div>
                <!-- ============================================================== -->
                <!-- End Bread crumb and right sidebar toggle -->
                
              
                <div class="row">
                    <!-- Column -->
                    <div class="col-md-2">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Total Course</h5>
                            <div class="d-flex no-block align-items-center">
                                <span class="display-5 text-primary"><i class="fa fa-list-ol"></i></span>
                                <a href="{{route('admin.course.list')}}" class="link display-5 ml-auto">{{$all_courses}}</a>
                            </div>
                        </div>
                    </div>
                    </div>
                    <!-- Column -->
                    <div class="col-md-2">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Active Course</h5>
                            <div class="d-flex no-block align-items-center">
                                <span class="display-5 text-success"><i class="fa fa-thumbs-up"></i></span>
                                <a href="{{route('admin.course.list', 'active')}}" class="link display-5 ml-auto">{{$active_courses}}</a>
                            </div>
                        </div>
                    </div>
                    </div>
                    <!-- Column -->
                    <div class="col-md-2">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Deactive</h5>
                            <div class="d-flex no-block align-items-center">
                                <span class="display-5 text-warning"><i class="fa fa-thumbs-down"></i></span>
                                <a href="{{route('admin.course.list', 'deactive')}}" class="link display-5 ml-auto">{{$deactive_courses}}</a>
                            </div>
                        </div>
                    </div>
                    </div>

                    <!-- Column -->
                    <div class="col-md-2">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Pending Course</h5>
                            <div class="d-flex no-block align-items-center">
                                <span class="display-5 text-info"><i class="fa fa-hourglass"></i></span>
                                <a href="{{route('admin.course.list', 'pending')}}" class="link display-5 ml-auto">{{ $pending_course }}</a>
                            </div>
                        </div>
                    </div>
                    </div>
                  
                    <!-- Column -->
                    <div class="col-md-2">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Free Course</h5>
                            <div class="d-flex no-block align-items-center">
                                <span class="display-5 text-danger"><i class="fa fa-strikethrough"></i></span>
                                <a href="{{route('admin.course.list', 'free')}}" class="link display-5 ml-auto">{{$free_course}}</a>
                            </div>
                        </div>
                    </div>
                    </div>
                    <!-- Column -->
                    <div class="col-md-2">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Paid Course</h5>
                            <div class="d-flex no-block align-items-center">
                                <span class="display-5 text-success"><i class="fa fa-bug"></i></span>
                                <a href="{{route('admin.course.list', 'paid')}}" class="link display-5 ml-auto">{{$paid_course}}</a>
                            </div>
                        </div>
                    </div>
                    </div>
                    
                </div>
                <div class="row">
                    <div class="col-lg-12">
                        <div class="card" style="margin-bottom: 2px;">

                            <form action="{{route('admin.course.list')}}" method="get">

                                <div class="form-body">
                                    <div class="card-body">
                                        <div class="row">
                                            
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <input name="title" placeholder="Title" value="{{ Request::get('title')}}" type="text" class="form-control">
                                                </div>
                                            </div>
                                            
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <select name="category" required id="category" style="width:100%" id="category"  class="select2 form-control custom-select">
                                                       <option value="all">Category</option>
                                                       @foreach($categories as $category)
                                                       <option @if(Request::get('category') == $category->id) selected @endif value="{{$category->id}}">{{$category->name}}</option>
                                                       @endforeach
                                                   </select>
                                               </div>
                                            </div>

                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    
                                                    <select name="status" class="form-control">
                                                        <option value="all" {{ (Request::get('status') == "all") ? 'selected' : ''}}>All Status</option>
                                                        <option value="pending" {{ (Request::get('status') == 'pending') ? 'selected' : ''}} >Pending</option>
                                                        <option value="active" {{ (Request::get('status') == 'active') ? 'selected' : ''}}>Active</option>
                                                        <option value="inactive" {{ (Request::get('status') == 'inactive') ? 'selected' : ''}}>Deactive</option>
                                                        
                                                    </select>
                                                </div>
                                            </div>

                                            <div class="col-md-2">
                                                <div class="form-group">
                                                   <button type="submit" style="color:#fff;" class="form-control btn btn-success"><i  class="ti-search"></i> Find Course </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                <!-- Start Page Content -->
                <div class="row">
                    <!-- Column -->
                    <div class="col-lg-12">
 
                        <div class="card">
                            <div class="card-body">
                                <div class="table-responsive" >
                                    <table  class="table table-striped" >
                                        <thead>
                                            <tr>
                                                
                                                <th>Title</th>
                                                <th>Category</th>
                                                <th>Lesson</th>
                                                <th>Price</th>
                                                <th>Enrolled Student </th>
                                                <th>Reviews</th>
                                                <th>Date</th>
                                                <th>Status</th>
                                                <th>Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @if(count($courses)>0)
                                                @foreach($courses as $course)
                                                <tr id="item{{$course->id}}">
                                                    <td> <img src="{{asset('upload/images/course/'.$course->thumbnail_image)}}" alt="Image" width="50"><a target="_blank" href="{{ route('course_details', $course->slug) }}"> {{Str::limit($course->title, 40)}}</a></td>
                                                    <td>@if($course->get_category)
                                                            {{$course->get_category->name}}
                                                        @endif
                                                    </td>
                                                    <td>0</td>
                                                   
                                                    <td>{{Config::get('siteSetting.currency_symble')}}{{$course->price}}</td>
                                                    <td>0</td>
                                                    <td>0</td>
                                                   
                                                    <td>{{Carbon\Carbon::parse($course->created_at)->format(Config::get('siteSetting.date_format'))}}</td>
                                                    <td>
                                                       
                                                        <div class="custom-control custom-switch">
                                                          <input  name="status" onclick="satusActiveDeactive('courses', {{$course->id}})"  type="checkbox" {{($course->status == 1 || $course->status == 'active') ? 'checked' : ''}}  type="checkbox" class="custom-control-input" id="status{{$course->id}}">
                                                          <label style="padding: 5px 12px" class="custom-control-label" for="status{{$course->id}}"></label>
                                                        </div>
                                                       
                                                    </td>
                                                    
                                                    <td>
                                                    <div class="btn-group">
                                                        <button type="button" class="btn btn-info btn-sm dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                            <i class="ti-settings"></i>
                                                        </button>
                                                        <div class="dropdown-menu">
                                                            <a target="_blank" class="dropdown-item text-inverse" title="View course" data-toggle="tooltip" href="{{ route('course_details', $course->slug) }}"><i class="ti-eye"></i> View course</a>
                                                            <a class="dropdown-item" title="Edit course" data-toggle="tooltip" href="{{ route('admin.course.edit', $course->slug) }}"><i class="ti-pencil-alt"></i> Edit</a>
                                                            <span title="Highlight course (Ex. Best Seller, Top Rated etc.)" data-toggle="tooltip">
                                                            <a onclick="coursehighlight({{ $course->id }})" class="dropdown-item"  href="javascript:void(0)"><i class="ti-pin-alt"></i> Highlight</a></span>
                                                            <span title="Manage Gallery Images" data-toggle="tooltip">
                                                            <a onclick="setGallerryImage({{ $course->id }})" data-toggle="modal" data-target="#GallerryImage" class="dropdown-item" href="javascript:void(0)"><i class="ti-image"></i> Gallery Images</a></span>
                                                            <span title="Delete" data-toggle="tooltip"><button   data-target="#delete" onclick='deleteConfirmPopup("{{route("admin.course.delete", $course->id)}}")'  data-toggle="modal" class="dropdown-item" ><i class="ti-trash"></i> Delete course</button></span>
                                                        </div>
                                                    </div>                                                  
                                                    </td>
                                                </tr>
                                                @endforeach
                                            @else <tr><td>No courses Found.</td></tr>@endif
                                        </tbody>
                                    </table>
                                    
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Column -->
                </div>
                <div class="row">
                   <div class="col-sm-6 col-md-6 col-lg-6 text-center">
                       {{$courses->appends(request()->query())->links()}}
                      </div>
                    <div class="col-sm-6 col-md-6 col-lg-6 text-right">Showing {{ $courses->firstItem() }} to {{ $courses->lastItem() }} of total {{$courses->total()}} entries ({{$courses->lastPage()}} Pages)</div>
                </div>
            </div>
            <!-- ============================================================== -->
            <!-- End Container fluid  -->
            <!-- ============================================================== -->
        </div>
        <!-- ============================================================== -->
        <!-- End Page wrapper  -->
      
        <!-- HightLight Modal -->
        <!-- Gallery Modal -->
        <div class="modal fade" id="coursehighlight_modal" role="dialog"  tabindex="-1" aria-hidden="true" style="display: none;">
            <div class="modal-dialog">

                  <!-- Modal content-->
                  <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">Hightlight course</h4>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>
                    <div class="modal-body form-row">
                        <div class="card-body">
                            
                            <div class="form-body">
                               <div id="highlight_form"></div>
                               
                            </div>

                        </div>
                    </div>
                </div>
            </div>
          </div>
        @include('admin.modal.delete-modal')
@endsection
@section('js')
    <script src="{{asset('assets')}}/node_modules/select2/dist/js/select2.full.min.js" type="text/javascript"></script>

    <script type="text/javascript">
        $(".select2").select2();




    function coursehighlight(id){
        $('#highlight_form').html('<div class="loadingData"></div>');
        $('#coursehighlight_modal').modal('show');
        var  url = '{{route("course.highlight", ":id")}}';
        url = url.replace(':id',id);
        $.ajax({
            url:url,
            method:"get",
            success:function(data){
                if(data){
                    $("#highlight_form").html(data);
                }
            },
            // $ID = Error display id name
            @include('common.ajaxError', ['ID' => 'highlight_form'])

        });
    }

        //change status by id
        function highlightAddRemove(section_id, course_id){
            var  url = '{{route("highlightAddRemove")}}';
            $.ajax({
                url:url,
                method:"get",
                data:{section_id:section_id, course_id:course_id},
                success:function(data){
                    if(data.status){
                        toastr.success(data.msg);
                    }else{
                        toastr.error(data.msg);
                    }
                }
            });
        }

    </script>
   <script src="{{asset('assets')}}/node_modules/dropify/dist/js/dropify.min.js"></script>
     <script>
    $(document).ready(function() {
        // Basic
        $('.dropify').dropify();
    });
    </script>

        <!-- bt-switch -->
    <script src="{{asset('assets')}}/node_modules/bootstrap-switch/bootstrap-switch.min.js"></script>
    <script type="text/javascript">
    $(".bt-switch input[type='checkbox'], .bt-switch input[type='radio']").bootstrapSwitch();
    var radioswitch = function() {
        var bt = function() {
            $(".radio-switch").on("switch-change", function() {
                $(".radio-switch").bootstrapSwitch("toggleRadioState")
            }), $(".radio-switch").on("switch-change", function() {
                $(".radio-switch").bootstrapSwitch("toggleRadioStateAllowUncheck")
            }), $(".radio-switch").on("switch-change", function() {
                $(".radio-switch").bootstrapSwitch("toggleRadioStateAllowUncheck", !1)
            })
        };
        return {
            init: function() {
                bt()
            }
        }
    }();
    $(document).ready(function() {
        radioswitch.init()
    });
    </script>
@endsection
