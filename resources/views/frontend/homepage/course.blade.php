<!-- ============================ Featured Courses Start ================================== -->
<section @if($section->layout_width == 'full') style="background:{{$section->background_color}} url({{asset('upload/images/homepage/'.$section->background_image)}}) no-repeat 50% 50% fixed; background-size: cover;" @endif>

  @if($section->layout_width == 'box')
  <div class="container"style="background:{{$section->background_color}} url({{asset('upload/images/homepage/'.$section->background_image)}}) no-repeat 50% 50% fixed; background-size: cover; border-radius: 3px; padding:5px;"> @endif
      <div class="row justify-content-center">
        <div class="col-lg-5 col-md-6 col-sm-12">
          <div class="sec-heading center">
            <p style="color: {{ $section->text_color }}">{{$section->sub_title}}</p>
            <h2 style="color: {{ $section->text_color }}">{{$section->title}}</h2>
          </div>
        </div>
      </div>
      
      <div class="row">

          @foreach($items as $item)
          <div class="col-md-{{ round(12/$section->section_box_desktop) }} col-{{ round(12/$section->section_box_mobile) }}">
              <div class="education_block_grid style_2">
                <div class="education_block_thumb n-shadow">
                  <a href="{{route('course_details', $item->course->slug)}}"><img src="{{ asset('upload/images/course/'. $item->course->thumbnail_image) }}" class="img-fluid" alt=""></a>
                  
                </div>
                
                <div class="education_block_body">
                  <h4 class="bl-title"><a href="{{route('course_details', $item->course->slug)}}">{{ Str::limit($item->course->title, 40)}}</a></h4>
                </div>
                
                <div class="cources_info_style3">
                  <ul>
                    <li><i class="ti-control-skip-forward"></i> {{count($item->course->course_lessons)}} Lessons</li>
                    <li><i class="ti-time"></i> {{ ($item->course->duration) ? $item->course->duration : 'Not Fixed' }}</li>
                    <li><i class="ti-eye"></i> {{$item->course->views}} Views</li>
                  </ul>
                </div>
                
                <div class="education_block_footer">
                  <div class="education_block_author">
                    <i class="fas fa-star filled text-warning mr-2"></i>0 (0)
                  </div>
                  @php 

                  $price = $item->course->price;
                  $discount = $item->course->discount;
                  if($discount){
                    if($item->course->discount_type == '%') {
                    $price = $price - ($item->course->discount * $price) / 100;
                    }else{
                    $price = $price - $item->course->discount;
                    }
                  }
                  @endphp
                  <div class="cources_price_foot">@if($discount)<span class="price_off">{{Config::get('siteSetting.currency_symble')}}{{$item->course->price}}</span>@endif {{Config::get('siteSetting.currency_symble')}}{{round($price)}}</div>
                  
                </div>
              </div>  
          </div>
          @endforeach
      </div>
      
      <div class="row justify-content-center">
        <div class="col-lg-5 col-md-6 col-sm-12">
          <div class="text-center">
            <a href="{{route('courses')}}" class="btn btn-theme btn-browse-btn">More Courses</a>
          </div>
        </div>
      </div>
    @if($section->layout_width == 'box')
    </div>@endif
</section>
  <!-- ============================ Featured Courses End ================================== -->
  