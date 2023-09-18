<style>

.modal-upload img {
  display: block;
  max-width: 100%;
}
.modal-upload .preview {
  overflow: hidden;
  width: 160px; 
  height: 160px;
  margin: 10px;
  border: 1px solid #eee;
  border-radius: 50%;
  box-shadow: 0 0 2rem 0 rgba(136, 152, 170, .15) !important;
}
.modal-upload.modal-lg{
  max-width: 1000px !important;
}

.form-text{
  font-size: .8rem;
}
</style>

<link  href="{{ asset('admin') }}/vendor/cropperjs/cropper.css" rel="stylesheet">

<div class="card card-profile">
  <div class="pt-7">
    <div class="card-profile-image align-items-center text-center">
      <a href="javascript:;"  onclick="$('#upload_image').trigger('click');">
        <span class="profile-image shadow rounded-circle">
          <img src="{{ asset('uploads/customer/'.auth()->guard('customer')->user()->image) }}" class="profile-customer-image">
        </span>
      </a>
    </div>
    <form action="" id="form-upload-image">
        <div class="custom-file d-none">
            <input type="file" class="custom-file-input" id="upload_image" lang="en">
            <label class="custom-file-label text-left" for="upload_image"><i data-feather="upload" width="15"></i> Select file</label>
        </div>
    </form>

    <div class="text-center my-5">
      <h3>{{ $customer->name }} </h3>
      <div class="h6 text-muted">{{$customer->email}}</div>
    </div>

    <ul class="profile-links">
      <li><a href="#!"  onclick="$('#upload_image').trigger('click');"><span> <i data-feather="upload" width="15"></i></span> {{ __('frontend.change_profile_image') }}</a></li>
      <li><a href="{{route('customer.profile')}}"><span><i data-feather="edit-2" width="17" stroke-width="2"></i></span> {{ __('frontend.edit_profile') }}</a></li>
      <li><a href="{{route('customer.profile_change_password')}}"><span><i class="ni ni-settings-gear-65"></i></span> {{ __('frontend.change_password') }}</a></li>
    </ul>

  </div>
</div>


<div class="modal fade" id="modal" tabindex="-1" role="dialog" aria-labelledby="modalLabel" aria-hidden="true">
  <div class="modal-dialog modal-upload modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modalLabel">Laravel Crop Image Before Upload using Cropper JS - NiceSnippets.com</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">×</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="img-container">
            <div class="row">
                <div class="col-md-8">
                    <img id="image" src="https://avatars0.githubusercontent.com/u/3456749">
                </div>
                <div class="col-md-4">
                    <div class="preview"></div>
                </div>
            </div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
        <button type="button" class="btn btn-success" id="crop">Upload <i data-feather="upload" width="15"></i></button>
      </div>
    </div>
  </div>
</div>

@push('js')
    <script src="{{ asset('admin') }}/vendor/cropperjs/cropper.js"></script>

    <script>  
var $modal = $('#modal');
var image = document.getElementById('image');
var cropper;
  
$("body").on("change", "#upload_image", function(e){
    var files = e.target.files;
    var done = function (url) {
      image.src = url;
      $modal.modal('show');
    };
    var reader;
    var file;
    var url;

    if (files && files.length > 0) {
      file = files[0];

      if (URL) {
        done(URL.createObjectURL(file));
      } else if (FileReader) {
        reader = new FileReader();
        reader.onload = function (e) {
          done(reader.result);
        };
        reader.readAsDataURL(file);
      }
    }
});

$modal.on('shown.bs.modal', function () {
    cropper = new Cropper(image, {
      aspectRatio: 1,
      viewMode: 3,
      preview: '.preview'
    });
}).on('hidden.bs.modal', function () {
   cropper.destroy();
   cropper = null;
});

$("#crop").click(function(){
    canvas = cropper.getCroppedCanvas({
        width: 160,
        height: 160,
      });

    canvas.toBlob(function(blob) {
        url = URL.createObjectURL(blob);
        var reader = new FileReader();
         reader.readAsDataURL(blob); 
         reader.onloadend = function() {
            var base64data = reader.result; 

            $.ajax({
                type: "POST",
                dataType: "json",
                url: "{{route('customer.profile_update_image')}}",
                data: {'_token': $('meta[name="csrf-token"]').attr('content'), 'image': base64data},
                success: function(data){
                    $modal.modal('hide');
                    $('.profile-customer-image').attr('src' , data.url);
                    $('#form-upload-image').trigger('reset');

                }
              });
         }
    });
})
</script>

@endpush