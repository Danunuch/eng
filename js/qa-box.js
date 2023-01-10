  
  $(function(){
    $('.qa-title').click(function(event) {
      event.preventDefault();
      $(this).next('.qa-content').stop().slideToggle(450); 
      $(this).toggleClass('opened');
    });
  });
