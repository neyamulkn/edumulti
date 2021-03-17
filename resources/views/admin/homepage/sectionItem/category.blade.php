@extends('admin.layouts.admin-master')
@section('title', 'Section Item list')

@section('css-top')

    <link href="{{asset('assets')}}/node_modules/select2/dist/css/select2.min.css" rel="stylesheet" type="text/css" />

@endsection
@section('css')
    <link rel="stylesheet" type="text/css"
        href="{{asset('assets')}}/node_modules/datatables.net-bs4/css/dataTables.bootstrap4.css">
    <link rel="stylesheet" type="text/css"
        href="{{asset('assets')}}/node_modules/datatables.net-bs4/css/responsive.dataTables.min.css">
  
    <style type="text/css">
        .dropify-wrapper{  height: 100px !important; }
        #showcategoryArea{max-height: 400px; overflow-y: auto;}
        .discount_type{padding: 8px 3px; border: 1px solid #ccc; border-radius: 5px;}
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
                    <h4 class="text-themecolor">Section List</h4>
                </div>
                <div class="col-md-7 align-self-center text-right">
                    <div class="d-flex justify-content-end align-items-center">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="javascript::void(0)">Section</a></li>
                            <li class="breadcrumb-item active">list</li>
                        </ol>
                        <a href="{{route('admin.homepageSection')}}" class="btn btn-info btn-sm d-lg-block m-l-15"><i class="fa fa-eye"></i> Section List</a>
                        <button id="categoryModal" type="button" class="btn btn-info btn-sm d-lg-block m-l-15"><i class="ti-pin-alt"></i> Add More category</button>
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
                       
                        <div class="table-responsive">
                            <table id="myTable" class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>Category</th>
                                        <th>Status</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead> 
                                <tbody id="positionSorting" data-table='homepage_section_items'>
                                    @if(count($sectionItems)>0)
                                    @foreach($sectionItems as $sectionItem)
                                       
                                        <tr id="item{{$sectionItem->id}}">
                                            <td> <img src="{{asset('upload/images/category/'.$sectionItem->category->image)}}" alt="" width="50"> 
                                                {{Str::limit($sectionItem->category->name, 40)}}
                                            </td>
                                            
                                            <td>
                                                <div class="custom-control custom-switch">
                                                  <input  name="status" onclick="satusActiveDeactive('homepage_section_items', {{$sectionItem->id}})"  type="checkbox" {{($sectionItem->status == 1 || $sectionItem->status == 'active') ? 'checked' : ''}}  type="checkbox" class="custom-control-input" id="status{{$sectionItem->id}}">
                                                  <label style="padding: 5px 12px" class="custom-control-label" for="status{{$sectionItem->id}}"></label>
                                                </div>
                                            </td>
                                            
                                            <td>
                                              <span title="Remove category" data-toggle="tooltip"><button   data-target="#delete" onclick='deleteConfirmPopup("{{route("admin.homepageSectionItem.remove", $sectionItem->id)}}")'  data-toggle="modal" class="btn btn-danger btn-sm" ><i class="ti-trash"></i> Remove</button></span>                                               
                                            </td>
                                        </tr>
                                       
                                    @endforeach
                                    @else <tr><td colspan="15">No category found.</td></tr>@endif
                                </tbody>
                            </table>
                        </div>
                    
                    </div>
                </div>
            </div>

             <div class="row">
               <div class="col-sm-6 col-md-6 col-lg-6 text-center">
                   {{$sectionItems->appends(request()->query())->links()}}
                  </div>
                <div class="col-sm-6 col-md-6 col-lg-6 text-right">Showing {{ $sectionItems->firstItem() }} to {{ $sectionItems->lastItem() }} of total {{$sectionItems->total()}} entries ({{$sectionItems->lastPage()}} Pages)</div>
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
    <div class="modal fade" id="sectionModel" role="dialog" style="display: none;">
        <div class="modal-dialog modal-lg">

              <!-- Modal content-->
              <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Added category</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body form-row">
                    <div class="card-body">
                            <form action="{{route('admin.sectionMultiItemStore')}}" id="checkMarkcategorys" method="post">
                            @csrf
                            <input type="hidden" value="{{$section->id}}" name="section_id">
                            <div class="form-body">
                                <!--/row-->
                                <div class="row">
                                    
                                    <div class="col-md-4">
                                        <input type="text" name="item" id="item" class="form-control" placeholder="Search by category name">
                                    </div>
                                    
                                    <div class="col-md-3">
                                        <div class="form-group">
                                           
                                            <select onchange="getAllcategorys()" id="category" class="form-control custom-select select2">
                                                <option value="all">All category</option>
                                                @foreach($categories as $category)
                                                <option value="{{$category->id}}" {{ (old('category') == $category->id) ? 'selected' : '' }}> {{$category->name}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>

                                    
                                    <div class="col-md-1">
                                        <div class="form-group"><button type="button" onclick="getAllcategorys()" class="btn btn-info"><i class="fa fa-search"></i></button></div>
                                    </div>

                                    
                                    <div class="col-md-12" id="showcategoryArea">
                                    
                                        <table class="table table-bordered table-hover">
                                            <thead>
                                                <tr>
                                                    <th><input type="checkbox" id="checkAll"></th>
                                                    <th>Category</th>
                                                    <th>Added</th>
                                                </tr>
                                            </thead> 
                                            <tbody id="showAllcategorys"></tbody>
                                        </table>
                                   
                                    </div>
                                </div>

                                <div class="row justify-content-md-center">
                                    
                                    <div class="col-md-12">
                                        
                                        <div class="modal-footer">
                                            <button type="submit" name="submit" value="add" class="btn btn-success"> <i class="fa fa-check"></i> Add</button>
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
    <div class="modal fade" id="edit_modal" role="dialog" style="display: none;">
        <div class="modal-dialog">
            <form action="{{route('admin.homepageSectionItem.update')}}"  method="post">
                  {{ csrf_field() }}
              <!-- Modal content-->
              <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Update section category</h4>
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

    <!-- This is data table -->
    <script src="{{asset('assets')}}/node_modules/datatables.net/js/jquery.dataTables.min.js"></script>
    <script src="{{asset('assets')}}/node_modules/datatables.net-bs4/js/dataTables.responsive.min.js"></script>
    <script src="{{asset('assets')}}/node_modules/select2/dist/js/select2.full.min.js" type="text/javascript"></script>

    <!-- end - This is for export functionality only -->
    <script>
        $(".select2").select2();

        $(function () {
            $('#myTable').dataTable({
                "ordering": false,
                 "paging": false,"info":false
            });
        });
      
    </script>

    <script type="text/javascript">


        //open section modal
        $('#categoryModal').on('click', function(){
            $('#sectionModel').modal('show');
            getAllcategorys();
        });

        // get category by search
        function getAllcategorys(page=null){
            $('#showAllcategorys').html('<tr><td colspan="9"><div class="loadingData"></div></td></tr>');
            var  url = '{{route("section.getAllcategories")}}';
            var item = $('#item').val();
            var category = $('#category').val();
          
            var section_id = '{{$section->id}}';
           
            $.ajax({
                url:url,
                method:"get",
                data:{item:item,category:category,page:page,section_id:section_id},
                success:function(data){
                    
                    if(data){
                        $("#showAllcategorys").html(data);
                       
                    }else{
                        $("#showAllcategorys").html('<tr><td colspan="9">No category found.</td></tr>');
                    }
                },
                error: function(jqXHR, exception) {
                    toastr.error('Internal server error.');
                    $("#showAllcategorys").html('<tr><td style="color:red" colspan="9">Internal server error.</td></tr>');
            }
            });
        }
        //paginate 
        $(document).on('click', 'td .pagination a', function(e){
            e.preventDefault();
            var page = $(this).attr('href').split('page=')[1];
            getAllcategorys(page);
        });

        //single category added
        function addcategory(item_id) {
            var section_id = '{{$section->id}}';
           
            $.ajax({
                url:'{{route("admin.sectionSingleItemStore")}}',
                type:'get',
                data:{section_id:section_id,item_id:item_id,'_token':'{{csrf_token()}}'},
                success:function(data){
                    if(data.status){
                        toastr.success(data.msg);
                    }else{
                        toastr.error(data.msg);
                    }
                }
            });
        }

        $('.checkMarkcategorys').click(function(){
            $.ajax({
                url:'{{route("admin.sectionMultiItemStore")}}',
                type:'post',
                data:$('#checkMarkcategorys').serialize(),
                success:function(data){
                    if(data.status == 'success'){
                        toastr.success(data.msg);
                        location.reload();
                    }else{
                        toastr.error(data.msg);
                    }
                }
            });
        });


        //on click select all categorys
        $('#checkAll').on('click', function() {
            if (this.checked == true){
                $('#showAllcategorys').find('.item_id').prop('checked', true);
            }
            else{
                $('#showAllcategorys').find('.item_id').prop('checked', false);
            }
        });

  
        function remove_category(id){
            $('#category'+id).remove();
        }   

        // if occur error open model
        @if($errors->any())
            $("#{{Session::get('submitType')}}").modal('show');
        @endif
    </script>

@endsection
