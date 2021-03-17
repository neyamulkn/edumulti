@if(count($courses)>0)
<!-- Row -->
<div class="row align-items-center mb-3">
	<div class="col-lg-6 col-md-6 col-sm-12">
		We found <strong> {{$courses->total()}}</strong> courses for you
	</div>
	<div class="col-lg-6 col-md-6 col-sm-12 ordering">
		<div class="filter_wraps">
			<div class="dn db-991 mt30 mb0 show-23">
				<div id="main2">
					<a href="javascript:void(0)" class="btn btn-theme arrow-btn filter_open" onclick="openNav()" id="open2">Show Filter<span><i class="fas fa-arrow-alt-circle-right"></i></span></a>
				</div>
			</div>
			<div class="dropdown show">
				
				<select onchange="sortproduct()" id="sortby" class="form-control" >
                    <option value="">Default</option>

                    <option @if(Request::get('sortby') == 'name-a-z') selected @endif value="name-a-z">Name (A - Z)</option>
                    <option @if(Request::get('sortby') == 'name-z-a') selected @endif value="name-z-a"> Name (Z - A) </option>
                    <option @if(Request::get('sortby') == 'price-l-h') selected @endif value="price-l-h">Price (Low &gt; High)</option>
                    <option @if(Request::get('sortby') == 'price-h-l') selected @endif value="price-h-l"> Price (High &gt; Low) </option>
                    <option @if(Request::get('sortby') == 'ratting-h-l') selected @endif value="ratting-h-l">Rating (Highest)</option>
                    <option @if(Request::get('sortby') == 'ratting-l-h') selected @endif value="ratting-l-h"> Rating (Lowest) </option>

                </select>
			</div>
		</div>
	</div>
</div>
<!-- /Row -->

<div class="row">
	@foreach($courses as $course)
	<!-- Cource Grid 1 -->
	<div class="col-lg-4 col-md-4 col-sm-6">
		<div class="education_block_grid style_2">
			
			<div class="education_block_thumb n-shadow">
				<a href="{{route('course_details', $course->slug)}}"><img src="{{ asset('upload/images/course/'. $course->thumbnail_image) }}" class="img-fluid" alt=""></a>
				
			</div>
			
			<div class="education_block_body">
				<h4 class="bl-title"><a href="{{route('course_details', $course->slug)}}">{{ Str::limit($course->title, 40)}}</a></h4>
			</div>
			
			<div class="cources_info_style3">
				<ul>
					<li><i class="ti-control-skip-forward"></i> {{count($course->course_lessons)}} Lessons</li>
					<li><i class="ti-time"></i> {{ ($course->duration) ? $course->duration : 'Not Fixed' }}</li>
					<li><i class="ti-eye"></i> {{$course->views}} Views</li>
				</ul>
			</div>
			
			<div class="education_block_footer">
				<div class="education_block_author">
					<i class="fas fa-star filled text-warning mr-2"></i>0 (0)
				</div>
				@php 

				$price = $course->price;
				$discount = $course->discount;
				if($discount){
					if($course->discount_type == '%') {
					$price = $price - ($course->discount * $price) / 100;
					}else{
					$price = $price - $course->discount;
					}
				}
				@endphp
				<div class="cources_price_foot">@if($discount)<span class="price_off">{{Config::get('siteSetting.currency_symble')}}{{$course->price}}</span>@endif {{Config::get('siteSetting.currency_symble')}}{{round($price)}}</div>
				
			</div>
		</div>	
	</div>
	@endforeach
	
	
</div>

<!-- Row -->
<div class="row">
	<div class="col-lg-12 col-md-12 col-sm-12">
		
		<!-- Pagination -->
		<div class="row">
			<div class="col-sm-12 col-md-12 text-center">
		       {{$courses->appends(request()->query())->links()}}
		     </div>
		    <div class="col-sm-12 col-md-12 text-right">Showing {{ $courses->firstItem() }} to {{ $courses->lastItem() }} of total {{$courses->total()}} entries ({{$courses->lastPage()}} Pages)</div>
		</div>
		
	</div>
</div>
<!-- /Row -->
@else
<div style="text-align: center;">
    <h3>Search Result Not Found.</h3>
    <p>We're sorry. We cannot find any matches for your search term</p>
    <i style="font-size: 10rem;" class="fa fa-search"></i>
</div>
@endif