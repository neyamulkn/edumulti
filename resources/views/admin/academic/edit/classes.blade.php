<input type="hidden" value="{{$data->id}}" name="id">

<div class="col-md-12">
    <div class="form-group">
        <label for="name">class name</label>
        <input  name="name" id="name" value="{{$data->class_name}}" required="" type="text" class="form-control">
    </div>
</div>


<div class="col-md-12">
    <div class="form-group"> 
        <label class="dropify_image">Image</label>
        <input data-default-file="{{asset('upload/images/class/'.$data->photo)}}" type="file" class="dropify" accept="image/*" data-type='image' data-allowed-file-extensions="jpg jpeg png gif"  data-max-file-size="2M"  name="photo" id="input-file-events">
    </div>
    @if ($errors->has('photo'))
        <span class="invalid-feedback" role="alert">
            {{ $errors->first('photo') }}
        </span>
    @endif
</div>



<div class="col-md-12 mb-12">

    <div class="form-group">
        <label class="switch-box">Status</label>
        <div  class="status-btn" >
            <div class="custom-control custom-switch">
                <input name="status" {{($data->status == 1) ?  'checked' : ''}}   type="checkbox" class="custom-control-input" id="status-edit">
                <label  class="custom-control-label" for="status-edit">Publish/UnPublish</label>
            </div>
        </div>
    </div>

</div>

