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

#source-table table { width: 100%; }

#source-table thead, #source-table tbody, #source-table tr, #source-table td, #source-table th { display: block; }

#source-table tr:after {
    content: ' ';
    display: block;
    visibility: hidden;
    clear: both;
}

#source-table thead th {
    height: 50px;

    /*text-align: left;*/
}

#source-table tbody {
    height: 250px;
    overflow-y: auto;
}

#source-table thead {
    /* fallback */
}


#source-table tbody td, #source-table thead th {
    width: 95px;
    float: left;
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
                          <th style="width:65%;"><?= $this->Paginator->sort('name', __("Name") . "<i class='fa fa-sort pull-right'> </i>", array('escape' => false)) ?></th>
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
                          <th style="width:80%;"><?= $this->Paginator->sort('name', __("Name") . "<i class='fa fa-sort pull-right'> </i>", array('escape' => false)) ?></th>
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
    <!-- 
    <div class="col-md-12">
      <div class="box box-primary box-solid"> 
        <div class="box-header with-border">  
            <div class="user-block"><h2><i class="fa fa-list-alt"></i> <?= __('Sources') ?></h2></div>            
            <div class="box-tools" style="top:9px;">                                         
                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>                        
            </div>         
        </div>     
        <div class="box-body box-links">
            <table id="dt-users-list" class="table table-hover table-striped table-scroll-body">
                <thead class="thead-inverse">
                    <tr>
                        <th style=""><?= $this->Paginator->sort('name', __("Name") . "<i class='fa fa-sort pull-right'> </i>", array('escape' => false)) ?></th>
                        <?php foreach($statuses as $status) { ?>
                                <th style=""><?= $this->Paginator->sort($status->name, $status->name . "<i class='fa fa-sort pull-right'> </i>", array('escape' => false)) ?></th>
                        <?php } ?>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach($sources as $s) { ?>
                            <tr>
                                <td><?= $this->Html->link($s->name, ['controller' => 'leads', 'action' => 'from_source', $s->id],['escape' => false, 'target' => '_blank']) ?></td>
                                <?php foreach($statuses as $status) { ?>
                                        <?php 
                                            $total_leads_per_source_status = $lead_registry->find('all')        
                                                ->contain(['LastModifiedBy'])        
                                                ->where(['Leads.source_id' => $s->id])
                                                ->andWhere(['Leads.status_id' => $status->id])
                                                ->count()
                                            ;                                          
                                        ?>
                                        <td><?php echo $total_leads_per_source_status; ?></td>
                                <?php } ?>                                
                            </tr>
                    <?php } ?>
                </tbody>
            </table>                               
        </div>

      </div>
    </div>
    -->
  
    <div class="col-md-12">
      <div class="box box-primary box-solid"> 
        <div class="box-header with-border">  
            <div class="user-block"><h2><i class="fa fa-list-alt"></i> <?= __('Sources') ?></h2></div>            
            <div class="box-tools" style="top:9px;">                                         
                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>                        
            </div>         
        </div>     
        <div class="box-body box-links">
            <table id="example_datatable" class="table table-hover table-striped table-scroll-body">
                <thead class="thead-inverse freeze-head">
                    <tr>
                        <th style="">Name</th>
                        <?php foreach($statuses as $status) { ?>
                                <?php 
                                  $key_information = "No Description";
                                  if($status->description != '') {
                                    $key_information = $status->description;
                                  }
                                ?>
                                <th style=""><div data-balloon="<?php echo $key_information; ?>" data-balloon-pos="up"><?= $status->name ?></div></th>
                        <?php } ?>
                    </tr>
                </thead>
                <tbody class="freeze-body" style="overflow-y: scroll;overflow-x: scroll;">
                    <?php foreach($sourcesd as $s) { ?>
                            <tr>
                                <td><?= $this->Html->link($s->name, ['controller' => 'leads', 'action' => 'from_source', $s->id],['escape' => false, 'target' => '_blank']) ?></td>
                                <?php foreach($statuses as $status) { ?>
                                        <?php 
                                            $total_leads_per_source_status = $lead_registry->find('all')        
                                                ->contain(['LastModifiedBy'])
                                                ->where(['Leads.is_archive' => 'No']) 
                                                ->andwhere(['Leads.source_id' => $s->id])
                                                ->andWhere(['Leads.status_id' => $status->id])
                                                ->count()
                                            ;                                          
                                        ?>
                                        <td><?php echo $total_leads_per_source_status; ?></td>
                                <?php } ?>                                
                            </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
      </div>
    </div>  
    <!-- Sources List - End -->      

<!-- 
<div class="col-md-12">
  <div class="box box-primary box-solid">  

    <div class="box-header with-border">  
        <div class="user-block"><h2><i class="fa fa-list-alt"></i> <?= __('Sources') ?></h2></div>            
        <div class="box-tools" style="top:9px;">                                         
            <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>                        
        </div>         
    </div>  
    <div class="box-body box-links" style="">

      <table id="source-table" class="table table-striped">
          <thead>
          <tr>
            <th style="">Name</th>
            <?php foreach($statuses as $status) { ?>
                    <?php 
                      $key_information = "No Description";
                      if($status->description != '') {
                        $key_information = $status->description;
                      }
                    ?>
                    <th style=""><div data-balloon="<?php echo $key_information; ?>" data-balloon-pos="down"><?= $status->name ?></div></th>
            <?php } ?>
          </tr>
          </thead>
          <tbody>
          <tr>
                <td><?= $this->Html->link($s->name, ['controller' => 'leads', 'action' => 'from_source', $s->id],['escape' => false, 'target' => '_blank']) ?></td>
                <?php foreach($statuses as $status) { ?>
                        <?php 
                            $total_leads_per_source_status = $lead_registry->find('all')        
                                ->contain(['LastModifiedBy'])        
                                ->where(['Leads.source_id' => $s->id])
                                ->andWhere(['Leads.status_id' => $status->id])
                                ->count()
                            ;                                          
                        ?>
                        <td><?php echo $total_leads_per_source_status; ?></td>
                <?php } ?>     
          </tr>
          <?php foreach($sourcesd as $s) { ?>
                  <tr>
                      <td><?= $this->Html->link($s->name, ['controller' => 'leads', 'action' => 'from_source', $s->id],['escape' => false, 'target' => '_blank']) ?></td>
                      <?php foreach($statuses as $status) { ?>
                              <?php 
                                  $total_leads_per_source_status = $lead_registry->find('all')        
                                      ->contain(['LastModifiedBy'])        
                                      ->where(['Leads.source_id' => $s->id])
                                      ->andWhere(['Leads.status_id' => $status->id])
                                      ->count()
                                  ;                                          
                              ?>
                              <td><?php echo $total_leads_per_source_status; ?></td>
                      <?php } ?>                                
                  </tr>
          <?php } ?>
          </tbody>
      </table>

    </div>
  </div>
</div>
-->  
</section>
<!-- /.content -->
