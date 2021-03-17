@if(count($allCourses)>0)
    @foreach($allCourses as $course) 
      
        <tr id="course{{ $course->id }}"  @if(in_array($course->id, $items_id)) style="background: #ffe2e2" @endif>
            <td><input type="checkbox" class="item_id" name="item_id[{{  $course->id }}]"></td>
            <td><a style="color: #000" target="_blank" href="{{ route('course_details', $course->slug) }}"><img width="35" src="{{ asset('upload/images/course/'. $course->thumbnail_image)}}"> {{Str::limit($course->title, 40)}}</a></td>
            <td>0</td>
            <td>{{ Config::get('siteSetting.currency_symble') . $course->price }}</td>
            <td>{{$course->price_type}}</td>
    
            @if(in_array($course->id, $items_id))
            <td><a href="javascript:void(0)"  class="btn btn-danger btn-sm">Added</a></td>
            @else
             <td><a href="javascript:void(0)"  class="btn btn-success btn-sm" onclick="addcourse({{ $course->id }})">Add</a></td>
            @endif
        </tr>
    @endforeach
    <tr><td colspan="15">{{$allCourses->appends(request()->query())->links()}}</td></tr>

@endif