@extends('admin.layouts.admin-master')
@section('title', 'Course Edit')

@section('css-top')
    <link href="{{asset('assets')}}/node_modules/select2/dist/css/select2.min.css" rel="stylesheet" type="text/css" />
@endsection

@section('css')
<link href="{{asset('assets')}}/node_modules/dropify/dist/css/dropify.min.css" rel="stylesheet" type="text/css" />
<link href="{{asset('assets')}}/node_modules/summernote/dist/summernote-bs4.css" rel="stylesheet" type="text/css" />
<link href="{{asset('assets')}}/node_modules/bootstrap-tagsinput/dist/bootstrap-tagsinput.css" rel="stylesheet" />
<style type="text/css">
    @media screen and (min-width: 640px) {
        .divrigth_border::after {
            content: '';
            width: 0;
            height: 100%;
            margin: -1px 0px;
            position: absolute;
            top: 0;
            left: 100%;
            margin-left: 0px;
            border-right: 3px solid #e5e8ec;
        }
    }
    .dropify_image{
            position: absolute;top: -14px!important;left: 12px !important; z-index: 9; background:#fff!important;padding: 3px;
        }
    .dropify-wrapper{
        height: 100px !important;
    }
    .bootstrap-tagsinput{
            width: 100% !important;
            padding: 5px;
        }
    .closeBtn{position: absolute;right: 0;bottom: 10px;}
   
    form span{font-size: 12px;}
    #main-wrapper{overflow: visible !important;}
    .shipping-method label{font-size: 13px; font-weight:500; margin-left: 15px; }
    #shipping-field{padding: 0 15px;margin-bottom: 10px; }

    .form-control{padding-left: 5px; overflow: hidden;}
</style>
@endsection

