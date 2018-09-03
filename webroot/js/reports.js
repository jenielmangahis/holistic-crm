$(function(){
    $(".select-all-sources").click(function(){
        $('.chk-sources').not(this).prop('checked', this.checked);
    });

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
            $(".grp-form-date-range-all-forms").addClass("hidden");
            $(".grp-form-date-range-leads-telephone").addClass("hidden");
        }else if( infoSelected == 2 ){
            $(".grp-form-date-range").removeClass("hidden");
            $(".grp-form-types").addClass("hidden");
            $(".grp-form-date-range-all-forms").addClass("hidden");
            $(".grp-form-date-range-leads-telephone").addClass("hidden");
        }else if( infoSelected == 6 ){
            $(".grp-form-date-range-all-forms").removeClass("hidden");
            $(".grp-form-date-range").addClass("hidden");
            $(".grp-form-types").addClass("hidden");            
            $(".grp-form-date-range-leads-telephone").addClass("hidden");
        }else if( infoSelected == 8 ){
            $(".grp-form-date-range-leads-telephone").removeClass("hidden");
            $(".grp-form-date-range-all-forms").addClass("hidden");
            $(".grp-form-date-range").addClass("hidden");
            $(".grp-form-types").addClass("hidden"); 
        }else{
            $(".grp-form-types").addClass("hidden");
            $(".grp-form-date-range").addClass("hidden");
            $(".grp-form-date-range-all-forms").addClass("hidden");
            $(".grp-form-date-range-leads-telephone").addClass("hidden");
        }        
    });

    /*$("#viewAllDateRangeAllForms").change(function(){
        if ($(this).is(':checked')) {
            $(".dateRangeAllFormsFromDate").attr('disabled','disabled');
            $(".dateRangeAllFormsToDate").attr('disabled','disabled');
        }else{
            $(".dateRangeAllFormsFromDate").removeAttr('disabled');
            $(".dateRangeAllFormsToDate").removeAttr('disabled');
        }
    });*/

    $("#viewAllLeadsTelephone").change(function(){
        if ($(this).is(':checked')) {
            $(".dateRangeLeadsTelephoneFromDate").attr('disabled','disabled');
            $(".dateRangeLeadsTelephoneToDate").attr('disabled','disabled');
        }else{
            $(".dateRangeLeadsTelephoneFromDate").removeAttr('disabled');
            $(".dateRangeLeadsTelephoneToDate").removeAttr('disabled');
        }
    });
});