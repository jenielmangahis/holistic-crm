<div class="register-box">
  <div class="register-logo">
    <a href="#"><b><?= $this->Html->image('logo.png',["width"=>"360"]) ?></b></a>
  </div>

  <div class="register-box-body">
    <p class="login-box-msg">Register Leads</p>    
    <?= $this->Form->create($lead,['id' => 'frm-default-add', 'data-toggle' => 'validator', 'role' => 'form','class' => 'form-horizontal']) ?>
      <?= $this->Flash->render() ?>                        
        <fieldset>                                
            <?php
                echo "
                <div class='form-group'>";                                                               
                    echo $this->Form->input('firstname', ['placeholder' => 'Firstname', 'class' => 'form-control', 'id' => 'firstname', 'label' => false]);                
                echo " </div>";    
                
                echo "
                <div class='form-group'>";                                                           
                    echo $this->Form->input('surname', ['placeholder' => 'Surname', 'class' => 'form-control', 'id' => 'surname', 'label' => false]);                
                echo " </div>";    
                
                echo "
                <div class='form-group'>";
                    echo $this->Form->input('email', ['placeholder' => 'Email', 'class' => 'form-control', 'id' => 'email', 'label' => false]);                
                echo " </div>";    
                
                echo "
                <div class='form-group'>";                                                                
                    echo $this->Form->input('phone', ['placeholder' => 'Phone', 'class' => 'form-control', 'id' => 'phone', 'label' => false]);                
                echo " </div>";    
                
                echo "
                <div class='form-group'>";                                                               
                    echo $this->Form->input('address', ['placeholder' => 'Address', 'class' => 'form-control', 'id' => 'address', 'label' => false]);                
                echo "</div>";    
                
                echo "
                <div class='form-group'>";                                                                
                    echo $this->Form->input('city', ['placeholder' => 'City', 'class' => 'form-control', 'id' => 'city', 'label' => false]);                
                echo " </div>";    
                
                echo "
                <div class='form-group'>";                                                                
                    echo $this->Form->input('state', ['placeholder' => 'State', 'class' => 'form-control', 'id' => 'state', 'label' => false]);                
                echo " </div>";
            ?>
        </fieldset>
      <div class="row">        
        <div class="col-xs-8"></div>
        <div class="col-xs-4">
          <div class="col-sm-offset-2 col-sm-10">                  
              <?= $this->Form->button(__('Register'),['name' => 'save', 'value' => 'save', 'class' => 'btn btn-success', 'escape' => false]) ?>
        </div>
      </div>
      <?= $this->Form->end() ?>
  </div>
  <!-- /.form-box -->
</div>