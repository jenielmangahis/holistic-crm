<?= $this->Form->create(null,['url' => '/groups/add', 'id' => 'frm-user-add', 'data-toggle' => 'validator', 'role' => 'form']) ?>
                <div class="modal-body">
                    <fieldset>        
                        <?php                                        
                            echo "<div class='form-group'>";
                                echo "<div class='col-sm-12 form-label'>";
                                    echo __("Name");
                                echo "</div>";
                                echo "<div class='col-sm-12'>";
                                    echo $this->Form->input('name',['class' => 'form-control', 'id' => 'name', 'label' => false]);    
                                echo "<div class='help-block with-errors'></div> </div>";                
                            echo " </div>"; 
                        
                        ?>
                    </fieldset>   
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Add</button>
                </div>
            <?= $this->Form->end() ?>
