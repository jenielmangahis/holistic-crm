<?php ?>
<style>
.user-block h2{
  font-size: 14px;
  margin: 3px;
}
.box-links {
  width:100%;
  overflow-y: auto;
  height: 300px;  
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
    <div class="col-md-3 col-sm-6 col-xs-12">
      <div class="info-box">
        <span class="info-box-icon bg-red"><i class="fa fa-calendar"></i></span>

        <div class="info-box-content">
          <span class="info-box-text">Total Leads for followup today</span>
          <span class="info-box-number"><?php echo number_format($total_leads_followup,2); ?></span>
        </div>
        <!-- /.info-box-content -->
      </div>
      <!-- /.info-box -->
    </div>
    <!-- /.col -->
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

  <!-- Leads -->
  <div class="row">       
    <div class="col-md-12">
      <div class="box box-primary box-solid">   
          <div class="box-header with-border">  
              <div class="user-block"><h2><i class="fa fa-user"></i> <?= __('Newly created leads (today)') ?></h2></div>            
              <div class="box-tools" style="top:9px;">                                         
                  <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>                        
              </div>         
          </div>             
          <div class="box-body">                    
              <table id="dt-users-list" class="table table-hover table-striped">
                  <thead class="thead-inverse">
                      <tr>
                          <th class="actions"></th>
                          <th style="width:10%;"><?= $this->Paginator->sort('id', __("Id") . "<i class='fa fa-sort pull-right'> </i>", array('escape' => false)) ?></th>
                          <th style="width:75%;"><?= $this->Paginator->sort('name', __("Name") . "<i class='fa fa-sort pull-right'> </i>", array('escape' => false)) ?></th>                                                             
                          <th style="width:15%;"><?= $this->Paginator->sort('is_lock', __("Is Lock") . "<i class='fa fa-sort pull-right'> </i>", array('escape' => false)) ?></th>                                                                                     
                      </tr>
                  </thead>
                  <tbody>
                      <?php foreach ($new_leads as $lead): ?>
                      <tr>
                          <td class="table-actions">
                              <div class="dropdown">
                                  <button class="btn btn-default dropdown-toggle" type="button" id="drpdwn" data-toggle="dropdown" aria-expanded="true">
                                      Action <span class="caret"></span>
                                  </button>
                                  <ul class="dropdown-menu" role="menu" aria-labelledby="drpdwn">                                                                                                               
                                      <li role="presentation"><?= $this->Html->link('<i class="fa fa-pencil"></i> Edit', ['controller' => 'leads', 'action' => 'edit', $lead->id, 'dashboard'],['escape' => false]) ?></li>                                    
                                  </ul>
                              </div>                                               
                          </td>
                          <td><?= $this->Number->format($lead->id) ?></td>
                          <td><?= h($lead->firstname . ' ' . $lead->surname) ?></td>
                          <td>
                              <?php if($lead->is_lock == 1){ ?>
                                      <div class="btn btn-warning">Lock by: <strong><?php echo $lead->last_modified_by->username; ?></strong> </div>
                              <?php }?>
                          </td>

                      </tr>
                      <?php endforeach; ?>
                  </tbody>
              </table>                               
          </div>
      </div>
    </div>

    <div class="col-md-12">
      <div class="box box-primary box-solid">   
          <div class="box-header with-border">  
              <div class="user-block"><h2><i class="fa fa-calendar"></i> <?= __('For Follow-up Leads Today') ?></h2></div>            
              <div class="box-tools" style="top:9px;">                                         
                  <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>                        
              </div>         
          </div>             
          <div class="box-body">                    
              <table id="dt-users-list" class="table table-hover table-striped">
                  <thead class="thead-inverse">
                      <tr>
                          <th class="actions"></th>
                          <th style="width:10%;"><?= $this->Paginator->sort('id', __("Id") . "<i class='fa fa-sort pull-right'> </i>", array('escape' => false)) ?></th>
                          <th style="width:90%;"><?= $this->Paginator->sort('name', __("Name") . "<i class='fa fa-sort pull-right'> </i>", array('escape' => false)) ?></th>
                          <th style="width:15%;"><?= $this->Paginator->sort('is_lock', __("Is Lock") . "<i class='fa fa-sort pull-right'> </i>", array('escape' => false)) ?></th>
                      </tr>
                  </thead>
                  <tbody>
                      <?php foreach ($followup_leads_today as $flead): ?>
                      <tr>
                          <td class="table-actions">
                              <div class="dropdown">
                                  <button class="btn btn-default dropdown-toggle" type="button" id="drpdwn" data-toggle="dropdown" aria-expanded="true">
                                      Action <span class="caret"></span>
                                  </button>
                                  <ul class="dropdown-menu" role="menu" aria-labelledby="drpdwn">                                                                                                               
                                      <li role="presentation"><?= $this->Html->link('<i class="fa fa-pencil"></i> Edit', ['controller' => 'leads', 'action' => 'edit', $flead->id, 'dashboard'],['escape' => false]) ?></li>                                    
                                  </ul>
                              </div>                                               
                          </td>
                          <td><?= $this->Number->format($flead->id) ?></td>
                          <td><?= h($flead->firstname . ' ' . $flead->surname) ?></td>                                                                        
                          <td>
                              <?php if($flead->is_lock == 1){ ?>
                                      <div class="btn btn-warning">Lock by: <strong><?php echo $flead->last_modified_by->username; ?></strong> </div>
                              <?php }?>
                          </td>
                      </tr>
                      <?php endforeach; ?>
                  </tbody>
              </table>                               
          </div>
      </div>
    </div>    
  <!-- End Leads -->

  <!-- Sources List -->
    <div class="col-md-12">
      <div class="box box-primary box-solid"> 
        <div class="box-header with-border">  
            <div class="user-block"><h2><i class="fa fa-list-alt"></i> <?= __('Sources') ?></h2></div>            
            <div class="box-tools" style="top:9px;">                                         
                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>                        
            </div>         
        </div>     

        <div class="box-body box-links">                    
            <table id="dt-users-list" class="table table-hover table-striped">
                <thead class="thead-inverse">
                    <tr>
                        <th style="width:100%;"><?= $this->Paginator->sort('name', __("Name") . "<i class='fa fa-sort pull-right'> </i>", array('escape' => false)) ?></th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach($sources as $s) { ?>
                            <tr>
                                <!-- <td><a target="_blank" href="lead_from_source"><?php echo $s->name; ?></a></td> -->
                                <td><?= $this->Html->link($s->name, ['controller' => 'leads', 'action' => 'from_source', $s->id],['escape' => false, 'target' => '_blank']) ?></td>
                            </tr>
                    <?php } ?>
                </tbody>
            </table>                               
        </div>

      </div>
    </div>
  <!-- Sources List - End -->

 

</section>
<!-- /.content -->
