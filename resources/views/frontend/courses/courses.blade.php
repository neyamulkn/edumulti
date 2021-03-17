@extends('frontend.layouts.master')
@section('title', 'Courses')
@section('content')
	<section class="pt-0">
		<div class="container">
			<div class="row">
				<div class="col-lg-12 col-md-12 col-sm-12 pt-4">
					<nav aria-label="breadcrumb">
						<ol class="breadcrumb">
							<li class="breadcrumb-item"><a href="{{route('courses')}}">Courses</a></li>
							@if(Request::route('category'))
							<li class="breadcrumb-item" aria-current="page">{{ Request::route('category') }}</li>
							@endif

							@if(Request::route('subcategory'))
							<li class="breadcrumb-item active" aria-current="page">{{ Request::route('subcategory') }}</li>
							@endif
							
						</ol>
					</nav>
				</div>
			</div>
		</div>
	</section>
	<!-- ============================ Page Title End ================================== -->			

	<!-- ============================ Find Courses with Sidebar ================================== -->
	<section class="pt-0">
		<div class="container">
			
			<!-- Onclick Sidebar -->
			<div class="row">
				
			</div>

			<!-- Row -->
			<div class="row">
			
				<div class="col-lg-3 col-md-3 col-sm-12">							
					
					<div id="filter-sidebar" class="filter-sidebar">
						<div class="filt-head">
							<h4 class="filt-first">Filter Options</h4>
							<a href="javascript:void(0)" class="closebtn" onclick="closeNav()">Close <i class="ti-close"></i></a>
						</div>
						<div class="show-hide-sidebar">
							
							<!-- Find New Property -->
							<div class="sidebar-widgets">
								
								<!-- Search Form -->
								<form class="form-inline addons mb-3">
									<input class="form-control" name="q" value="@if(Request::get('q')) {!! preg_replace('/"/',' ',Request::get('q') ) !!} @endif" id="searchKey" type="search" placeholder="Search Courses" aria-label="Search">
									<button class="btn my-2 my-sm-0" type="submit"><i class="ti-search"></i></button>
								</form>	
								
								<h4 class="side_title">Course categories</h4>
								<ul class="no-ul-list mb-3">
									@foreach($categories as $category)
									<li>
										<a href="{{ route('courses', $category->slug) }}" for="aa-4" class="checkbox-custom-label">{{ $category->name }}</a>
									</li>
									@endforeach
									
								</ul>
								
								<h4 class="side_title">Rattings</h4>
								<ul class="no-ul-list mb-3">
									<ul class="ratting">
		                                @for($r=5; $r>=1; $r--)
		                                <li>
		                                    <input style="display: none;" @if(Request::get('ratting') == $r) checked @endif class="common_selector ratting" type="radio" name="ratting" id="ratting{{$r}}" value="{{$r}}">
		                                    <label for="ratting{{$r}}">
		                                    <span ><i class="fa fa-star text-warning"></i></span>
		                                    <span ><i class="fa fa-star{{($r<=1) ? '' : ' text-warning' }} "></i></span>
		                                    <span ><i class="fa fa-star{{($r<=2) ? '' : ' text-warning' }} "></i></span>
		                                    <span ><i class="fa fa-star{{($r<=3) ? '' : ' text-warning' }} "></i></span>
		                                    <span ><i class="fa fa-star{{($r<=4) ? '' : ' text-warning' }} "></i></span>
		                                    </label>
		                                </li>
		                                @endfor
		                            </ul>
								</ul>
								
								<h4 class="side_title">Price</h4>
								<ul class="no-ul-list mb-3">
									<li>
										<input @if(in_array('all', explode(',', Request::get('price')))) checked @endif class="common_selector price checkbox-custom" value="all" id="priceAll" type="checkbox" >
										<label for="priceAll" class="checkbox-custom-label">All</label>
									</li>
									<li>
										<input @if(in_array('free', explode(',', Request::get('price')))) checked @endif class="common_selector price checkbox-custom" value="free" id="pricFree" type="checkbox">
										<label for="pricFree" class="checkbox-custom-label">Free</label>
									</li>
									<li>
										<input @if(in_array('paid', explode(',', Request::get('price')))) checked @endif class="common_selector price checkbox-custom" value="paid" id="pricePaid" type="checkbox" >
										<label for="pricePaid" class="checkbox-custom-label">Paid</label>
									</li>
								</ul>
								 <div class="clear_filter" style="text-align: right;padding: 5px">
		                            <button type="reset" id="resetAll" class="btn btn-primary inverse">
		                                 Reset All
		                            </button>
		                        </div>
							
							</div>
							
						</div>
					
				</div>
					
				</div>	
				
				<div class="col-lg-9 col-md-9 col-sm-12 order-1 order-lg-2 order-md-1">
					<div id="dataLoading"></div>
					<div id="filter_product">
					@include('frontend.courses.filter_courses')
					</div>
				</div>
			
			</div>
			<!-- Row -->
			
		</div>
	</section>
	<!-- ============================ Find Courses with Sidebar End ================================== -->
	