@section('content')

    <!-- Page wrapper  -->
    <!-- ============================================================== -->
    <div class="page-wrapper">
        <!-- ============================================================== -->
        <!-- Container fluid  -->
        <div class="container-fluid">
            <!-- ============================================================== -->
            <!-- Bread crumb and right sidebar toggle -->
            <!-- ============================================================== -->
            <div class="row page-titles">
                <div class="col-md-5 align-self-center">
                    <h4 class="text-themecolor">Add New course</h4>
                </div>
                <div class="col-md-7 align-self-center text-right">
                    <div class="d-flex justify-content-end align-items-center">
                        <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="javascript:void(0)">course</a></li>
                                <li class="breadcrumb-item active">Create</li>
                            </ol>
                        <a href="{{route('admin.course.list')}}" class="btn btn-info btn-sm d-none d-lg-block m-l-15"><i class="fa fa-plus-circle"></i> Course List</a>
                    </div>
                </div>
            </div>
            <!-- ============================================================== -->
            <!-- End Bread crumb and right sidebar toggle -->
            <!-- ============================================================== -->
            <!-- ============================================================== -->
            <!-- Start Page Content -->
            <!-- ============================================================== -->

            <div class="card">
                <div id="pageLoading"></div>
                <div class="card-body">

                    <form action="{{route('admin.course.update', $course->id)}}" data-parsley-validate enctype="multipart/form-data" method="post" id="course">
                        @csrf

                        <div class="form-body">
                            <div class="row" style="align-items: flex-start; overflow: visible;">
                                <div class="col-md-9 divrigth_border sticky-conent">
                                    <div class="row">
                                        <div class="col-md-12 title_head">
                                            Course Basic Information
                                        </div>
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label class="required" for="title">Course Title</label>
                                                <input type="text" data-parsley-required-message = "course title is required" value="{{$course->title}}" name="title" required="" id="title" placeholder = 'Enter title' class="form-control" >
                                                @if ($errors->has('title'))
                                                    <span class="invalid-feedback" role="alert">
                                                        {{ $errors->first('title') }}
                                                    </span>
                                                @endif
                                            </div>
                                        </div>
                                

                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label class="required" >Short Summery</label>
                                               <textarea data-parsley-required-message = "Summery is required" style="resize: vertical;" rows="3" name="summery" class="form-control">{{$course->summery}}</textarea>
                                           </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label class="required">Course Description</label>
                                               <textarea data-parsley-required-message = "Description is required" required="" name="description" class="summernote form-control">{{ $course->description }}</textarea>
                                           </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="required" for="category">Select category</label>
                                                <select required  onchange="get_subcategory(this.value)" name="category" id="category" class="select2 form-control custom-select">
                                                   <option value="">Select category</option>
                                                   @foreach($categories as $category)
                                                   <option @if($course->category_id == $category->id) selected @endif  value="{{$category->id}}">{{$category->name}}</option>
                                                   @endforeach
                                                </select>
                                                @if ($errors->has('category'))
                                                    <span class="invalid-feedback" role="alert">
                                                        {{ $errors->first('category') }}
                                                    </span>
                                                @endif
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="subcategory">Select subcategory</label>
                                                <select  name="subcategory" id="subcategory" class="form-control select2 custom-select">
                                                    <option value="">Select Subcategory</option>
                                                    @foreach($subcategories as $subcategory)
                                                    <option @if($subcategory->id == $course->subcategory_id) selected @endif value="{{$subcategory->id}}">{{$subcategory->name}}</option>
                                                    @endforeach
                                                </select>
                                                @if ($errors->has('subcategory'))
                                                    <span class="invalid-feedback" role="alert">
                                                        {{ $errors->first('subcategory') }}
                                                    </span>
                                                @endif
                                            </div>
                                        </div>
                                    
                                    
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="required" for="price">Price</label>
                                                <input data-parsley-required-message = "Price is required" required type="text" value="{{ $course->price }}"  name="price" id="price" placeholder = 'Enter price' class="form-control" >
                                            </div>
                                        </div>

                                        <div class="col-md-5  col-9">
                                            <div class="form-group">
                                                <label for="discount">Discount</label>
                                                <input type="text" value="{{ $course->discount }}"  name="discount" id="discount" placeholder = 'Enter discount' class="form-control" >
                                            </div>
                                        </div>
                                        <div class="col-md-1 col-3" style="padding-left: 0">
                                            <div class="form-group">
                                                <label for="discount_type">Type</label>
                                                <select name="discount_type" class="form-control">
                                                    <option @if($course->discount_type == Config::get('siteSetting.currency_symble')) selected @endif value="{{Config::get('siteSetting.currency_symble')}}">{{Config::get('siteSetting.currency_symble')}}</option>
                                                    <option  @if($course->discount_type == '%') selected @endif  value="%">%</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <div class="checkbox2">
                                                    <input  @if($course->meta_title != null) checked @endif  type="checkbox" id="checkSeo" name="secheck" value="1">
                                                    <label for="checkSeo">Course SEO</label>
                                              </div>
                                            </div>
                                            <div  id="seoField" @if($course->meta_title == null) style="display: none;" @endif>

                                                <div class="form-group">
                                                    <span class="required" for="meta_title">Meta Title</span>
                                                    <input type="text" value="{{$course->meta_title}}"  name="meta_title" id="meta_title" placeholder = 'Enter meta title'class="form-control" >
                                                </div>
                                                <div class="form-group">
                                                    <span class="required">Meta Keywords( <span style="font-size: 12px;color: #777;font-weight: initial;">Write meta tags Separated by Comma[,]</span> )</span>

                                                     <div class="tags-default">
                                                        <input  value="{{$course->meta_keywords}}" type="text" name="meta_keywords[]"  data-role="tagsinput" placeholder="Enter meta keywords" />
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <span class="control-label" for="meta_description">Meta Description</span>
                                                    <textarea class="form-control" name="meta_description" id="meta_description" rows="2" style="resize: vertical;" placeholder="Enter Meta Description">{{$course->meta_description}}</textarea>
                                                </div>
                                                 
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3 sticky-conent">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label for="duration">Duration</label>
                                                <input type="text" value="{{$course->duration}}"  name="duration" id="duration" placeholder = 'Enter duration' class="form-control" >
                                            </div>
                                        </div>
                                        <div class="col-12">
                                             <label for="Language">Language</label>
                                                <div class="form-group">
                                                    <select name="language" id="Language" class="form-control custom-select">
                                                    <option value="">Select Language</option>
                                                    <option @if($course->language == 'bangla') selected @endif value="bangla">Bangla</option>
                                                    <option @if($course->language == 'english') selected @endif value="english">English</option>
                                                    <option @if($course->language == 'arabic') selected @endif value="arabic">Arabic</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-12">
                                             <label for="price_type">Price Type</label>
                                                <div class="form-group">
                                                    <select name="price_type" id="price_type" class="form-control custom-select">
                                                    <option @if($course->price_type == 'paid') selected @endif value="paid">Paid Course</option>
                                                    <option @if($course->price_type == 'free') selected @endif value="free">Free Course</option>
                                                    
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label class="dropify_image required">Thumbnail Image</label>
                                                <input type="file" class="dropify" accept="image/*" data-type='image'  data-default-file="{{asset('upload/images/course/'.$course->thumbnail_image)}}" data-allowed-file-extensions="jpg jpeg png gif"  data-max-file-size="2M"  name="thumbnail_image" id="input-file-events">
                                            </div>
                                            @if ($errors->has('thumbnail_image'))
                                                <span class="invalid-feedback" role="alert">
                                                    {{ $errors->first('thumbnail_image') }}
                                                </span>
                                            @endif
                                        </div>
                                        
                                       
                                        <div class="col-12">
                                            <label for="course_video">Overview Video</label>
                                            <div class="form-group">
                                                
                                                <select name="video_provider" id="video_provider" class="form-control custom-select">
                                                <option value="">Select Video Provider</option>
                                                <option @if($course->video_provider == 'video') selected @endif value="video">Video Upload</option>
                                                <option @if($course->video_provider == 'youtube') selected @endif value="youtube">Youtube</option>
                                                <option @if($course->video_provider == 'vimeo') selected @endif value="vimeo">Vimeo</option>
                                                </select>
                                                <div id="video_provider_field">
                                                @if($course->video_provider == 'video')
                                                <span class="required">Video</span>
                                                <video width="100%" controls autoplay><source id="video" src="{{asset('upload/videos/course/'.$course->overview_video)}}" type="video/mp4"></video>
                                                @else
                                                <span class="required">Video link</span>
                                                <input class="form-control" required name="overview_video" id="overview_video" placeholder="Exm: https://www.youtube.com" value="{{$course->overview_video}}" type="text">
                                                @endif
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label for="start_date">Start date</label>
                                                <input type="date" value="{{$course->start_date}}" placeholder = 'Enter start date' name="start_date" id="start_date" class="form-control" >
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label for="end_date">End date</label>
                                                <input type="date" value="{{$course->end_date}}" placeholder = 'Enter end date' name="end_date" id="end_date" class="form-control" >
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="form-group">

                                                <label class="switch-box" style="top:-12px;">Status</label>

                                                    <div class="custom-control custom-switch">
                                                      <input name="status" {{ (old('status') == 'on') ? 'checked' : '' }} checked type="checkbox" class="custom-control-input" id="status">
                                                      <label style="padding: 5px 12px" class="custom-control-label" for="status">Publish/Unpublish</label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div><hr>
                        <div class="form-actions pull-right" style="float: right;">
                            <button type="submit"  name="submit" value="save" class="btn btn-success"> <i class="fa fa-save"></i> Update course </button>

                            <button type="reset" class="btn waves-effect waves-light btn-secondary">Reset</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- ============================================================== -->
    <!-- End Page wrapper  -->

