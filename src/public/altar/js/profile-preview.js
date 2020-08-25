$(function(){
  $(document).on('click','.img-remove', function() {
      $('.photo').val('');
      $(this).hide();
      $('.img-find').show();
      var img_src = $('.img-preview').attr('data-src');
      $('.img-preview').css('background-image', 'url('+img_src+')');
      $('.img-preview').css('background-size', '160px');
  });

  $(document).on('click','.img-find', function() {
      $('.photo').click();
  });

  $(document).on('change','.photo', function() {
    var thisFile = this;
    var reader = new FileReader();
      reader.onload = function( e ){
          var img = new Image();
          img.src = e.target.result;
          
          img.onload = function () {
              var w = this.width;
              var h = this.height;
              if(w > h){
                var scala = 160/h;
                var new_width = Math.floor(w * scala);
                $('.img-preview').css('background-size', new_width+'px');  
              } else {
                $('.img-preview').css('background-size', '160px');
              }
              $('.img-preview').css('background-image', 'url('+this.src+')');
              $('.img-find').hide();
              $('.img-remove').show();
          }
      };
      reader.readAsDataURL(thisFile.files[0]);

  });

});