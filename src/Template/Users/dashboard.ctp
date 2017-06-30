<?php use Cake\Utility\Inflector; ?>
<style>
.user-block h2{
  font-size: 14px;
  margin: 3px;
}
</style>
<script>
var BASE_URL = "<?php echo $base_url; ?>";
</script><!-- Main content -->
<section class="content">
  <!-- Info boxes -->
  <div class="row">
    <div class="col-md-3 col-sm-6 col-xs-12">
      <div class="info-box">
        <span class="info-box-icon bg-aqua"><i class="fa fa-user-plus"></i></span>

        <div class="info-box-content">
          <span class="info-box-text">Total Leads</span>
          <span class="info-box-number"><?php echo number_format($total_leads,2); ?></span>
        </div>
        <!-- /.info-box-content -->
      </div>
      <!-- /.info-box -->
    </div>
    <!-- /.col -->
    <div class="col-md-3 col-sm-6 col-xs-12">
      <div class="info-box">
        <span class="info-box-icon bg-red"><i class="fa fa-users"></i></span>

        <div class="info-box-content">
          <span class="info-box-text">Total Users</span>
          <span class="info-box-number"><?php echo number_format($total_users,2); ?></span>
        </div>
        <!-- /.info-box-content -->
      </div>
      <!-- /.info-box -->
    </div>
    <!-- /.col -->

    <div class="clearfix visible-sm-block"></div>

    <!--
    <div class="col-md-3 col-sm-6 col-xs-12">
      <div class="info-box">
        <span class="info-box-icon bg-green"><i class="fa fa-briefcase"></i></span>
        <div class="info-box-content">
          <span class="info-box-text">Total</span>
          <span class="info-box-number">0</span>
        </div>
      </div>
    </div>
    -->

    <!--
    <div class="col-md-3 col-sm-6 col-xs-12">
      <div class="info-box">
        <span class="info-box-icon bg-yellow"><i class="fa fa-black-tie"></i></span>

        <div class="info-box-content">
          <span class="info-box-text">Total</span>
          <span class="info-box-number">0</span>
        </div>
      </div>
    </div>
    -->

  </div>

  <!-- Pages -->
  <div class="row">    
    <div class="col-md-8">
    </div>
  </div>
  <!-- End Services -->

</section>
<!-- /.content -->
