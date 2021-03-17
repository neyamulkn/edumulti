<input type="hidden" value="{{$data->id}}" name="id">
<div class="col-md-12">
    <div class="form-group">
        <label class="required" for="lesson_title">Lesson name</label>
        <input  name="lesson_title" id="lesson_title" value="{{$data->lesson_title}}" required="" type="text" class="form-control">
    </div>
</div>

<div class="col-md-12">
    <label for="course_video">Content type</label>
    <div class="form-group">
        <select onchange="lessonType(this.value, '_edit')" name="content_type" id="content_type" class="form-control custom-select">
            <option value="">Select Video Provider</option>
            <option @if($data->content_type == 'video') selected @endif value="video">Video Upload</option>
            <option @if($data->content_type == 'youtube') selected @endif value="youtube">Youtube</option>
            <option @if($data->content_type == 'vimeo') selected @endif value="vimeo">Vimeo</option>
            <option @if($data->content_type == 'document') selected @endif value="document">Document</option>
            <option @if($data->content_type == 'audio') selected @endif value="audio">Audio</option>
            <option @if($data->content_type == 'image') selected @endif value="image">Image file</option>
            <option @if($data->content_type == 'text') selected @endif value="image">Text</option>
            <option @if($data->content_type == 'custom') selected @endif value="custom">Custom type</option>
        </select>
        <div id="content_type_field_edit">
            @if($data->content_type == 'video')
            <video width="100%" controls autoplay><source id="video" src="{{asset('upload/lessons/'.$data->content)}}" type="video/mp4"></video>
            @elseif($data->content_type == 'image')
            <img src="{{asset('upload/lessons/'.$data->content)}}" width="80">@elseif($data->content_type == 'document')
            <a target="_blank" href="{{asset('upload/lessons/'.$data->content)}}" ><i class="fa fa-tags"></i> Document</a>
            @elseif($data->content_type == 'text')
            
            @else
            <input class="form-control" required name="content_link" id="content_link" placeholder="Exm: https://www.youtube.com" value="{{$data->content_link}}" type="text">
            @endif
        </div>
    </div>
</div>
<div class="col-md-12">
    <div class="form-group">
        <label style="background: #fff;top:-10px;z-index: 1" for="description">Description</label>
        <textarea name="description" class="form-control" placeholder="Enter description" id="description" rows="2">{{$data->description}}</textarea>
    </div>
</div>
<div class="col-md-12">
    <div class="form-group">
        <label for="duration">Duration</label>
        <input type="text" value="{{$data->duration}}"  name="duration" id="duration" placeholder = 'Enter duration' class="form-control" >
    </div>
</div>
<div class="col-md-12">
    <div class="form-group">
        <label for="free_lesson_edit">
        <input type="checkbox" @if($data->free_lesson == 1) checked @endif name="free_lesson" id="free_lesson_edit"> Is free lesson <i class=" ti-eye"></i></label>
    </div>
</div>

<div class="col-md-12 mb-12">

    <div class="form-group">
        <label class="switch-box">Status</label>
        <div  class="status-btn" >
            <div class="custom-control custom-switch">
                <input name="lessonStatusEdit" {{($data->status == 'active') ?  'checked' : ''}}   type="checkbox" class="custom-control-input" id="status-edit">
                <label  class="custom-control-label" for="lessonStatusEdit">Publish/UnPublish</label>
            </div>
        </div>
    </div>

</div>

