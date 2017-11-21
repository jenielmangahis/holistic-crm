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
});