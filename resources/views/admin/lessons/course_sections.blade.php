@extends('admin.layouts.admin-master')
@section('title', $course->title)
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
        .course_section{padding:1px 15px; border-radius: 5px;  background: #fff; margin-bottom: 10px; list-style: none;}
        .action_btn{ margin-top: 5px;}
        .deactive_course{background-color: #e8dada9c;}
        .panel-title>a, .panel-title>a:active{ display:block;padding:12px 0;color:#555;font-size:14px;font-weight:bold;}
        .panel-heading a:after { padding-right: 7px !important;  font-family: 'Font Awesome 5 Free';  content: "\f107"; float: left; }
        .panel-heading.active a:after { padding-left: 7px !important;  -webkit-transform: rotate(180deg); -moz-transform: rotate(180deg); transform: rotate(180deg); padding-right: 0px !important; } 

    </style>

@endsection
@section('content')
        <?php 

            $all_courses = $pending_course = $active_courses = $deactive_courses = $free_course = $paid_course = 0;
            
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
                        <h4 class="text-themecolor">Lessons Management</h4>
                    </div>
                    <div class="col-md-7 align-self-center text-right">
                        <div class="d-flex justify-content-end align-items-center">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="javascript:void(0)">Course</a></li>
                                <li class="breadcrumb-item active">list</li>
                            </ol>
                            
                           <button data-toggle="modal" data-target="#addSectionModal" class="btn btn-sm btn-info d-none d-lg-block m-l-15"><i class="fa fa-plus-circle"></i> Add New Section</button>
                           <a href="{{ route('admin.course.list') }}" class="btn btn-sm btn-primary d-none d-lg-block m-l-15"><i class="fa fa-eye"></i> Course List</a>
                        </div>
                    </div>
                </div>
                <!-- ============================================================== -->
                <!-- End Bread crumb and right sidebar toggle -->
                
                <div class="row">
                    <!-- Column -->
                    <div class="col-md-3 col-6">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Total Section</h5>
                            <div class="d-flex no-block align-items-center">
                                <span class="display-5 text-primary"><i class="fa fa-list-ol"></i></span>
                                <a href="{{route('admin.course.list')}}" class="link display-5 ml-auto">{{count($course_sections)}}</a>
                            </div>
                        </div>
                    </div>
                    </div>
                    <!-- Column -->
                    <div class="col-md-3 col-6">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Total Lesson</h5>
                            <div class="d-flex no-block align-items-center">
                                <span class="display-5 text-success"><i class="fa fa-thumbs-up"></i></span>
                                <a href="{{route('admin.course.list', 'active')}}" class="link display-5 ml-auto">{{$total_lesson}}</a>
                            </div>
                        </div>
                    </div>
                    </div>
                    <!-- Column -->
                    <div class="col-md-3 col-6">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Deactive Section</h5>
                            <div class="d-flex no-block align-items-center">
                                <span class="display-5 text-warning"><i class="fa fa-thumbs-down"></i></span>
                                <a href="{{route('admin.course.list', 'deactive')}}" class="link display-5 ml-auto">{{$deactive_sections}}</a>
                            </div>
                        </div>
                    </div>
                    </div>

                    <!-- Column -->
                    <div class="col-md-3 col-6">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Deactive Lesson</h5>
                            <div class="d-flex no-block align-items-center">
                                <span class="display-5 text-danger"><i class="fa fa-strikethrough"></i></span>
                                <a href="{{route('admin.course.list', 'free')}}" class="link display-5 ml-auto">{{$deactive_lesson}}</a>
                            </div>
                        </div>
                    </div>
                    </div>
                </div>

                <!-- Start Page Content -->
                <div class="row justify-content-md-center">
                    <!-- Column -->
                    @if(count($course_sections)>0)
                    <div class="col-md-10 col-12">
                        <div class="table-responsive" >
                            <div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
                                <ul id="sectionSositionSorting" data-table="course_sections" style="padding: 0">
                              
                                @foreach($course_sections as $secIndex => $section)
                                <li id="itemsection{{$section->id}}" class="course_section @if($section->status == 0) deactive_course @endif"  @if($section->status == 0) title="Deactive this section" @endif>
                                    <div class="panel panel-default">
                                        <div class="row panel-heading @if($secIndex == 0) active @endif" role="tab" >
                                            <div class="col-md-8  col-12">
                                              <h4 class="panel-title">
                                                <a role="button" data-toggle="collapse" data-parent="#accordion" href="#courseSection{{ $section->id }}" aria-expanded="true" aria-controls="courseSection{{ $section->id }}"> {{$secIndex+1}}. {{$section->section_title}}
                                                </a>
                                              </h4>
                                            </div>
                                            <div class="col-md-4 col-12">
                                            <div class="action_btn">
                                                <button onclick="addLesson({{$section->id}})" title="Add Lesson" class="btn btn-success btn-sm"> <i class="ti-plus"></i> Add New Lesson</button>
                                                <button onclick="sectionEdit({{$section->id}})" title="Edit Section" class="btn btn-info btn-sm"> <i class="ti-pencil-alt"></i> Edit</button>
                                                <button title="Delete Section"  data-target="#delete" onclick='deleteConfirmPopup("{{route("admin.course.section.delete", $section->id)}}", "section")'  data-toggle="modal" class="btn btn-danger btn-sm"> <i class="ti-trash"></i> Delete</button>
                                            </div>
                                            </div>
                                        </div>
                                        <div id="courseSection{{ $section->id }}" class="panel-collapse collapse @if($secIndex == 0) in @endif" role="tabpanel">
                                            <div class="panel-body">
                                                <table class="table table-striped" >
                                                    <thead>
                                                        <tr>
                                                            <th>#</th>
                                                            <th>Lesson Title</th>
                                                            <th>Type</th>
                                                            <th>Duration</th>
                                                            <th>Date</th>
                                                            <th>Free_lesson</th>
                                                            <th>Status</th>
                                                            <th>Actions</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @if(count($section->courseLessons)>0)
                                                            @foreach($section->courseLessons as $index => $lesson)
                                                            <tr id="item{{$lesson->id}}">
                                                                <td>{{ $index+1 }}</td>
                                                                <td>{{Str::limit($lesson->lesson_title, 40)}}</td>
                                                                
                                                                <td>{{$lesson->content_type}}</td>
                                                                <td>{{$lesson->duration}}</td>
                                                                <td>{{Carbon\Carbon::parse($lesson->created_at)->format(Config::get('siteSetting.date_format'))}}</td>
                                                               
                                                                <td>
                                                                    <div class="custom-control custom-switch">
                                                                      <input name="status" onclick="satusActiveDeactive('course_lessons', '{{$lesson->id}}','free_lesson')"  type="checkbox" {{($lesson->free_lesson == 1 ) ? 'checked' : ''}}  type="checkbox" class="custom-control-input" id="visiblestatus{{$lesson->id}}">
                                                                      <label style="padding: 5px 12px" class="custom-control-label" for="visiblestatus{{$lesson->id}}"></label>
                                                                    </div>
                                                                   
                                                                </td>
                                                                <td>
                                                                   
                                                                    <div class="custom-control custom-switch">
                                                                      <input  name="status" onclick="satusActiveDeactive('course_lessons', {{$lesson->id}})"  type="checkbox" {{($lesson->status == 'active') ? 'checked' : ''}}  type="checkbox" class="custom-control-input" id="lessonstatus{{$lesson->id}}">
                                                                      <label style="padding: 5px 12px" class="custom-control-label" for="lessonstatus{{$lesson->id}}"></label>
                                                                    </div>
                                                                   
                                                                </td>
                                                                
                                                                <td>
                                                                <button class="btn btn-info btn-sm" onclick="lessonEdit({{$lesson->id}})" class="btn btn-success btn-sm" type="button" title="Edit lesson" href="{{ route('admin.course.edit', $lesson->slug) }}"><i class="ti-pencil-alt"></i></button>
                                                                
                                                                <button title="Delete lesson" class="btn btn-danger btn-sm" data-target="#delete" onclick="deleteConfirmPopup('{{route("admin.course.lesson.delete", $lesson->id)}}')" data-toggle="modal"><i class="ti-trash"></i></button>                                          
                                                                </td>
                                                            </tr>
                                                            @endforeach
                                                        @else <tr><td>No Lessons Found.</td></tr>@endif
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </li>
                                @endforeach
                               
                                </ul>
                            </div>
                        </div>
                            
                    </div>
                    @else
                    <div class="col-md-12">
                    <h3 style="text-align: center;padding: 10px;" class="course_section">This course have no lesson.<br/> <button data-toggle="modal" data-target="#addSectionModal" class="btn btn-info btn-sm"><i class="fa fa-plus-circle"></i> Add New Lesson</button></h3>
                    </div>
                    @endif
                    <!-- Column -->
                </div>            
            </div>
            <!-- ============================================================== -->
            <!-- End Container fluid  -->
            <!-- ============================================================== -->
        </div>
        <!-- ============================================================== -->
        <!-- End Page wrapper  -->
      
        <!-- add Modal -->
        <div class="modal fade" id="addSectionModal" style="display: none;">
            <div class="modal-dialog">
                <!-- Modal content-->
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">Add Section</h4>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>
                    <div class="modal-body form-row">
                        <form action="{{route('admin.course.section.store', $course->id)}}" method="post" >
                            {{csrf_field()}}
                            <div class="form-body">
                                <!--/row-->
                                <div class="row justify-content-md-center">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="section_title">Section Name</label>
                                            <input placeholder="Write section name" name="section_title" id="section_title" value="{{old('section_title')}}" required="" type="text" class="form-control">
                                        </div>
                                    </div>
                                 
                                   <div class="col-md-12">
                                        <div class="form-group">
                                            <label style="background: #fff;top:-10px;z-index: 1" for="summery">Summery</label>
                                            <textarea name="summery" class="form-control" placeholder="Enter summery" id="summery" rows="2">{{old('summery')}}</textarea>
                                        </div>
                                    </div>
                               
                                    <div class="col-md-12">
                                        <div class="head-label">
                                            <label class="switch-box">Status</label>
                                            <div  class="status-btn" >
                                                <div class="custom-control custom-switch">
                                                    <input name="status" checked  type="checkbox" class="custom-control-input" {{ (old('status') == 'on') ? 'checked' : '' }} id="sectionstatus">
                                                    <label  class="custom-control-label" for="sectionstatus">Publish/UnPublish</label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="submit" name="submit" value="add" class="btn btn-success"> <i class="fa fa-check"></i> Add Section</button>
                                            <button type="button" data-dismiss="modal" class="btn btn-inverse">Cancel</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- Section edit modal -->
        <div class="modal fade" id="sectionEdit" style="display: none;">
            <div class="modal-dialog">
                <form action="{{route('admin.course.section.update')}}" enctype="multipart/form-data" method="post">
                {{ csrf_field() }}
                <!-- Modal content-->
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">Edit Section</h4>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>
                    <div class="modal-body form-row" id="section_edit_form"></div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-sm btn-success">Update</button>
                    </div>
                </div>
                </form>
            </div>
        </div>

        <div class="modal fade" id="addLessonModal"  style="display: none;">
            <div class="modal-dialog">

                <!-- Modal content-->
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">Add Lesson</h4>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>
                    <div class="modal-body form-row">
                        
                        <form action="{{route('admin.course.lesson.store')}}" enctype="multipart/form-data" method="post">
                            {{csrf_field()}}
                            <input type="hidden" name="course_id" value="{{$course->id}}">
                            <input type="hidden" name="section_id" id="section_id" value="">
                            <div class="form-body">
                                <!--/row-->
                                <div class="row justify-content-md-center">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label class="required" for="lesson_title">Lesson name</label>
                                            <input placeholder="Write lesson name" name="lesson_title" id="lesson_title" value="{{old('lesson_title')}}" required="" type="text" class="form-control">
                                        </div>
                                    </div>
                                
                                    <div class="col-md-12">
                                        <label for="course_video">Content type</label>
                                        <div class="form-group">
                                            <select onchange="lessonType(this.value)" name="content_type" id="content_type" class="form-control custom-select">
                                            <option value="">Select Content</option>
                                            <option value="video">Video Upload</option>
                                            <option value="youtube">Youtube</option>
                                            <option value="vimeo">Vimeo</option>
                                            <option value="audio">Audio</option>
                                            <option value="document">Document</option>
                                            <option value="text">Text</option>
                                            <option value="image">Image file</option>
                                            <option value="custom">Custom type</option>
                                        </select>
                                        <div id="content_type_field"></div>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label style="background: #fff;top:-10px;z-index: 1" for="description">Description</label>
                                            <textarea name="description" class="form-control" placeholder="Enter description" id="description" rows="2">{{old('description')}}</textarea>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="duration">Duration</label>
                                            <input type="text" value="{{old('duration')}}"  name="duration" id="duration" placeholder = 'Enter duration' class="form-control" >
                                        </div>
                                    </div>

                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="free_lesson">
                                            <input type="checkbox" name="free_lesson" id="free_lesson" >  Is free lesson <i class=" ti-eye"></i></label>
                                        </div>
                                    </div>

                               
                                    <div class="col-md-12">
                                        <div class="head-label">
                                            <label class="switch-box">Status</label>
                                            <div  class="status-btn" >
                                                <div class="custom-control custom-switch">
                                                    <input name="status" checked  type="checkbox" class="custom-control-input" {{ (old('status') == 'on') ? 'checked' : '' }} id="lessonStatus">
                                                    <label  class="custom-control-label" for="lessonStatus">Publish/UnPublish</label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="submit" name="submit" value="add" class="btn btn-success"> <i class="fa fa-check"></i> Add Lesson</button>
                                            <button type="button" data-dismiss="modal" class="btn btn-inverse">Cancel</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                    
                    </div>
                </div>
            </div>
        </div>
        
         <!-- lesson edit modal -->
        <div class="modal fade" id="lessonEdit" style="display: none;">
            <div class="modal-dialog">
                <form action="{{route('admin.course.lesson.update')}}" enctype="multipart/form-data" method="post">
                {{ csrf_field() }}
                <!-- Modal content-->
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">Edit Lesson</h4>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>
                    <div class="modal-body form-row" id="lesson_edit_form"></div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-sm btn-success">Update</button>
                    </div>
                </div>
                </form>
            </div>
        </div>
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

        function sectionEdit(id){
            $('#sectionEdit').modal('show');
            $('#section_edit_form').html('<div class="loadingData"></div>');
            var  url = '{{route("admin.course.section.edit", ":id")}}';
            url = url.replace(':id',id);
            $.ajax({
                url:url,
                method:"get",
                success:function(data){
                    if(data){
                        $("#section_edit_form").html(data);
                    }
                },
                // $ID Error display id name
                @include('common.ajaxError', ['ID' => 'section_edit_form'])
            });
        }         

        function lessonEdit(id){
            $('#lessonEdit').modal('show');
            $('#lesson_edit_form').html('<div class="loadingData"></div>');
            var  url = '{{route("admin.course.lesson.edit", ":id")}}';
            url = url.replace(':id',id);
            $.ajax({
                url:url,
                method:"get",
                success:function(data){
                    if(data){
                        $("#lesson_edit_form").html(data);
                    }
                },
                // $ID Error display id name
                @include('common.ajaxError', ['ID' => 'lesson_edit_form'])
            });
        } 

    </script>
    <script type="text/javascript">
        $(".select2").select2();

    function addLesson(section_id){
        $('#addLessonModal').modal('show');
        $("#section_id").val(section_id);
    }

    //section sorting
    $(document).ready(function(){
        $( "#sectionSositionSorting" ).sortable({
            placeholder : "ui-state-highlight",
            update  : function(event, ui)
            {
                var ids = new Array();
                $('#sectionSositionSorting li').each(function(){
                    var id = $(this).attr("id");
                    id = id.replace('section','item');
                    ids.push(id);
                });
                var table = $(this).attr('data-table');

                $.ajax({
                    url:"{{route('positionSorting')}}",
                    method:"get",
                    data:{ids:ids,table:table},
                    success:function(data){
                        toastr.success(data)
                    }
                });
            }
        });
    });
    

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

    <script type="text/javascript">

    //video provider field
    function lessonType(provider, field=''){
    
        var output = '';
        if(provider){
            output = '<span class="required">Attach '+provider+' file</span><div class="custom-file"> <input class="form-control" type="file" name="content"></div>';
            
            if(provider == 'youtube' || provider == 'vimeo' || provider == 'custom'){
                output = '<span class="required"> '+provider+' link</span><input class="form-control" required name="content_link" id="content" placeholder="Enter '+provider+' link" type="text">';
            }
            if(provider == 'text'){
                output = '';
            }
        }
       
        $('#content_type_field'+field).html(output);
    }

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

    <script type="text/javascript">
         $('.panel-collapse').on('show.bs.collapse', function () {
    $(this).siblings('.panel-heading').addClass('active');
  });

  $('.panel-collapse').on('hide.bs.collapse', function () {
    $(this).siblings('.panel-heading').removeClass('active');
  });
    </script>
@endsection
