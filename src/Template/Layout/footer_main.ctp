    </div><!-- #wrapper -->
    <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
      <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span><small>esc</small></button>
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">            
            <h2 class="modal-title" id="myModalLabel">Modal title</h2>
          </div>
          <div class="modal-body">
            <p>It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. The point of using Lorem Ipsum is that it has a more-or-less normal distribution of letters, as opposed to using 'Content here, content here', making it look like readable English. Many desktop publishing packages and web page editors now use Lorem Ipsum as their default model text, and a search for 'lorem ipsum' will uncover many web sites still in their infancy. Various versions have evolved over the years, sometimes by accident, sometimes on purpose (injected humour and the like).</p>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            <button type="button" class="btn btn-primary">Save changes</button>
          </div>
        </div>
      </div>
    </div>
<?php echo $this->Html->script('jquery.min.js'); ?>
<?php echo $this->Html->script('bootstrap.min'); ?>
<?php echo $this->Html->script('app'); ?>
</body>
</html>

<script>
  $(function(){
    $('#customer_email').change(function(){
      var email = $(this).val();
      var url = '<?php echo $base_url; ?>/customer/validate_email'; 
      $.post(url,{email:email},
          function(o){
            //$('#total-amount-holder').html(o.total_amount);
            if(o.is_available == 1) {
              $('#message-handler').html('<div class="alert alert-danger" style="padding:7px; font-size:15px;"><i class="fa fa-warning"></i> Email address already exist</div>');
              $('.btn-customer-register').attr('disabled', 'disabled');
            }else{
              $('#message-handler').html('<div class="alert alert-success" style="padding:7px; font-size:15px;"><i class="fa fa-info-circle"></i> Available</div>');
              $('.btn-customer-register').removeAttr('disabled');
            }
      },"json");
    });
  });
</script>