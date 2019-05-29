<section class="content-header">
    <h1><?= __('Add Lead Email Message') ?></h1>
    <ol class="breadcrumb">
        <li><?= $this->Html->link("<i class='fa fa-dashboard'></i>" . __("Home"), ['controller' => 'users', 'action' => 'dashboard'],['escape' => false]) ?></li>
        <li><?= $this->Html->link("<i class='fa fa-gear'></i>" . __('Lead Email Messages'), ['action' => 'index'],['escape' => false]) ?></li>
        <li class="active"><?= __('Add') ?></li>
    </ol>
</section>

<section class="content">
    <!-- Main Row -->
    <div class="row">
        <section class="col-lg-12 ">
            <div class="box " >
                <div class="box-header">

                </div>
                <div class="box-body">
                    <?= $this->Form->create($leadEmailMessage,['url' => ['action' => 'post_send_mail'], 'type' => 'POST', 'id' => 'frm-default-add', 'data-toggle' => 'validator', 'role' => 'form','class' => 'form-horizontal', 'enctype' => 'multipart/form-data']) ?>
                    <fieldset>        
                        <?php
                            echo $this->Form->hidden('lead_id',['value' => $lead->id]);
                            echo "
                            <div class='form-group'>
                                <label for='lead_email' class='col-sm-2 control-label'>" . __('Lead Email') . "</label>
                                <div class='col-sm-6'>";
                                 echo $this->Form->input('lead_email', ['type' => 'text', 'disabled' => 'disabled', 'readonly' => 'readonly', 'class' => 'form-control', 'value' => $lead->email, 'id' => 'lead_email', 'label' => false]);                 
                            echo " </div></div>";    
                            echo "
                            <div class='form-group'>
                                <label for='subject' class='col-sm-2 control-label'>" . __('Subject') . "</label>
                                <div class='col-sm-6'>";
                                echo $this->Form->input('subject', ['class' => 'form-control', 'id' => 'subject', 'label' => false]);                
                            echo " </div></div>";  
                            echo "<div class='email-attachment'>";
                                echo "
                                <div class='form-group'>
                                    <label for='content' class='col-sm-2 control-label'>" . __('Attachment') . "</label>
                                    <div class='col-sm-6'>";
                                    echo $this->Form->input('attachments[]', ['type' => 'file', 'class' => 'form-control', 'id' => 'content', 'label' => false]);  
                                    echo $this->Form->input('attachments[]', ['type' => 'file', 'class' => 'form-control', 'id' => 'content', 'label' => false]);  
                                    echo $this->Form->input('attachments[]', ['type' => 'file', 'class' => 'form-control', 'id' => 'content', 'label' => false]);                
                                echo " </div></div>";
                            echo "</div>";
                            
                            echo "
                            <div class='form-group'>
                                <label for='content' class='col-sm-2 control-label'>" . __('Content') . "</label>
                                <div class='col-sm-6'>";
                                echo $this->Form->input('content', ['class' => 'form-control ckeditor', 'id' => 'content', 'label' => false]);                
                            echo " </div></div>"; 
                        ?>
                    </fieldset>
                    <div class="form-group" style="margin-top: 80px;">
                        <div class="col-sm-offset-2 col-sm-10">                            
                            <?= $this->Form->button('<i class="fa fa-save"></i> ' . __('Save'),['name' => 'save', 'value' => 'save', 'class' => 'btn btn-success', 'escape' => false]) ?>
                            <?= $this->Form->button('<i class="fa fa-edit"></i> ' . __('Save and Continue adding'),['name' => 'save', 'value' => 'edit', 'class' => 'btn btn-info', 'escape' => false]) ?>
                            <?= $this->Html->link('<i class="fa fa-angle-left"> </i> ' . __('Back To list'), ['action' => 'list', $lead->id],['class' => 'btn btn-warning', 'escape' => false]) ?>                            
                        </div>
                    </div>
                    <?= $this->Form->end() ?>
                </div>
            </div>
        </section>
    </div>
</section>