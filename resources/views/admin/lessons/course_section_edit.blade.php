<input type="hidden" value="{{$data->id}}" name="id">
<div class="col-md-12">
    <div class="form-group">
        <label for="section_title">Section Name</label>
        <input  name="section_title" id="section_title" value="{{$data->section_title}}" required="" type="text" class="form-control">
    </div>
</div>

<div class="col-md-12">
    <div class="form-group">
        <label style="background: #fff;top:-10px;z-index: 1" for="summery">Summery</label>
        <textarea name="summery" class="form-control" placeholder="Enter summery" id="summery" rows="2">{{$data->summery}}</textarea>
    </div>
</div>

<div class="col-md-12 mb-12">
    <div class="form-group">
        <label class="switch-box">Status</label>
        <div  class="status-btn" >
            <div class="custom-control custom-switch">
                <input name="status" {{($data->status == 1 ) ?  'checked' : ''}} type="checkbox" class="custom-control-input" id="status-edit">
                <label  class="custom-control-label" for="status-edit">Publish/UnPublish</label>
            </div>
        </div>
    </div>
</div>

