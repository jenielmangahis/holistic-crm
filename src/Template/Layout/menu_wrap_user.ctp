<?php use Cake\Utility\Inflector; ?>
<?php 
    $nav_selected = $this->NavigationSelector->selectedMainNavigation($nav_selected[0]);
    if (!empty($sub_nav_selected)) {
        $sub_nav_selected = $this->NavigationSelector->selectedSubNavigation($sub_nav_selected['parent'],$sub_nav_selected['child']);
    }else{
        $sub_nav_selected = array();
    }
    
?>

<style>

  .sidebar .sidebar-menu .treeview-menu > li > a {
    margin-left: 26px !important;
  }

</style>

<?php
  use Cake\ORM\TableRegistry;
  $this->Groups = TableRegistry::get('Groups');      
  $group_details = $this->Groups->get($hdr_user_data->group_id, [
      'contain' => ['Users']
  ]);  

  if($group_details) { 
    $group_name = strtolower($group_details->name);
  } else {
    $group_name = '';
  }
?>

<?php
    $system_settings_active_action = 0;
    foreach($default_group_actions as $g_key => $g_data) {
        if($g_key == 'users' || $g_key == 'allocations' || $g_key == 'sources' || $g_key == 'groups' || $g_key == 'status' || $g_key == 'lead_type' || $g_key == 'interest_type' ) {
            if($g_data != 'No Access') {
                $system_settings_active_action++;
            }
        }
    }
?>

