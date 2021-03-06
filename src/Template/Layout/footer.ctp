<?php ?>
    </div>
    <!-- #wrapper -->

    <div class="modal fade" id="messageNotifierModal" tabindex="-1" role="dialog" aria-labelledby="messageModalLabel">
        <div class="modal-dialog " role="document">
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="messageModalLabel">Notice</h4>
              </div>

              <div class="modal-body">
                <p id="msg-notifier-container"></p>
              </div>
              <div class="modal-footer">                                 
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
              </div>
            </div>
        </div>
    </div>

  <footer class="main-footer">
    <div class="pull-right hidden-xs">
      <!-- <b>Version</b> --> <!-- <?= CURRENT_VERSION; ?> -->
    </div>
    <strong>Copyright &copy; 2017 <a href="#">Holistic Web Presence</a>.</strong> All rights
    reserved.
  </footer>

<?php   
  echo $this->Html->script('plugins/jQuery/jquery-2.2.3.min.js');
  echo $this->Html->script('app/jquery.min.js'); 
  echo $this->Html->script('jquery-sortable.js'); 
  if ( isset($load_advance_search_script) || isset($load_reports_js) ){
    echo $this->Html->script('reports.js'); 
  }
  if( isset($load_chart_js) ){
    echo $this->Html->script('plugins/chartjs/Chart.min.js'); 
  }
?>

<script>  
    var base_url = "<?= $base_url; ?>";

    //$.noConflict();
    var table = $('.sort_table_allocation').sortable({
        containerSelector: 'table',
        itemPath: '> tbody',
        itemSelector: 'tr',
        placeholder: '<tr class="placeholder"/>',
        onDrop: function (item, container, _super) {
            var ids = table.find('tr').map(function() {
                return this.id;
            }).get();
        
            console.log(ids);
            _super(item, container);

            _pass_post_data_allocation(ids);

        }
    });    

    function _pass_post_data_allocation(ids) 
    {
      $(function() {
        $.post( base_url + "allocations/_update_order_list", {ids:ids}, function( data ) {
        });       
      });           
    }

    //drag and drop for statuses
    var table_status = $('.sort_table_statuses').sortable({
        containerSelector: 'table',
        itemPath: '> tbody',
        itemSelector: 'tr',
        placeholder: '<tr class="placeholder"/>',
        onDrop: function (item, container, _super) {
            var ids = table_status.find('tr').map(function() {
                return this.id;
            }).get();
        
            console.log(ids);
            _super(item, container);

            _pass_post_data_statuses(ids);

        }
    });      

    function _pass_post_data_statuses(ids) 
    {
      $(function() {
        $.post( base_url + "statuses/_update_status_order", {ids:ids}, function( data ) {
        });       
      });           
    }     

    //drag and drop for lead types
    var table_lead_types = $('.sort_table_lead_types').sortable({
        containerSelector: 'table',
        itemPath: '> tbody',
        itemSelector: 'tr',
        placeholder: '<tr class="placeholder"/>',
        onDrop: function (item, container, _super) {
            var ids = table_lead_types.find('tr').map(function() {
                return this.id;
            }).get();
        
            console.log(ids);
            _super(item, container);

            _pass_post_data_lead_types(ids);

        }
    });     

    function _pass_post_data_lead_types(ids) 
    {
      $(function() {
        $.post( base_url + "lead_types/_update_lead_type_order", {ids:ids}, function( data ) {
        });       
      });           
    }

    //drag and drop for intereset types
    var table_interest_types = $('.sort_table_interest_types').sortable({
        containerSelector: 'table',
        itemPath: '> tbody',
        itemSelector: 'tr',
        placeholder: '<tr class="placeholder"/>',
        onDrop: function (item, container, _super) {
            var ids = table_interest_types.find('tr').map(function() {
                return this.id;
            }).get();
        
            console.log(ids);
            _super(item, container);

            _pass_post_data_interest_types(ids);

        }
    });     

    function _pass_post_data_interest_types(ids) 
    {
      $(function() {
        $.post( base_url + "interest_types/_update_interest_type", {ids:ids}, function( data ) {
        });       
      });           
    }    

    <?php if( isset($load_chart_js) ){ ?>      
      var areaChartData = {
        labels: [<?php echo implode(",", $chart_labels) ?>],
        datasets: [
          {
            label: "Leads",
            fillColor: "#4b94c0",
            strokeColor: "#4b94c0",
            pointColor: "#4b94c0",
            pointStrokeColor: "#c1c7d1",
            pointHighlightFill: "#fff",
            pointHighlightStroke: "rgba(220,220,220,1)",
            data: [<?php echo implode(",", $chart_data) ?>]
          }
        ]
      };

      //-------------
      //- BAR CHART -
      //-------------
      var barChartCanvas = $("#barChart").get(0).getContext("2d");
      var barChart = new Chart(barChartCanvas);
      var barChartData = areaChartData;      
      var barChartOptions = {
        //Boolean - Whether the scale should start at zero, or an order of magnitude down from the lowest value
        scaleBeginAtZero: true,
        //Boolean - Whether grid lines are shown across the chart
        scaleShowGridLines: true,
        //String - Colour of the grid lines
        scaleGridLineColor: "rgba(0,0,0,.05)",
        //Number - Width of the grid lines
        scaleGridLineWidth: 1,
        //Boolean - Whether to show horizontal lines (except X axis)
        scaleShowHorizontalLines: true,
        //Boolean - Whether to show vertical lines (except Y axis)
        scaleShowVerticalLines: true,
        //Boolean - If there is a stroke on each bar
        barShowStroke: true,
        //Number - Pixel width of the bar stroke
        barStrokeWidth: 2,
        //Number - Spacing between each of the X value sets
        barValueSpacing: 5,
        //Number - Spacing between data sets within X values
        barDatasetSpacing: 1,
        //String - A legend template
        legendTemplate: "<ul class=\"<%=name.toLowerCase()%>-legend\"><% for (var i=0; i<datasets.length; i++){%><li><span style=\"background-color:<%=datasets[i].fillColor%>\"></span><%if(datasets[i].label){%><%=datasets[i].label%><%}%></li><%}%></ul>",
        //Boolean - whether to make the chart responsive
        responsive: true,
        maintainAspectRatio: true
      };

      barChartOptions.datasetFill = false;
      barChart.Bar(barChartData, barChartOptions);
    <?php } ?>

