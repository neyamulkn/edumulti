@extends('frontend.user.layouts')
@section('title', 'Purchase History')

@section('userLayouts')
    @if(Session::has('success'))
    <div class="alert alert-success">
      <strong>Success! </strong> {{Session::get('success')}}
    </div>
    @endif
    @if(Session::has('error'))
    <div class="alert alert-danger">
      <strong>Error! </strong> {{Session::get('error')}}
    </div>
    @endif

    <?php 
        $all = $pending = $accepted =  $complete = $cancel = 0;
        foreach($orders as $order_status){

           
            if($order_status->order_status == 'accepted'){ $accepted +=1 ; }
            if($order_status->order_status == 'pending'){ $pending +=1 ; }
            if($order_status->order_status == 'complete'){ $complete +=1 ; }
            if($order_status->order_status == 'cancel'){ $cancel +=1 ; }
        }
        $all = $pending+$accepted+ $complete +$cancel;

    ?>
    <a  href="{{route('user.orderHistory')}}"><h2 style="margin-bottom: 10px;" class="title">Total Order ({{$all}})</h2></a>
    <section class="row">

        
        <div class="col-md-3 col-sm-4">
            <div class="dashboard_stats_wrap widget-6">
                <div class="dashboard_stats_wrap_content"><h4><a href="{{route('user.orderHistory', 'pending')}}" class="link ml-auto">{{$pending}}</a></h4> <span>Pending</span></div>
                <div class="dashboard_stats_wrap-icon"><i class="ti-server"></i></div>
            </div>  
        </div>
    
        
        <div class="col-md-3 col-sm-4">
            <div class="dashboard_stats_wrap widget-5">
                <div class="dashboard_stats_wrap_content"><h4><a href="{{route('user.orderHistory', 'accepted')}}" class="link ml-auto">{{$accepted}}</a></h4> <span>In Process</span></div>
                <div class="dashboard_stats_wrap-icon"><i class="ti-timer"></i></div>
            </div>  
        </div>
        <div class="col-md-3 col-sm-4">
            <div class="dashboard_stats_wrap widget-4">
                <div class="dashboard_stats_wrap_content"><h4><a href="{{route('user.orderHistory', 'pending')}}" class="link ml-auto">{{$cancel}}</a></h4> <span>Cancel</span></div>
                <div class="dashboard_stats_wrap-icon"><i class="ti-close"></i></div>
            </div>  
        </div>
        <div class="col-md-3 col-sm-4">
            <div class="dashboard_stats_wrap widget-1">
                <div class="dashboard_stats_wrap_content"><h4><a href="{{route('user.orderHistory', 'complete')}}" class="link ml-auto">{{$complete}}</a></h4> <span>Complete</span></div>
                <div class="dashboard_stats_wrap-icon"><i class="ti-thumb-up"></i></div>
            </div>  
        </div>
        
        
    </section>
   
    <!-- Row -->
    <div class="row">
        <div class="col-lg-12 col-md-12 col-sm-12">
            <div class="dashboard_container">
                
                <div class="dashboard_container_body">
                    <div class="table-responsive">
                        <table class="table">
                            <thead class="thead-dark">
                                <tr>
                                    <th>Enroll ID</th>
                                    <th>Course</th>
                                    <th>Price</th>
                                    <th>Payment_Method</th>
                                    <th>Payment_status</th>
                                    <th>Status</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>

                                @if(count($orders)>0)
                                    @foreach($orders as $order)
                                    <tr @if($order->order_status == 'cancel') style="background:#ff000026" @endif>
                                        <td>{{$order->order_id}} <br/> <p style="font-size: 12px;margin: 0;padding: 0">{{\Carbon\Carbon::parse($order->order_date)->format(Config::get('siteSetting.date_format'))}}
                                       ({{\Carbon\Carbon::parse($order->order_date)->diffForHumans()}})</p>
                                       </td>
                                       <td>
                                        <a target="_blank" href="{{ route('course_details', $order->courseDetails->slug)}}">
                                        <img src="{{ asset('upload/images/course/'.$order->courseDetails->thumbnail_image) }}" width="50" height="40">
                                           {{ Str::limit($order->courseDetails->title, 40)}}
                                       </td>
                                       
                                       
                                        <td>{{$order->currency_sign . ($order->total_price - $order->coupon_discount) }}</td>

                                        <td class ="payment-method"> <span class="label label-{{($order->payment_method=='pending') ? 'danger' : 'success' }}">
                                        {{ str_replace( '-', ' ', $order->payment_method) }}</span>
                                        <p style="font-size: 12px;margin: 0;padding: 0">
                                        @if($order->pay_mobile_no)
                                        <strong>Mobile:</strong> <span> {{$order->pay_mobile_no}}</span>@endif @if($order->tnx_id)
                                        <br/><strong>Tnx_id:</strong> <span> {{$order->tnx_id}}</span>@endif
                                        @if($order->payment_info)<br/> <span><strong>Info:</strong> {{$order->payment_info}}</span>@endif
                                        </p>
                                        </td>
                                        <td>
                                            @if($order->payment_status == 'paid')
                                            <span class="payment_status compelete"> {{ str_replace('-', ' ', $order->payment_status)}} </span>

                                            @elseif($order->payment_status == 'on-review')
                                            <span class="payment_status hold"> {{ str_replace('-', ' ', $order->payment_status)}} </span>
                                            @else
                                            <span class="payment_status pending"> Pending </span>
                                            @endif
                                            
                                         </td>
                                        
                                  
                                    <td> 
                                        @if($order->order_status == 'compelete')
                                        <span class="label label-success"> {{ str_replace('-', ' ', $order->order_status)}} </span>

                                        @elseif($order->order_status == 'accepted')
                                        <span class="label label-warning"> {{ str_replace('-', ' ', $order->order_status)}} </span>

                                    
                                        @elseif($order->order_status == 'cancel')
                                        <span class="label label-danger"> {{ str_replace('-', ' ', $order->order_status)}} </span>

                                    
                                        @else
                                        <span class="label label-info"> Pending </span>
                                        @endif
                                    </td>
                                    <td>

                                    <div class="btn-group">
                                        <button type="button" class="btn btn-info dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            <i class="ti-settings"></i>
                                        </button>
                                        <div class="dropdown-menu">

                                            <li><a href="{{ route('course_details', $order->courseDetails->slug)}}" title=" View course details" data-toggle="tooltip" class="dropdown-item" >View Details</a></li>

                                            @if($order->order_status == 'pending' || $order->order_status == 'accepted')
                                            <li><a title="Cancel Order" onclick="orderCancel('{{ route("user.orderCancelForm", [$order->order_id]) }}')" class="dropdown-item" ><i class="fa fa-trash"></i> Cancel order</a></li>
                                            @endif
                                        </div>
                                    </div>
                                    
                                </td>

                                </tr>
                               @endforeach
                            @else <tr><td colspan="8"> <h1>No Enrolls found.</h1></td></tr> @endif
                            
                            </tbody>
                        </table>
                    </div>
                </div>
                
            </div>
        </div>
    </div>
    <!-- /Row -->

        <!-- canel Modal -->
    <div class="modal fade" id="orderCancel" role="dialog"  tabindex="-1" aria-hidden="true" style="display: none;">
        <div class="modal-dialog">
            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Order Cancel</h4>

                    <button type="button" style="margin-top: -25px;" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body form-row">
                    
                    <div class="card-body">
                        <form action="{{route('user.orderCancel')}}" onsubmit="return confirm('{{Auth::user()->name}} Are you sure cancel this order.?');" method="POST" class="floating-labels">
                            {{csrf_field()}}
                            <div class="form-body" id="getCancelForm"> </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('js')

    <script type="text/javascript">
        
        function orderCancel(url) {
            $('#orderCancel').modal('show');
            $("#getCancelForm").html("<div style='height:135px' class='loadingData-sm'></div>");
            $.ajax({
                url:url,
                method:"get",
                success:function(data){
                    if(data){
                        $("#getCancelForm").html(data);
                    }
                }
            });
        }

    </script>
@endsection