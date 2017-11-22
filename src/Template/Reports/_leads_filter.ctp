<style>
.form-header{
    font-size: 16px;
    background-color: #374850;
    padding:10px;
    color:#ffffff;
    width: 100%;
}
.checkbox label{
    padding-left: 28px;
}
</style>               
<div class="row">
    <div class="col-sm-11" id="leads-filter-grp">
    <div class="checkbox"><label class="form-header"><input type="checkbox" id="filter-leads-report" name="filter-leads-report" /> Filter</label></div>
    <table class="table table-striped table-bordered table-hover"> 
        <tr>                            
            <td class="field-name">ID</td>
            <td style="width:11%;">
                <select class="form-control frm-search-grp-1" name="search[id][operator]" disabled="">
                    <?php foreach($option_logical_operators as $o){ ?>
                        <option value="<?php echo $o; ?>"><?php echo $o; ?></option>
                    <?php } ?>
                </select>
            </td>
            <td><input type="text" class="form-control frm-search-grp-1" name="search[id][value]" id="artikel-id" disabled="" /></td>
        </tr>
        <tr>                            
            <td class="field-name">First Name</td>
            <td style="width:11%;">
                <select class="form-control frm-search-grp-1" name="search[firstname][operator]" disabled="">
                    <?php foreach($option_logical_operators as $o){ ?>
                        <option value="<?php echo $o; ?>"><?php echo $o; ?></option>
                    <?php } ?>
                </select>
            </td>
            <td><input type="text" class="form-control frm-search-grp-1" name="search[firstname][value]" id="first_name" disabled="" /></td>
        </tr>
        <tr>                            
            <td class="field-name">Surname</td>
            <td style="width:11%;">
                <select class="form-control frm-search-grp-1" name="search[surname][operator]" disabled="">
                    <?php foreach($option_logical_operators as $o){ ?>
                        <option value="<?php echo $o; ?>"><?php echo $o; ?></option>
                    <?php } ?>
                </select>
            </td>
            <td><input type="text" class="form-control frm-search-grp-1" name="search[surname][value]" id="surname" disabled="" /></td>
        </tr>
        <tr>                            
            <td class="field-name">Email</td>
            <td style="width:11%;">
                <select class="form-control frm-search-grp-1" name="search[email][operator]" disabled="">                    
                    <?php foreach($option_logical_operators as $o){ ?>
                        <option value="<?php echo $o; ?>"><?php echo $o; ?></option>
                    <?php } ?>
                </select>
            </td>
            <td>
                <input type="text" class="form-control frm-search-grp-1" name="search[email][value]" id="email" disabled="" />
            </td>
        </tr>
        <tr>                            
            <td class="field-name">Source</td>
            <td style="width:11%;">
                <select class="form-control frm-search-grp-1" name="search[source][operator]" disabled="">                    
                    <?php foreach($option_logical_operators as $o){ ?>
                        <option value="<?php echo $o; ?>"><?php echo $o; ?></option>
                    <?php } ?>
                </select>
            </td>
            <td>
                <select class="form-control frm-search-grp-1" name="search[source][value]" disabled="">
                    <option value="">-- Please Select --</option>
                    <?php foreach($optionSources as $key => $value){ ?>
                        <option value="<?php echo $key; ?>"><?php echo $value; ?></option>
                    <?php } ?>
                </select>
            </td>
        </tr>
        <tr>                            
            <td class="field-name">Allocation Date</td>
            <td style="width:11%;">
                <select class="form-control frm-search-grp-1" name="search[allocation_date][operator]" disabled="">
                    <?php foreach($option_logical_operators as $o){ ?>
                        <option value="<?php echo $o; ?>"><?php echo $o; ?></option>
                    <?php } ?>
                </select>
            </td>
            <td><input type="text" class="form-control frm-search-grp-1 default-datepicker" name="search[allocation_date][value]" id="allocation_date" disabled="" /></td>
        </tr>        
    </table>
    </div>
</div>