</script>

<script>
  $.widget.bridge('uibutton', $.ui.button);
</script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.4/jquery.min.js"></script>
<?php 
  echo $this->Html->script('bootstrap/js/bootstrap.min.js');
  echo $this->Html->script('jquery.ui.touch-punch.min.js');
  echo $this->Html->script('app/raphael.min.js'); 
  echo $this->Html->script('plugins/morris/morris.min.js');
  echo $this->Html->script('plugins/sparkline/jquery.sparkline.min.js');
  echo $this->Html->script('plugins/datepicker/bootstrap-datepicker.js');
  echo $this->Html->script('ckeditor/ckeditor', array('inline' => false));

  echo $this->Html->script('plugins/slimScroll/jquery.slimscroll.min.js');
  echo $this->Html->script('plugins/fastclick/fastclick.js');
  echo $this->Html->script('dist/js/app.min.js');

  if( isset($enable_fancy_box) ){
    echo $this->Html->css('jquery.fancybox.min.css');
    echo $this->Html->script('jquery.fancybox.min.js');    
  }

  if( isset($enable_tags_input) ){
    echo $this->Html->css('tagsinput/bootstrap-tagsinput.css');
    echo $this->Html->script('tagsinput/bootstrap-tagsinput.js');     
  }
  
  if( isset($enable_jscript_datatable) ){
    //echo $this->Html->script('jquery.dataTables.min.js');
    //echo $this->Html->css('jquery.dataTables.min.css');
    echo '<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.19/css/jquery.dataTables.min.css"/>';
    echo '<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/fixedheader/3.1.5/css/fixedHeader.dataTables.min.css"/>';
    echo '<script type="text/javascript" src="https://cdn.datatables.net/v/dt/dt-1.10.18/fc-3.2.5/fh-3.1.4/datatables.min.js"></script>';
  }
 
  /*echo $this->Html->script('dist/js/demo.js');    
  echo $this->Html->script('plugins/input-mask/jquery.inputmask.js');
  echo $this->Html->script('plugins/input-mask/jquery.inputmask.date.extensions.js');
  echo $this->Html->script('plugins/input-mask/jquery.inputmask.extensions.js');
  echo $this->Html->script('plugins/iCheck/icheck.min.js');*/
  
  echo $this->Html->script('validator.min.js');   
