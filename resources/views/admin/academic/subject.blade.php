@extends('admin.layouts.admin-master')
@section('title', 'Subject list')
@section('css')
    <link rel="stylesheet" type="text/css"
        href="{{asset('assets')}}/node_modules/datatables.net-bs4/css/dataTables.bootstrap4.css">
    <link rel="stylesheet" type="text/css"
        href="{{asset('assets')}}/node_modules/datatables.net-bs4/css/responsive.dataTables.min.css">
    <link href="{{asset('assets')}}/node_modules/dropify/dist/css/dropify.min.css" rel="stylesheet" type="text/css" />
    <link href="{{asset('assets')}}/node_modules/bootstrap-switch/bootstrap-switch.min.css" rel="stylesheet">
    <link href="{{asset('css')}}/pages/bootstrap-switch.css" rel="stylesheet">

    <style type="text/css">
        .dropify_image{
            position: absolute;top: -12px!important;left: 12px !important; z-index: 9; background:#fff!important;padding: 3px;
        }
        .dropify-wrapper{
            height: 150px !important;
        }
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
                        <h4 class="text-themecolor">Subject List</h4>
                    </div>
                    <div class="col-md-7 align-self-center text-right">
                        <div class="d-flex justify-content-end align-items-center">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="javascript:void(0)">Subject</a></li>
                                <li class="breadcrumb-item active">list</li>
                            </ol>
                            <button data-toggle="modal" data-target="#add" class="btn btn-info d-none d-lg-block m-l-15"><i class="fa fa-plus-circle"></i> Create New</button>
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

                        <div class="card ">
                            <div class="card-body">
                                 
                                <div class="table-responsive">
                                    <table id="config-table" class="table table-bordered table-striped">
                                        <thead>
                                            <tr>
                                                <th>Subject Name</th>
                                                <th>Image</th>
                                                <th>Status</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead> 
                                        <tbody>
                                            @foreach($subjects as $data)
                                            <tr id="item{{$data->id}}">
                                                <td>{{$data->subject_name}}</td>
                                                <td><img src="{{asset('upload/images/subject/'. $data->photo)}}" width="50"></td>
                                              
                                                <td>
                                                    <div class="custom-control custom-switch">
                                                      <input  name="status" onclick="satusActiveDeactive('subjects', {{$data->id}})"  type="checkbox" {{($data->status == 1) ? 'checked' : ''}}  type="checkbox" class="custom-control-input" id="status{{$data->id}}">
                                                      <label style="padding: 5px 12px" class="custom-control-label" for="status{{$data->id}}"></label>
                                                    </div>
                                                </td>
                                                <td>
                                                    
                                                    <button type="button" onclick="edit('{{$data->id}}')"  data-toggle="modal" data-target="#edit" class="btn btn-info btn-sm"><i class="ti-pencil" aria-hidden="true"></i> Edit</button>
                                                    <button title="delete" onclick="deleteConfirmPopup('{{ route('subject.delete', $data->id) }}')" class="btn btn-danger btn-sm"><i class="ti-trash" aria-hidden="true"></i></button>
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
        <!-- add Modal -->
        <div class="modal fade" id="add" role="dialog"  tabindex="-1" aria-hidden="true" style="display: none;">
            <div class="modal-dialog">

                <!-- Modal content-->
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">Create Subject</h4>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>
                    <div class="modal-body form-row">
                        <div class="card-body">
                            <form action="{{route('subject.store')}}" enctype="multipart/form-data" method="POST" class="floating-labels">
                                {{csrf_field()}}
                                <div class="form-body">
                                    <!--/row-->
                                    <div class="row justify-content-md-center">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label for="name">Subject Name</label>
                                                <input  name="name" id="name" value="{{old('name')}}" required="" type="text" class="form-control">
                                            </div>
                                        </div>
                                     
                                    </div>
                                    <div class="row justify-content-md-center">
                                        <div class="col-md-12">
                                            <div class="form-group"> 
                                                <label class="dropify_image">Image</label>
                                                <input  type="file" class="dropify" accept="image/*" data-type='image' data-allowed-file-extensions="jpg jpeg png gif"  data-max-file-size="2M"  name="photo" id="input-file-events">
                                            </div>
                                            @if ($errors->has('photo'))
                                                <span class="invalid-feedback" role="alert">
                                                    {{ $errors->first('photo') }}
                                                </span>
                                            @endif
                                        </div>
                                    </div>

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
                                                <button type="submit" name="submit" value="add" class="btn btn-success"> <i class="fa fa-check"></i> Save</button>
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
            <div class="modal-dialog">
                <form action="{{route('subject.update')}}" enctype="multipart/form-data" method="post">
                {{ csrf_field() }}
                <!-- Modal content-->
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">Update Subject</h4>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>
                    <div class="modal-body form-row" id="edit_form"></div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-sm btn-success">Update</button>
                    </div>
                </div>
                </form>
            </div>
        </div>

        <!-- delete Modal -->
        @include('admin.modal.delete-modal')


@endsection
@section('js')

    <script src="{{asset('assets')}}/node_modules/dropify/dist/js/dropify.min.js"></script>
    <script>
    $(document).ready(function() {
        // Basic
        $('.dropify').dropify();
       
    });
    </script>
    <!-- This is data table -->
    <script src="{{asset('assets')}}/node_modules/datatables.net/js/jquery.dataTables.min.js"></script>
    <script src="{{asset('assets')}}/node_modules/datatables.net-bs4/js/dataTables.responsive.min.js"></script>

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

   <script>
       // responsive table
        $('#config-table').DataTable({
            responsive: true,
             ordering: false
        });
    </script>




    <script type="text/javascript">

        function edit(id){
            $('#edit_form').html('<div class="loadingData"></div>');
            var  url = '{{route("subject.edit", ":id")}}';
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
    </script>
@endsection
