<style>
.form-header{
    font-size: 16px;
    background-color: #374850;
    padding:10px;
    color:#ffffff;
}
</style>
<?= $this->Form->create(null,[                
  'url' => ['action' => 'search_result'],
  'class' => 'form-horizontal',
  'type' => 'POST'
]) ?>                 
<div class="row">
    <div class="col-sm-10">
    <h2 class="form-header">Filter</h2>
    <table class="table table-striped table-bordered table-hover">
        <tr>                            
            <td class="field-name">ID</td>
            <td style="width:11%;">
                <select class="form-control frm-search-grp-1" name="search[id][operator]">
                    <?php foreach($option_logical_operators as $o){ ?>
                        <option value="<?php echo $o; ?>"><?php echo $o; ?></option>
                    <?php } ?>
                </select>
            </td>
            <td><input type="text" class="form-control frm-search-grp-1" name="search[id][value]" id="artikel-id" /></td>
        </tr>
        <tr>                            
            <td class="field-name">First Name</td>
            <td style="width:11%;">
                <select class="form-control frm-search-grp-1" name="search[first_name][operator]">
                    <?php foreach($option_logical_operators as $o){ ?>
                        <option value="<?php echo $o; ?>"><?php echo $o; ?></option>
                    <?php } ?>
                </select>
            </td>
            <td><input type="text" class="form-control frm-search-grp-1" name="search[first_name][value]" id="first_name" /></td>
        </tr>
        <tr>                            
            <td class="field-name">Surname</td>
            <td style="width:11%;">
                <select class="form-control frm-search-grp-1" name="search[surname][operator]">
                    <?php foreach($option_logical_operators as $o){ ?>
                        <option value="<?php echo $o; ?>"><?php echo $o; ?></option>
                    <?php } ?>
                </select>
            </td>
            <td><input type="text" class="form-control frm-search-grp-1" name="search[surname][value]" id="surname" /></td>
        </tr>
        <tr>                            
            <td class="field-name">Source</td>
            <td style="width:11%;">
                <select class="form-control frm-search-grp-1" name="search[source][operator]">
                    <?php foreach($option_logical_operators as $o){ ?>
                        <option value="<?php echo $o; ?>"><?php echo $o; ?></option>
                    <?php } ?>
                </select>
            </td>
            <td>
                <select class="form-control frm-search-grp-1" name="search[source][operator]">
                    <?php foreach($sources as $key => $value){ ?>
                        <option value="<?php echo $key; ?>"><?php echo $value; ?></option>
                    <?php } ?>
                </select>
            </td>
        </tr>
        <tr>                            
            <td class="field-name">Allocation Date</td>
            <td style="width:11%;">
                <select class="form-control frm-search-grp-1" name="search[allocation_date][operator]">
                    <?php foreach($option_logical_operators as $o){ ?>
                        <option value="<?php echo $o; ?>"><?php echo $o; ?></option>
                    <?php } ?>
                </select>
            </td>
            <td><input type="text" class="form-control frm-search-grp-1 default-datepicker" name="search[allocation_date][value]" id="allocation_date" /></td>
        </tr>        
    </table>
</div>