<aside class="main-sidebar">    
    <section class="sidebar">  
      <!-- Sidebar user panel -->
      <div class="user-panel">
        <div class="pull-left image">
          <?php 
            if( $hdr_user_data->photo != '' ){
                $hdr_user_photo = $this->Url->build("/webroot/upload/users/" . $hdr_user_data->id . "/" . $hdr_user_data->photo);            
            }else{                  
                $hdr_user_photo = $this->Url->build("/webroot/images/default_profile.jpg");
            }
          ?>
          <img src="<?php echo $hdr_user_photo; ?>" alt="User Avatar" class="img-circle" style="min-height:43px;margin-top:12px;">                    
        </div>
        <div class="pull-left info">
          <p><?php echo $hdr_user_data->firstname . " " . $hdr_user_data->lastname; ?></p>          
        </div>
      </div>
      <!-- search form -->
      <form action="#" method="get" class="sidebar-form">
        <div class="input-group">
          <input type="text" name="q" class="form-control" placeholder="Search...">
              <span class="input-group-btn">
                <button type="submit" name="search" id="search-btn" class="btn btn-flat"><i class="fa fa-search"></i>
                </button>
              </span>
        </div>
      </form>    
      <ul class="sidebar-menu">
        <li class="header">MAIN NAVIGATION</li>

        <?php if($hdr_user_data->group_id == 1 || $group_name == 'admin') { //Admin ?>
                <?php if($default_group_actions['dashboard'] != 'No Access') { ?>
                        <li id="groups_nav" title="Groups" class="<?= $nav_selected["dashboard"] ?>">
                            <?= $this->Html->link('<i class="fa fa-dashboard"></i><span>' . __("Dashboard") . "</span>",["controller" => "users", "action" => "dashboard"],["escape" => false]) ?>
                        </li>                     
                <?php } ?>
                <?php if($default_group_actions['leads'] != 'No Access') { ?>
                        <li id="groups_nav" title="Groups" class="<?= $nav_selected["leads"] ?>">
                            <?= $this->Html->link('<i class="fa fa-users"></i><span>' . __("Leads") . "</span>",["controller" => "leads", "action" => "index"],["escape" => false]) ?>
                        </li> 
                <?php } ?>

            <?php if($default_group_actions['training'] != 'No Access') { ?>
                        <li id="groups_nav" title="Groups" class="<?= $nav_selected["trainings"] ?>">
                            <?= $this->Html->link('<i class="fa fa-user-times"></i><span>' . __("Training") . "</span>",["controller" => "trainings", "action" => "index"],["escape" => false]) ?>
                        </li> 
            <?php } ?>

            <li id="groups_nav" title="Groups" class="treeview <?= $nav_selected["reports"] ?>">
              <a href="#">
                <i class="fa fa-sticky-note-o"></i> <span>Reports</span>
                <span class="pull-right-container">
                  <i class="fa fa-angle-left pull-right"></i>
                </span>
              </a>
              <ul class="treeview-menu">            
                <li><?= $this->Html->link('<i class="fa fa-users"></i><span>' . __("Report 1") . "</span>",["controller" => "", "action" => ""],["escape" => false]) ?></li>
              </ul>
            </li>

            <?php if($system_settings_active_action) { ?>
              <li id="groups_nav" title="Groups" class="treeview active <?php //echo $nav_selected["system_settings"] ?>">
                <a href="#">
                  <i class="fa fa-gear"></i> <span>System Settings</span>
                  <span class="pull-right-container">
                    <i class="fa fa-angle-left pull-right"></i>
                  </span>
                </a>
                <ul class="treeview-menu">            
                  <!-- 
                  <li><?= $this->Html->link('<i class="fa fa-users"></i><span>' . __("Users") . "</span>",["controller" => "users", "action" => "index"],["escape" => false]) ?></li>
                  <li><?= $this->Html->link('<i class="fa fa-circle-o"></i><span>' . __("Allocations") . "</span>",["controller" => "allocations", "action" => "index"],["escape" => false]) ?></li>
                  <li><?= $this->Html->link('<i class="fa fa-circle-o"></i><span>' . __("Sources") . "</span>",["controller" => "sources", "action" => "index"],["escape" => false]) ?></li>
                  <li><?= $this->Html->link('<i class="fa fa-circle-o"></i><span>' . __("Groups") . "</span>",["controller" => "groups", "action" => "index"],["escape" => false]) ?></li>
                  <li><?= $this->Html->link('<i class="fa fa-circle-o"></i><span>' . __("Status") . "</span>",["controller" => "statuses", "action" => "index"],["escape" => false]) ?></li>
                  <li><?= $this->Html->link('<i class="fa fa-circle-o"></i><span>' . __("Lead Type") . "</span>",["controller" => "lead_types", "action" => "index"],["escape" => false]) ?></li>
                  <li><?= $this->Html->link('<i class="fa fa-circle-o"></i><span>' . __("Interest Type") . "</span>",["controller" => "interest_types", "action" => "index"],["escape" => false]) ?></li> 
                  -->

                  <?php if($default_group_actions['users'] != 'No Access') { ?>
                          <li><?= $this->Html->link('<i class="fa fa-users"></i><span>' . __("Users") . "</span>",["controller" => "users", "action" => "index"],["escape" => false]) ?></li>
                  <?php } ?>
                  <?php if($default_group_actions['sources'] != 'No Access') { ?>
                          <li><?= $this->Html->link('<i class="fa fa-circle-o"></i><span>' . __("Sources") . "</span>",["controller" => "sources", "action" => "index"],["escape" => false]) ?></li>
                  <?php } ?>

                  <?php if($default_group_actions['groups'] != 'No Access') { ?>
                          <li><?= $this->Html->link('<i class="fa fa-circle-o"></i><span>' . __("Groups") . "</span>",["controller" => "groups", "action" => "index"],["escape" => false]) ?></li>
                  <?php } ?>

                  <?php if($default_group_actions['status'] != 'No Access') { ?>
                          <li><?= $this->Html->link('<i class="fa fa-circle-o"></i><span>' . __("Status") . "</span>",["controller" => "statuses", "action" => "index"],["escape" => false]) ?></li>
                  <?php } ?>

                  <?php if($default_group_actions['lead_type'] != 'No Access') { ?>
                          <li><?= $this->Html->link('<i class="fa fa-circle-o"></i><span>' . __("Lead Type") . "</span>",["controller" => "lead_types", "action" => "index"],["escape" => false]) ?></li>
                  <?php } ?>

                  <?php if($default_group_actions['interest_type'] != 'No Access') { ?>
                          <li><?= $this->Html->link('<i class="fa fa-circle-o"></i><span>' . __("Interest Type") . "</span>",["controller" => "interest_types", "action" => "index"],["escape" => false]) ?></li>
                  <?php } ?>

                </ul>
              </li>
            <?php } ?>
        <?php }elseif($hdr_user_data->group_id ==  3 || $group_name == 'staff') { //Staff ?>
                  <?php if($default_group_actions['dashboard'] != 'No Access') { ?>
                        <li id="groups_nav" title="Groups" class="<?= $nav_selected["dashboard"] ?>">
                            <?= $this->Html->link('<i class="fa fa-dashboard"></i><span>' . __("Dashboard") . "</span>",["controller" => "users", "action" => "dashboard"],["escape" => false]) ?>
                        </li>
                  <?php } ?>
                  <?php if($default_group_actions['leads'] != 'No Access') { ?>
                        <li id="groups_nav" title="Groups" class="<?= $nav_selected["leads"] ?>">
                            <?= $this->Html->link('<i class="fa fa-users"></i><span>' . __("Leads") . "</span>",["controller" => "leads", "action" => "index"],["escape" => false]) ?>
                        </li> 
                  <?php } ?>

            <?php if($default_group_actions['training'] != 'No Access') { ?>
                  <li id="groups_nav" title="Groups" class="<?= $nav_selected["trainings"] ?>">
                      <?= $this->Html->link('<i class="fa fa-user-times"></i><span>' . __("Training") . "</span>",["controller" => "trainings", "action" => "users"],["escape" => false]) ?>
                  </li> 
            <?php } ?>

            <li id="groups_nav" title="Groups" class="treeview <?= $nav_selected["reports"] ?>">
              <a href="#">
                <i class="fa fa-sticky-note-o"></i> <span>Reports</span>
                <span class="pull-right-container">
                  <i class="fa fa-angle-left pull-right"></i>
                </span>
              </a>
              <ul class="treeview-menu">            
                <li><?= $this->Html->link('<i class="fa fa-users"></i><span>' . __("Report 1") . "</span>",["controller" => "", "action" => ""],["escape" => false]) ?></li>
              </ul>
            </li>

            <?php if($system_settings_active_action) { ?>
              <li id="groups_nav" title="Groups" class="treeview active <?php //echo $nav_selected["system_settings"] ?>">
                <a href="#">
                  <i class="fa fa-gear"></i> <span>System Settings</span>
                  <span class="pull-right-container">
                    <i class="fa fa-angle-left pull-right"></i>
                  </span>
                </a>
                <ul class="treeview-menu">            
                  
                  <!-- 
                  <li><?= $this->Html->link('<i class="fa fa-users"></i><span>' . __("Users") . "</span>",["controller" => "users", "action" => "index"],["escape" => false]) ?></li>
                  <li><?= $this->Html->link('<i class="fa fa-circle-o"></i><span>' . __("Allocations") . "</span>",["controller" => "allocations", "action" => "index"],["escape" => false]) ?></li>
                  <li><?= $this->Html->link('<i class="fa fa-circle-o"></i><span>' . __("Sources") . "</span>",["controller" => "sources", "action" => "index"],["escape" => false]) ?></li> 
                  -->

                  <?php if($default_group_actions['users'] != 'No Access') { ?>
                          <li><?= $this->Html->link('<i class="fa fa-users"></i><span>' . __("Users") . "</span>",["controller" => "users", "action" => "index"],["escape" => false]) ?></li>
                  <?php } ?>

                  <?php if($default_group_actions['allocations'] != 'No Access') { ?>
                          <li><?= $this->Html->link('<i class="fa fa-circle-o"></i><span>' . __("Clients") . "</span>",["controller" => "clients", "action" => "index"],["escape" => false]) ?></li>
                  <?php } ?>

                  <?php if($default_group_actions['sources'] != 'No Access') { ?>
                          <li><?= $this->Html->link('<i class="fa fa-circle-o"></i><span>' . __("Sources") . "</span>",["controller" => "sources", "action" => "index"],["escape" => false]) ?></li>
                  <?php } ?>

                  <?php if($default_group_actions['groups'] != 'No Access') { ?>
                          <li><?= $this->Html->link('<i class="fa fa-circle-o"></i><span>' . __("Groups") . "</span>",["controller" => "groups", "action" => "index"],["escape" => false]) ?></li>
                  <?php } ?>

                  <?php if($default_group_actions['status'] != 'No Access') { ?>
                          <li><?= $this->Html->link('<i class="fa fa-circle-o"></i><span>' . __("Status") . "</span>",["controller" => "statuses", "action" => "index"],["escape" => false]) ?></li>
                  <?php } ?>

                  <?php if($default_group_actions['lead_type'] != 'No Access') { ?>
                          <li><?= $this->Html->link('<i class="fa fa-circle-o"></i><span>' . __("Lead Type") . "</span>",["controller" => "lead_types", "action" => "index"],["escape" => false]) ?></li>
                  <?php } ?>

                  <?php if($default_group_actions['interest_type'] != 'No Access') { ?>
                          <li><?= $this->Html->link('<i class="fa fa-circle-o"></i><span>' . __("Interest Type") . "</span>",["controller" => "interest_types", "action" => "index"],["escape" => false]) ?></li>
                  <?php } ?>

                </ul>
              </li>
            <?php } ?>

        <?php }else{ ?>

            <?php if($default_group_actions['dashboard'] != 'No Access') { ?>
              <li id="groups_nav" title="Groups" class="<?= $nav_selected["dashboard"] ?>">
                  <?= $this->Html->link('<i class="fa fa-dashboard"></i><span>' . __("Dashboard") . "</span>",["controller" => "users", "action" => "user_dashboard"],["escape" => false]) ?>
              </li>                     
            <?php } ?>

            <?php if($default_group_actions['leads'] != 'No Access') { ?>
              <li id="groups_nav" title="Groups" class="<?= $nav_selected["leads"] ?>">
                  <?= $this->Html->link('<i class="fa fa-users"></i><span>' . __("Leads") . "</span>",["controller" => "user_leads", "action" => "index"],["escape" => false]) ?>
              </li> 
            <?php } ?>

            <?php if($default_group_actions['training'] != 'No Access') { ?>
            <li id="groups_nav" title="Groups" class="<?= $nav_selected["trainings"] ?>">
                <?= $this->Html->link('<i class="fa fa-user-times"></i><span>' . __("Training") . "</span>",["controller" => "trainings", "action" => "users"],["escape" => false]) ?>
            </li> 
            <?php } ?>

            <!-- Another -->            
            <li id="groups_nav" title="Groups" class="treeview <?= $nav_selected["reports"] ?>">
              <a href="#">
                <i class="fa fa-sticky-note-o"></i> <span>Reports</span>
                <span class="pull-right-container">
                  <i class="fa fa-angle-left pull-right"></i>
                </span>
              </a>
              <ul class="treeview-menu">            
                <li><?= $this->Html->link('<i class="fa fa-users"></i><span>' . __("Report 1") . "</span>",["controller" => "", "action" => ""],["escape" => false]) ?></li>
              </ul>
            </li>

            <?php if($system_settings_active_action) { ?>
              <li id="groups_nav" title="Groups" class="treeview active <?php //echo $nav_selected["system_settings"] ?>">
                <a href="#">
                  <i class="fa fa-gear"></i> <span>System Settings</span>
                  <span class="pull-right-container">
                    <i class="fa fa-angle-left pull-right"></i>
                  </span>
                </a>
                <ul class="treeview-menu">            
                  <?php if($default_group_actions['users'] != 'No Access') { ?>
                          <li><?= $this->Html->link('<i class="fa fa-users"></i><span>' . __("Users") . "</span>",["controller" => "users", "action" => "index"],["escape" => false]) ?></li>
                  <?php } ?>

                  <?php if($default_group_actions['allocations'] != 'No Access') { ?>
                          <li><?= $this->Html->link('<i class="fa fa-circle-o"></i><span>' . __("Clients") . "</span>",["controller" => "clients", "action" => "index"],["escape" => false]) ?></li>
                  <?php } ?>

                  <?php if($default_group_actions['sources'] != 'No Access') { ?>
                          <li><?= $this->Html->link('<i class="fa fa-circle-o"></i><span>' . __("Sources") . "</span>",["controller" => "sources", "action" => "index"],["escape" => false]) ?></li>
                  <?php } ?>

                  <?php if($default_group_actions['groups'] != 'No Access') { ?>
                          <li><?= $this->Html->link('<i class="fa fa-circle-o"></i><span>' . __("Groups") . "</span>",["controller" => "groups", "action" => "index"],["escape" => false]) ?></li>
                  <?php } ?>

                  <?php if($default_group_actions['status'] != 'No Access') { ?>
                          <li><?= $this->Html->link('<i class="fa fa-circle-o"></i><span>' . __("Status") . "</span>",["controller" => "statuses", "action" => "index"],["escape" => false]) ?></li>
                  <?php } ?>

                  <?php if($default_group_actions['lead_type'] != 'No Access') { ?>
                          <li><?= $this->Html->link('<i class="fa fa-circle-o"></i><span>' . __("Lead Type") . "</span>",["controller" => "lead_types", "action" => "index"],["escape" => false]) ?></li>
                  <?php } ?>

                  <?php if($default_group_actions['interest_type'] != 'No Access') { ?>
                          <li><?= $this->Html->link('<i class="fa fa-circle-o"></i><span>' . __("Interest Type") . "</span>",["controller" => "interest_types", "action" => "index"],["escape" => false]) ?></li>
                  <?php } ?>
                </ul>
              </li>  
            <?php } ?>

        <?php } ?>
      </ul>
    </section>    
</aside>