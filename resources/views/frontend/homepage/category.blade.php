<!-- ============================ Featured Category Start ================================== -->
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
        <div class="col-lg-12 col-md-12 col-sm-12 p-0">

          <div class="arrow_slide {{ $section->section_box_desktop}}_slide-dots arrow_middle">
            
            @foreach($items as $item)
            <div class="singles_items">
              <div class="edu_cat">
                <div class="pic">
                  <a class="pic-main" href="{{route('courses', $item->category->slug)}}" style="background-image:url({{ asset('upload/images/category')}}/{{($item->category->image) ? $item->category->image : 'not-available.png' }});"></a>
                </div>
                <div class="edu_data">
                  <h4 class="title"><a href="{{route('courses', $item->category->slug)}}">{{$item->category->name}}</a></h4>
                  <ul class="meta">
                    <li class="lessions"><i class="ti-book"></i>{{count($item->category->courseByCategory)}} Courses</li>
                  </ul>
                </div>
              </div>  
            </div>
            @endforeach
          </div>
        </div>
      </div>
    @if($section->layout_width == 'box')
    </div>@endif
</section>
<!-- ============================ Featured Category End ================================== -->
  