@endsection

@section('js')
    <script src="{{asset('assets')}}/node_modules/select2/dist/js/select2.full.min.js" type="text/javascript"></script>
    <script src="{{asset('assets')}}/node_modules/dropify/dist/js/dropify.min.js"></script>

    <script type="text/javascript">
       
        @if(old('category'))
            get_subcategory({{old('category')}});
        @endif

        @if(Session::has("category_id")) 
            get_subcategory({{Session::get("category_id")}});
        @endif

        function get_subcategory(id=''){
            if(id){
            document.getElementById('pageLoading').style.display ='block';

            var  url = '{{route("getSubCategory", ":id")}}';
            url = url.replace(':id',id);
            $.ajax({
                url:url,
                method:"get",
                success:function(data){
                    if(data){
                        $("#subcategory").html(data);
                        $("#subcategory").focus();
                    }else{
                        $("#subcategory").html('<option value="">subcategory not found</option>');
                    }
                    document.getElementById('pageLoading').style.display ='none';
                }
            });
        }else{
            $("#subcategory").html(' <option value="">Select first category</option>');
        }
        }
   
    </script>

    <script>
    $(document).ready(function() {
        // Basic
        $('.dropify').dropify();

    });


    //allow seo fields
    $("#checkSeo").change(function() {
        if(this.checked) { $("#seoField").show(); }
        else { $("#seoField").hide(); }
    });


    </script>

    <script type="text/javascript">


    //video provider field
    $("#video_provider").change(function(){
     
        var provider = $(this).val();
        var output = '';
        if(provider){
            output = '<span class="required">Upload Video</span><div class="custom-file"> <input type="file" name="overview_video"></div>';
            
            if(provider != 'video'){
                output = '<span class="required">Video link</span><input class="form-control" required name="overview_video" id="overview_video" placeholder="Enter '+provider+' link" value="" type="text">';
            }
        }
       
        $('#video_provider_field').html(output);
    });

    </script>

   <script src="{{asset('assets')}}/node_modules/summernote/dist/summernote-bs4.min.js"></script>
    <script>
    $(function() {

        $('.summernote').summernote({
            height: 200, // set editor height
            minHeight: null, // set minimum height of editor
            maxHeight: null, // set maximum height of editor
            focus: false // set focus to editable area after initializing summernote
        });

        $('.inline-editor').summernote({
            airMode: true
        });

    });

    window.edit = function() {
            $(".click2edit").summernote()
        },
        window.save = function() {
            $(".click2edit").summernote('destroy');
        }

    </script>
    <script src="{{asset('assets')}}/node_modules/bootstrap-tagsinput/dist/bootstrap-tagsinput.min.js"></script>
    <script type="text/javascript">
        // Enter form submit preventDefault for tags
        $(document).on('keyup keypress', 'form input[type="text"]', function(e) {
          if(e.keyCode == 13) {
            e.preventDefault();
            return false;
          }
        });

        $(".select2").select2();
    </script>

@endsection