?>

<?php if( isset($enable_jscript_datatable) ){ ?>
        <script type="text/javascript">
          $(document).ready(function() {
              var table = $('#example_datatable').DataTable( {
                  fixedHeader: {
                      header: true,
                      footer: true
                  }
              } );
          } );    
        </script>
<?php } ?>

<script type="text/javascript"> 

var base_url = "<?= $base_url; ?>";
$(function(){
  var date = new Date(<?php echo time() * 1000 ?>);  
  var d = new Date("<?php echo date("Y-m-d H:i:s"); ?>");        

    setInterval(function(){ 
        d.setSeconds(d.getSeconds() + 1);            
        var n = d.toDateString();
        var time = d.toLocaleTimeString();        
        $("#system-time").html(n + ' ' + time);
    },1000);

  //Tags input
  <?php if( isset($enable_tags_input) ){ ?>   
    $('#tags-other-emails').tagsinput({
      itemText: 'Type Email',
      confirmKeys: [188],
      allowDuplicates: false,
      trimValue: true
    });

    $('#csv-recipient').tagsinput({
      itemText: 'Type Email',
      confirmKeys: [188],
      allowDuplicates: false,
      trimValue: true
    }); 

    $('#tags-emails').tagsinput({
      itemText: 'Type Email',
      confirmKeys: [188],
      allowDuplicates: false,
      trimValue: true
    });
  <?php } ?>
  //Sortable
  /*
  $( ".sortable-rows" ).sortable({
    tolerance: 'pointer',
    helper: 'clone',
    placeholder: 'ui-state-highlight',
    forceHelperSize: true,
    update: function() {          
      var target_url = $("#target-url").val();
      var order = $(this).sortable("serialize"); 
      $.post(base_url + target_url, order, function(theResponse){
      });
    }
  });
  */

  /*
  $( ".sortable-div" ).sortable({
    tolerance: 'pointer',
    helper: 'clone',
    placeholder: 'ui-state-highlight',
    forceHelperSize: true,
    update: function() {          
      var target_url = $("#target-url").val();
      var order = $(this).sortable("serialize"); 
      $.post(base_url + target_url, order, function(theResponse){
      });
    }
  });
  */

  $("#send_secondary_email_notification").change(function() {
    /*if(this.checked) {
      $(".source-users").removeClass("hidden");
    }else{
      $(".source-users").addClass("hidden");
    }*/
  });

   $("#send_specific_notification").change(function() {
    if(this.checked) {
      var source_id = $("#source_id").val();
      ajax_load_source_users(source_id);
    }else{
      $(".source-users").html("");
    }
  });

  $(".followup-lead-recipient-list").click(function(){    
    var source_id = $("#source_id").val();
    var lead_id   = $("#lead_id").val();
    var url = base_url + "source_users/ajax_load_followup_source_users";
    $(".followup-source-users").html("loading source users...");
    $.ajax({
           type: "POST",
           url: url,     
           data: {"source_id":source_id, "lead_id":lead_id}, 
           success: function(o)
           {
              $(".followup-source-users").html(o);
           }
    });
  });

  $("#source_id").change(function(){
    var source_id = $(this).val();
    source_settings(source_id);
    $("#send_specific_notification").prop("checked", false);
    $(".source-users").html("");
    
  });

  $(".opt-willing-to-review").change(function(){
    var selected = $(this).val();
    if( selected == 1 ){
      $(".grp-willing-review-date").removeClass("hidden");
    }else{
      $(".grp-willing-review-date").addClass("hidden");
    }
  });

  function source_settings( source_id ){
    var url = base_url + "sources/json_get_source_settings";
    $.ajax({
           type: "POST",
           url: url,     
           data: {"source_id":source_id}, 
           dataType: 'json', 
           success: function(o)
           {
              $('#send_secondary_email_notification').attr('checked', false);              
              if( o.is_enabled_secondary_notification == 1 ){
                $("#send_secondary_email_notification").removeAttr("disabled");
              }else{
                $("#send_secondary_email_notification").attr("disabled", true);
              }

              if( o.is_va == 1 ){
                $(".va-group").removeClass("hidden");
              }else{
                $(".va-group").addClass("hidden");
              }
           }
    });
  }

  function enable_disable_secondary_email_notification( source_id ){
    var url = base_url + "sources/json_enable_disable_secondary_email";
    $.ajax({
           type: "POST",
           url: url,     
           data: {"source_id":source_id}, 
           dataType: 'json', 
           success: function(o)
           {
              $('#send_secondary_email_notification').attr('checked', false);              
              if( o.is_enabled == 1 ){
                $("#send_secondary_email_notification").removeAttr("disabled");
              }else{
                $("#send_secondary_email_notification").attr("disabled", true);
              }
           }
    });
  }

  function ajax_load_source_users( source_id ){
    var url = base_url + "source_users/ajax_load_source_users";
    $(".source-users").html("loading source users...");
    $.ajax({
           type: "POST",
           url: url,     
           data: {"source_id":source_id}, 
           success: function(o)
           {
              $(".source-users").html(o);
           }
    });
  }

  <?php if( isset($load_source_users) ){ ?>
    ajax_load_source_users( $("#source_id").val() );
  <?php } ?>

  $(".attachment-add-row").click(function(){
    var rowCount = $('.lead-attachments tr').length + 1;
    if ( $(".lead-attachments tr").hasClass("rowAttachment" + rowCount) ) {
      var rowCount = rowCount+1;
    }
    var rowLable = "<td>&nbsp;</td>";
    var rowAttachment = "<td><input type='file' name='attachments[]'' /></td>";
    var col_delete = "<td><a class='btn btn-danger attachment-delete-row' href='javascript:void(0);'><i class='fa fa-trash'></i></a></td>";
    var add_row  = "<tr class='rowAttachment" + rowCount + "'>" + rowLable + rowAttachment + col_delete + "</tr>";

    $('.lead-attachments tr:last').after(add_row);   

    $(".attachment-delete-row").click(function(){
      $(this).closest('tr').remove();
    }); 
  });

  $(".current-attachment-delete-row").click(function(){
    $(this).closest('tr').remove();
  }); 

  $(".leads-delete-multiple").click(function(){
    $("#multi-leads").submit();
  });

  //Users
  $(".btn-show-more-sources").click(function(){   
    var data_id = 'source-item-' + $(this).attr('data-id'); 
    if( $("." + data_id).hasClass("hidden") ){
      $("." + data_id).removeClass("hidden"); 
    }else{
      $("." + data_id).addClass("hidden"); 
    }  
  });

  $(".btn-show-more-users").click(function(){   
    var data_id = 'user-item-' + $(this).attr('data-id'); 
    if( $("." + data_id).hasClass("hidden") ){
      $("." + data_id).removeClass("hidden"); 
    }else{
      $("." + data_id).addClass("hidden"); 
    }  
  });

  

  //Date picker       
  $('.default-datepicker').datepicker({
    format: 'd MM, yyyy',
    autoclose: true
  });

  $('.inline-datepicker-from').datepicker({
    format: 'yyyy-mm-dd',
    autoclose: true
  });
  $('.inline-datepicker-from').on('changeDate', function(event) { 
    var selected_date = $(this).datepicker('getFormattedDate');
    $(".date_from").val(selected_date);
  });
  $('.inline-datepicker-to').on('changeDate', function(event) { 
    var selected_date = $(this).datepicker('getFormattedDate');
    $(".date_to").val(selected_date);
  });

  $('.input-group.date').datepicker({format: 'yyyy-mm-dd',});

  $('.inline-datepicker-to').datepicker({
    format: 'yyyy-mm-dd',
    autoclose: true
  });

  $('.allocation-datepicker').datepicker({
    format: 'd MM, yyyy',
    autoclose: true
  });

  $('#lead-followup-date').datepicker({
    format: 'd MM, yyyy',
    autoclose: true,
    startDate: $("#lead-allocation-date").val()
  });

  $('#lead-followup-action-reminder-date').datepicker({
    format: 'd MM, yyyy',
    autoclose: true,
    startDate: $("#lead-allocation-date").val()
  });

  //Leads
  $("#lead-allocation-date").on("changeDate", function (ev) {
      var oldDate = new Date(ev.date);
      var newDate = new Date(oldDate.getFullYear(),oldDate.getMonth(),oldDate.getDate()+1);      
      $("#lead-followup-date").datepicker("setStartDate",new Date(oldDate.getFullYear(),oldDate.getMonth(),oldDate.getDate()+1));    
      //$("#lead-followup-date").datepicker("setDate",new Date(oldDate.getFullYear(),oldDate.getMonth(),oldDate.getDate()+1));       
      $("#lead-followup-action-reminder-date").datepicker("setStartDate",new Date(oldDate.getFullYear(),oldDate.getMonth(),oldDate.getDate()+1));       
      //$("#lead-followup-action-reminder-date").datepicker("setDate",new Date(oldDate.getFullYear(),oldDate.getMonth(),oldDate.getDate()+1));          
      //$("#lead-followup-date").focus();
  });

  $('.has-ck-finder').click(function(){
    openKCFinder_textbox($(this));
  });

  $('.has-ck-finder-sub').click(function(){
    openKCFinder_textbox_sub($(this));
  });

  //Sidebar widget settings
  $("#side-widget-push-notification").click(function(){
    if( $(this).is(':checked') ){
      var enable_push_notification = 1;
    }else{
      var enable_push_notification = 0;
    }
      $.ajax({
             type: "POST",                  
             url: base_url + 'user_settings/ajax_update_member_push_notification',      
             data: {enable_push_notification:enable_push_notification},    
             dataType: "JSON",                                         
             success: function(o)
             {
                                                          
             }
      });
  });

  /*
  $(".todo-list").sortable({
    placeholder: "sort-highlight",
    handle: ".handle",
    forcePlaceholderSize: true,
    zIndex: 999999
  });
  */

    $(document).ready(function(){
        /*$("#hide_note").click(function(){
            $("#status_note").toggle();
        });*/

        $("#hide_note").click(function(){
            $("#status_note").hide();
            $("#hide_note").hide();
            $("#show_note").show();             
        });
        $("#show_note").click(function(){
            $("#status_note").show();
            $("#hide_note").show();
            $("#show_note").hide();           
        });  

        $("#hide_enotif_history").click(function(){
            $("#email_notif_history").hide();
            $("#hide_enotif_history").hide();
            $("#show_enotif_history").show();             
        });  
        $("#show_enotif_history").click(function(){
            $("#email_notif_history").show();
            $("#hide_enotif_history").show();
            $("#show_enotif_history").hide();           
        });
    });

});
CKEDITOR.replace( 'ckeditor', {
      width: '100'
    });

