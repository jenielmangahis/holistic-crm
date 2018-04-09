$(function(){
    $("#filter-leads-report").change(function() {
        if(this.checked) {
            var div = document.getElementById("leads-filter-grp");
            $(div).find('input:text, input:password, input:file, select, textarea')
                    .each(function() {
                        $(this).removeAttr('disabled'); 
                    });
        }else{
            var div = document.getElementById("leads-filter-grp");            
            $(div).find('input:text, input:password, input:file, select, textarea')
                    .each(function() {
                        $(this).attr('disabled', 'disabled'); 
                    });            
        }
    });

    $(".optInformation").change(function(){
        var infoSelected = $(this).val();
        if( infoSelected == 7 ){
            $(".grp-form-types").removeClass("hidden");
            $(".grp-form-date-range").addClass("hidden");
        }else if( infoSelected == 2 ){
            $(".grp-form-date-range").removeClass("hidden");
            $(".grp-form-types").addClass("hidden");
        }else{
            $(".grp-form-types").addClass("hidden");
            $(".grp-form-date-range").addClass("hidden");
        }        
    });
});