@endsection

@section('js')

<script type="text/javascript">


    function filter_data(page)
    {
        //enable loader
        document.getElementById('dataLoading').style.display ='block';
        
        var category = "{!! (Request::route('category')) ? '/'. str_replace(' ', '', Request::route('category')) : '' !!}";
        var subcategory = "{!! (Request::route('subcategory')) ? '/'. str_replace(' ', '', Request::route('subcategory')) : '' !!}";
      

        var concatUrl = '?';

        
        var searchKey = $("#searchKey").val();
        if(searchKey != '' ){
            concatUrl += 'q='+searchKey;
        }
    
        var price = get_filter('price');
        if(price != '' ){
            concatUrl += '&price='+price;
        } 

        var ratting = get_filter('ratting');
        if(ratting != '' ){
            concatUrl += '&ratting='+ratting;
        }


        var sortby = $("#sortby :selected").val();
        if(typeof sortby != 'undefined' && sortby != ''){
            concatUrl += '&sortby='+sortby;
            //check weather page null or set 
            if(page == null){
                //var active = $('.active .page-link').html();
                var page = 1;
            }
        }

        if(page != null){concatUrl += '&page='+page;}
     
        var  link = '<?php echo URL::to("courses");?>'+category+subcategory+concatUrl;
            history.pushState({id: 'category'}, category +' '+subcategory, link);

        $.ajax({
            url:link,
            method:"get",
            data:{
                filter:'filter'
            },
            success:function(data){
                document.getElementById('dataLoading').style.display ='none';
        
                if(data){
                    $('#filter_product').html(data);
               }else{
                    $('#filter_product').html('Not Found');
               }
            },
            error: function() {
                document.getElementById('dataLoading').style.display ='none';
                $('#filter_product').html('<span class="ajaxError">Internal server error.!</span>');
            }

        });
    }

    function get_filter(class_name)
    {

        var filter = [];
        $('.'+class_name+':checked').each(function(){
            filter.push($(this).val());
        });
       
        return filter;
    }

    $('.common_selector').click(function(){
        filter_data();
    });

    function sortproduct(){
        filter_data();
    }
    function showPerPage(){
        filter_data();
    }

    function searchItem(value){
        if(value != ''){ filter_data(); }
    }

    $(document).on('click', '.pagination a', function(e){
        e.preventDefault();

        var page = $(this).attr('href').split('page=')[1];

        filter_data(page);
    });

    $('#resetAll').click(function(){
        $('input:checkbox').removeAttr('checked');
        $('input[type=checkbox]').prop('checked', false);
        $("#searchKey").val('');
        $('input:radio').removeAttr('checked');
         $("#price-range").val('0,10000');
        //call function
        filter_data();
    });

    //-- for course page -->
    function openNav() {
      document.getElementById("filter-sidebar").style.width = "100%";
    }

    function closeNav() {
      document.getElementById("filter-sidebar").style.width = "0";
    }

</script>
@endsection