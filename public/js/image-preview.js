
var imageUpload = document.querySelectorAll('form.has-image-upload');
imageUpload.forEach(previewImages);
   
function previewImages(form) {
    var input = form.querySelector("input[type='file']");
    var preview = form.querySelector(".image-preview-container");
    var submit = form.querySelector("[type='submit']");
    var status = document.createElement('p');
    var images = document.createElement('div');
    images.style.display = 'flex';

    status.setAttribute('class','text-center text-info grey');
    var regex = /^([a-zA-Z0-9\s_\\.\-:])+(.jpg|.jpeg|.gif|.png|.bmp)$/;
     
    preview.appendChild(status);
    preview.appendChild(images);

    status.innerHTML = 'Select Images to upload'
    if(input.hasAttribute('required')){
        submit.style.cursor = 'not-allowed';
        submit.style.opacity = '.5';
        }


    input.addEventListener('change', function(){
      images.innerHTML = ''; //clear previous preview (if any..);

       for(var i = 0; i<input.files.length; ++i){
            var file = input.files[i];
            if (regex.test(file.name.toLowerCase())){//If a valid image
                var reader = new FileReader();
                reader.onload = function(e){
                    if(preview.hasAttribute('replace')  && form.querySelector(preview.getAttribute('replace')) !== null){
                        var prev = form.querySelector(preview.getAttribute('replace'));
                        prev.src =  e.target.result;
                    }
                    else{
                        var imageContainer = document.createElement('div');
                        imageContainer.style.width = preview.getAttribute('preview-width') || '200px';
                        imageContainer.style.height = preview.getAttribute('preview-height') || 'auto';

                        var image = new Image();
                        image.src = e.target.result;
                        image.style.width = '100%';
                        image.style.height = preview.getAttribute('preview-height') || 'auto';
                        imageContainer.appendChild(image);
                        /*if(preview.hasAttribute('caption')){
                          var caption = document.createElement('textarea');
                          caption.setAttribute('class','form-control');
                          caption.setAttribute('name',preview.getAtrribute('caption')+);
                          caption.setAttribute('placeholder','image caption');
                          caption.style.height = '80px !important';
                          imageContainer.appendChild(caption);
                        }*/
                        images.appendChild(imageContainer);
                      }
                    }
                reader.readAsDataURL(file);
            }else{
              //input.files.splice(i,1);//remove from the file array
              toastr.error(file.name+' is not a valid image');
            }
       }

       if(input.files.length > 0){
        //submit.value = 'Upload '+input.files.length+' image'+(input.files.length > 1 ? 's' : '');
          submit.style.cursor = 'pointer';
          submit.style.opacity = '1';
  
          status.innerHTML = input.files.length+' file(s) selected : ';
          for(var i = 0; i<input.files.length; ++i){
            status.innerHTML += '<strong>'+input.files[i].name+'</strong>';
            status.innerHTML += (i != (input.files.length - 1) ? ' , ' : '');
          }
        }

    });

    form.addEventListener('submit',function(){
      if(input.hasAttribute('required') && input.files.length > 0){
        return true;
      }
      return false;
    });
  
  }
      