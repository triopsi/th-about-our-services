;(function($){
    $(document).ready(function (){ 

       //Function get icon from inputfield
       function iconget(input){
            var reviewfield = $('.thiconReview');
            var inputVal = input.val();
            if(inputVal!=''){
                reviewfield.html('');
                reviewfield.append( "<i class='fas "+inputVal+"'></i>" );
            }
       }

       //Init
       iconget($('#thaos-icon'));

       //Change event on Field
       $('#thaos-icon').on('change',function(){
                iconget($(this));
        });
    });

})(jQuery);