function openKCFinder_textbox(field) {    

  window.KCFinder = {
      callBack: function(url) {
        var filename= url.split('/').pop()
        var clean_filename = filename.replace(new RegExp("%20", 'g')," ");

        var extension = clean_filename.split('.').pop().toUpperCase();
        /*if (extension == "PNG" || extension == "JPG" || extension == "JPEG" || extension == "BMP"){
          $(".img-attachment").attr("src",url);
        }else{
          $(".img-attachment").attr("src",DEFAULT_IMG);
        }*/

        $("#logo").val(clean_filename);            
        field.val(url);
      }
  };
  window.open(base_url+'js/kcfinder/browse.php?dir=files', 'kcfinder_textbox',
      'status=0, toolbar=0, location=0, menubar=0, directories=0, ' +
      'resizable=1, scrollbars=0, width=800, height=600'
  );
}

function openKCFinder_textbox_sub(field) {    

  window.KCFinder = {
      callBack: function(url) {
        var filename= url.split('/').pop()
        var clean_filename = filename.replace(new RegExp("%20", 'g')," ");

        var extension = clean_filename.split('.').pop().toUpperCase();
        /*if (extension == "PNG" || extension == "JPG" || extension == "JPEG" || extension == "BMP"){
          $(".img-attachment").attr("src",url);
        }else{
          $(".img-attachment").attr("src",DEFAULT_IMG);
        }*/

        $("#logo2").val(clean_filename);            
        field.val(url);
      }
  };
  window.open(base_url+'js/kcfinder/browse.php?dir=files', 'kcfinder_textbox',
      'status=0, toolbar=0, location=0, menubar=0, directories=0, ' +
      'resizable=1, scrollbars=0, width=800, height=600'
  );
}

</script>

</body>
</html>