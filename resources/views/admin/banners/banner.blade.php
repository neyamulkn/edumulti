@extends('admin.layouts.admin-master')
@section('title', 'Banner list')
@section('css')
    <link rel="stylesheet" type="text/css"
        href="{{asset('assets')}}/node_modules/datatables.net-bs4/css/dataTables.bootstrap4.css">
    <link rel="stylesheet" type="text/css"  href="{{asset('assets')}}/node_modules/datatables.net-bs4/css/responsive.dataTables.min.css">
    <link href="{{asset('assets')}}/node_modules/dropify/dist/css/dropify.min.css" rel="stylesheet" type="text/css" />
    <style type="text/css">
        .dropify_image{
            position: absolute;top: -12px!important;left: 12px !important; z-index: 9; background:#fff!important;padding: 3px;
        }
        .dropify-wrapper{
            height: 180px !important;
        }
        #myTable img{border: 1px solid red;}
    </style>
@endsection
@section('content')
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
                        <h4 class="text-themecolor">Banner List</h4>
                    </div>
                    <div class="col-md-7 align-self-center text-right">
                        <div class="d-flex justify-content-end align-items-center">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="javascript:void(0)">banner</a></li>
                                <li class="breadcrumb-item active">list</li>
                            </ol>
                            <button data-toggle="modal" data-target="#add" class="btn btn-info d-none d-lg-block m-l-15"><i
                                    class="fa fa-plus-circle"></i> Add New banner</button>
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

                                <div class="table-responsive">
                                    <table id="config-table" class="table table-bordered table-striped">
                                        <thead>
                                            <tr>
                                                <th>Image</th>
                                                <th>Title</th>
                                                <th>Page</th>
                                                <th>Link</th>
                                                <th>Status</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead> 
                                        <tbody id="positionSorting" data-table="banners">
                                            @foreach($banners as $banner)
                                            <tr id="item{{$banner->id}}">
                                                @php
                                                    $width = 340/$banner->banner_type;
                                                @endphp
                                                <td style="width: 360px;">
                                                    @if($banner->banner1)
                                                    <img src="{!! asset('upload/images/banner/'. $banner->banner1) !!}" width="{{$width}}">
                                                    @endif
                                                    @if($banner->banner2)
                                                    <img src="{!! asset('upload/images/banner/'. $banner->banner2) !!}" width="{{$width}}">
                                                    @endif
                                                    @if($banner->banner3)
                                                    <img src="{!! asset('upload/images/banner/'. $banner->banner3) !!}" width="{{$width}}">
                                                    @endif @if($banner->banner4)
                                                    <img src="{!! asset('upload/images/banner/'. $banner->banner4) !!}" width="{{$width}}">
                                                    @endif @if($banner->banner5)
                                                    <img src="{!! asset('upload/images/banner/'. $banner->banner5) !!}" width="{{$width}}">
                                                    @endif @if($banner->banner6)
                                                    <img src="{!! asset('upload/images/banner/'. $banner->banner6) !!}" width="{{$width}}">
                                                    @endif
                                                </td>
                                                <td>{{$banner->title}}</td>
                                                <td>{{str_replace('_', ' ', $banner->page_name)}}</td>
                                                <td>
                                                    @if($banner->btn_link1)
                                                    <small> {!! $banner->btn_link1 !!} <br/> </small>
                                                    @endif
                                                    @if($banner->btn_link2)
                                                    <small> {!! $banner->btn_link2 !!} <br/> </small>
                                                    @endif
                                                    @if($banner->btn_link3)
                                                    <small> {!! $banner->btn_link3 !!} <br/> </small>
                                                    @endif
                                                    @if($banner->btn_link4)
                                                    <small> {!! $banner->btn_link4 !!} <br/> </small>
                                                    @endif
                                                    @if($banner->btn_link5)
                                                    <small> {!! $banner->btn_link5 !!} <br/> </small>
                                                    @endif
                                                    @if($banner->btn_link6)
                                                    <small> {!! $banner->btn_link6 !!} <br/> </small>
                                                    @endif
                                                </td>
                                                <td>
                                                    <div class="custom-control custom-switch">
                                                      <input  name="status" onclick="satusActiveDeactive('banners', {{$banner->id}})"  type="checkbox" {{($banner->status == 1) ? 'checked' : ''}}  type="checkbox" class="custom-control-input" id="status{{$banner->id}}">
                                                      <label style="padding: 5px 12px" class="custom-control-label" for="status{{$banner->id}}"></label>
                                                
                                                    </div>
                                                </td>
                                                <td>
                                                    <button type="button" onclick="edit('{{$banner->id}}')"  data-toggle="modal" data-target="#edit" class="btn btn-info btn-sm"><i class="ti-pencil" aria-hidden="true"></i> </button>
                                                    
                                                    <button title="delete" data-target="#delete" onclick="deleteConfirmPopup('{{ route('banner.delete', $banner->id) }}')" class="btn btn-danger btn-sm" data-toggle="modal"><i class="ti-trash" aria-hidden="true"></i> </button>
                                                </td>
                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
                <!-- ============================================================== -->
                <!-- End PAge Content -->
                <!-- ============================================================== -->

            </div>
            <!-- ============================================================== -->
            <!-- End Container fluid  -->
            <!-- ============================================================== -->
        </div>
        <!-- ============================================================== -->
        <!-- End Page wrapper  -->
        <!-- update Modal -->
        <div class="modal fade" id="add" role="dialog"  tabindex="-1" aria-hidden="true" style="display: none;">
            <div class="modal-dialog modal-lg">

                  <!-- Modal content-->
                  <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">Add New banner</h4>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>
                    <div class="modal-body form-row">
                        <div class="card-body">
                            <form action="{{route('banner.store')}}" enctype="multipart/form-data" data-parsley-validate method="POST" >
                                {{csrf_field()}}
                                <div class="form-body">
                                    <!--/row-->
                                    <div class="row justify-content-md-center">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label class="" for="title">Banner Title</label>
                                                <input name="title" id="title" value="{{old('title')}}"  type="text" class="form-control">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="name required">Select Banner Type</label>
                                                <select required onchange="bannerType(this.value)" name="banner_type" class="form-control">
                                                    <option value="">Select Banner</option>
                                                    <option  value="1">Large Banner</option>
                                                    <option  value="2">Two Banner</option>
                                                    <option  value="3">Three Banner</option>
                                                    <option  value="4">Four Banner</option>
                                                    <option  value="5">Five Banner</option>
                                                    <option  value="6">Six Banner</option>
                                                  
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="name required">Select Page</label>
                                                <select required  name="page_name" class="form-control">
                                                    <option value="all">All Page</option>
                                                     <option value="homepage">Homepage</option>
                                                    @foreach($pages as $page)
                                                    <option value="{{$page->id}}">{{$page->title}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row" id="showBannerImage"> </div>
                                    
                                         
                                    <div class="row justify-content-md-center">
                                        <div class="col-md-12">
                                            <div class="head-label">
                                                <label class="switch-box">Status</label>
                                                <div  class="status-btn" >
                                                    <div class="custom-control custom-switch">
                                                        <input name="status" checked  type="checkbox" class="custom-control-input" {{ (old('status') == 'on') ? 'checked' : '' }} id="status">
                                                        <label  class="custom-control-label" for="status">Publish/UnPublish</label>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="submit" name="submit" value="add" class="btn btn-success"> <i class="fa fa-check"></i> Add New banner</button>
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
          </div>
        <!-- update Modal -->
        <div class="modal fade" id="edit" role="dialog"  tabindex="-1" aria-hidden="true" style="display: none;">
            <div class="modal-dialog modal-lg">
                <form action="{{route('banner.update')}}" enctype="multipart/form-data"  method="post">
                {{ csrf_field() }}
                <!-- Modal content-->
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">Update banner</h4>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>
                    <div class="modal-body" id="edit_form"></div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-sm btn-success">Update</button>
                    </div>
                </div>
                </form>
            </div>
          </div>
          <!--  Delete Modal -->
        @include('admin.modal.delete-modal')
@endsection
@section('js')
    <!-- This is data table -->
    <script src="{{asset('assets')}}/node_modules/datatables.net/js/jquery.dataTables.min.js"></script>
    <script src="{{asset('assets')}}/node_modules/datatables.net-bs4/js/dataTables.responsive.min.js"></script>
    <script src="{{asset('assets')}}/node_modules/dropify/dist/js/dropify.min.js"></script>
        <script>
    // responsive table
        $('#config-table').DataTable({
            responsive: true,
             ordering: false
        });
    </script>
   <script>
      
        function removeImage(id, imageNo){
            if ( confirm("Are you sure delete it.?")) {
                       
                $.ajax({
                    url:"{{route('bannerImage_delete')}}",
                    method:"get",
                    data: {id:id, imageNo:imageNo},
                    success:function(data){
                        if(data){
                            $('.image'+imageNo).html('<input type="file" required accept="image/*" data-type="image" data-allowed-file-extensions="jpg jpeg png gif"  name="banner'+imageNo+'" id="'+imageNo+'" class="dropify" />');
                            $("#image"+imageNo).addClass('dropify');
                            $('.dropify').dropify();
                            toastr.success(data.msg);
                        }
                    }
                }); 
            }
            return false;
        }

    </script>

    <script type="text/javascript">

      function edit(id){
            $('#edit_form').html('<div class="loadingData"></div>');
            var  url = '{{route("banner.edit", ":id")}}';
            url = url.replace(':id',id);
            $.ajax({
                url:url,
                method:"get",
                success:function(data){
                    if(data){
                        $("#edit_form").html(data);
                        $('.dropify').dropify();
                    }
                }, 
                // $ID Error display id name
                @include('common.ajaxError', ['ID' => 'edit_form'])

            });

    }      

    function bannerType(type, edit=''){
        var width = Math.round(1200/type);
        var output = '';
        for(var i=1; i<=type; i++){
            output += '<div class="col-md-'+Math.round(12/type)+'"><div class="form-group"><label class="required dropify_image">Banner '+i+'</label><input type="hidden" name="width" value="'+width+'"><input required type="file" class="dropify" accept="image/*" data-type="image" data-allowed-file-extensions="jpg jpeg png gif"  data-max-file-size="2M"  name="banner'+i+'" id="input-file-events"><p style="color:red;font-size: 10px">Image Size: '+width+'px * 250px</p> <label class="required" for="btn_link">Link '+i+'</label><input type="text" required id="btn_link" name="btn_link'+i+'" placeholder="Exp: {{url("/")}}" class="form-control"></div></div>';
        }
        document.getElementById('showBannerImage'+edit).innerHTML = output;
        $('.dropify').dropify();

    }


    // if occur error open model
    @if($errors->any())
        $("#{{Session::get('submitType')}}").modal('show');
    @endif
</script>


@endsection
