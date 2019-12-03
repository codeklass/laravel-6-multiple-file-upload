@extends('layouts.app')

@section('content')
<div class="container mt-3">
  <h2>Laravel 6 AJAX Multiple File Upload</h2>
  <div class="row">
    <div class="col-md-8">
      <table class="table table-striped">
        <thead>
          <tr>
            <th>S No</th>
            <th>File Name</th>
            <th>File Preview</th>
            
          </tr>
        </thead>
        <tbody>
        @forelse($files as $file)
          <tr>
            <td>{{$file->id}}</td>
            <td>{{$file->name}}</td>
            @if($file->extension=='png' || $file->extension=='jpg' || $file->extension=='jpeg' || $file->extension=='gif')
            <td><img src="/files/{{$file->name}}" width="100px" height="60px"></td>
            @else
            <td><img src="/assets/file.png" width="100px" height="60px"></td>
            @endif
          </tr>
          @empty
          <tr><td colspan="3" class="text-center">Sorry No Files</td></tr>
          @endforelse
          
        </tbody>
      </table>
      {!! $files->render() !!}
  
    </div>
    <div class="col-md-4 border-left">
    <h3>Upload New File</h3>
    <div class="imageMsg"></div>
      <form action="{{route('fileupload')}}" method="post" id="uploadForm">

  <div class="custom-file">
    <input type="file" class="custom-file-input" id="customFile" name="file" multiple>
    <label class="custom-file-label" for="customFile">Choose file</label>
  </div>
 <div id="imgPreview" class="my-2"></div>
 <button type="submit" class="btn btn-primary">Submit</button>
</form>

    </div>
  </div>
             
  
</div>
@endsection

@section('scripts')
<script type="text/javascript">

$( document ).on('submit','#uploadForm',function(e) {
    e.preventDefault();

    

    var url=$('#uploadForm').attr('action');

    var fd = new FormData();
    var file_data = $('input[type="file"]')[0].files; // for multiple files
    for(var i = 0;i<file_data.length;i++){
        fd.append("file[]", file_data[i]);
    }
console.log(fd);
    fd.append("_token", "{{ csrf_token() }}")

    $.ajax({
        url: url,
        data: fd,
        contentType: false,
        processData: false,
        type: 'POST',
        success: function(data){
            console.log(data);
            if (data['status']=='success') {
              $('.imageMsg').empty();
                $('.imageMsg').append('<div class="alert alert-success text-center ">'+data['message']+'</div>');
                setTimeout(function(){ 
                   $('.imageMsg').empty();
                   location.reload(true);
                 }, 3000);
            };
        },
            error: function (data) {
                var errors = data.responseJSON;
                
                $('.imageMsg').empty();
                $('.imageMsg').append('<div class="alert alert-danger text-center errorMsg"></div>');
                var errorsHtml='';
                $.each(errors.errors, function( key, value ) {
                  errorsHtml += '<p >' + value[0] + '</p>';
                });
                $('.errorMsg').append(errorsHtml);
                setTimeout(function(){ 
                   $('.imageMsg').empty();
                   
                 }, 3000);
            }
    });
      
      
              
    
   
});

  function readURL(input) {
    if (input.files && input.files[0]) {



      var idata=input.files;
      $("#imgPreview").empty();
            $( idata ).each(function( index, element ) {

              var ext=$.trim(element.name.substr(element.name.lastIndexOf('.') + 1));
              console.log(ext)
              var src;

              
              var reader = new FileReader();
          
              reader.onload = function(e) {
                if (ext=='jpg' || ext=='jpeg' || ext=='png' || ext=='gif') {
                
                src=e.target.result;
              }else{
                 src='/assets/file.png';
              };
                
              $("#imgPreview").append("<img src='"+src+"' width='100px;' height='100px;' style='margin:3px;'>");


      }
      
      reader.readAsDataURL(input.files[index]);
            })
    }
  }

$(document).on('change',"#customFile",function() {
  readURL(this);
  
});


</script>
@endsection