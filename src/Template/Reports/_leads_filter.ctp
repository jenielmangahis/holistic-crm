<?php ?>
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
.legend-container .label{
    width:85px;
    padding:5px;
    font-size: 12px;
    display: inline-block;
    margin: 2px;
}
</style>               
<div class="row">
    <div class="col-sm-11" id="leads-filter-grp">
    <div class="legend-container">
        <span class="label label-success">NOTE</span><br/>
        <span class="label label-info">=</span> : Is equal to value<br/>
        <span class="label label-info">!=</span> : Is not equal to value<br/>
        <span class="label label-info">LIKE</span> : Search for a specified pattern<br/>
        <span class="label label-info">BETWEEN</span> : Between 2 dates (date range)<br/>
    </div>    
    <div class="checkbox"><label class="form-header"><input type="checkbox" id="filter-leads-report" name="filter-leads-report" /> Filter</label></div>
    <table class="table table-striped table-bordered table-hover"> 
        <!-- <tr>                            
            <td class="field-name">ID</td>
            <td style="width:11%;">
                <select class="form-control frm-search-grp-1" name="search[id][operator]" disabled="">
                    <?php //foreach($option_logical_operators as $o){ ?>
                        <option value="<?php //echo $o; ?>"><?php //echo $o; ?></option>
                    <?php //} ?>
                </select>
            </td>
            <td><input type="text" class="form-control frm-search-grp-1" name="search[id][value]" id="artikel-id" disabled="" /></td>
        </tr> -->
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
            <td class="field-name">Phone</td>
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
            <td class="field-name">Email</td>
            <td style="width:11%;">
                <select class="form-control frm-search-grp-1" name="search[phone][operator]" disabled="">                    
                    <?php foreach($option_logical_operators as $o){ ?>
                        <option value="<?php echo $o; ?>"><?php echo $o; ?></option>
                    <?php } ?>
                </select>
            </td>
            <td>
                <input type="text" class="form-control frm-search-grp-1" name="search[phone][value]" id="phone" disabled="" />
            </td>
        </tr>
        <tr>                            
            <td class="field-name">City</td>
            <td style="width:11%;">
                <select class="form-control frm-search-grp-1" name="search[city][operator]" disabled="">                    
                    <?php foreach($option_logical_operators as $o){ ?>
                        <option value="<?php echo $o; ?>"><?php echo $o; ?></option>
                    <?php } ?>
                </select>
            </td>
            <td>
                <input type="text" class="form-control frm-search-grp-1" name="search[city][value]" id="city" disabled="" />
            </td>
        </tr>
        <tr>                            
            <td class="field-name">State</td>
            <td style="width:11%;">
                <select class="form-control frm-search-grp-1" name="search[state][operator]" disabled="">                    
                    <?php foreach($option_logical_operators as $o){ ?>
                        <option value="<?php echo $o; ?>"><?php echo $o; ?></option>
                    <?php } ?>
                </select>
            </td>
            <td>
                <input type="text" class="form-control frm-search-grp-1" name="search[state][value]" id="state" disabled="" />
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
                    <option value="">-- All Sources --</option>
                    <?php foreach($optionSources as $key => $value){ ?>
                        <option value="<?php echo $key; ?>"><?php echo $value; ?></option>
                    <?php } ?>
                </select>
            </td>
        </tr>
        <tr>                            
            <td class="field-name">Interest Types</td>
            <td style="width:11%;">
                <select class="form-control frm-search-grp-1" name="search[interest_type_id][operator]" disabled="">                    
                    <?php foreach($option_logical_operators as $o){ ?>
                        <option value="<?php echo $o; ?>"><?php echo $o; ?></option>
                    <?php } ?>
                </select>
            </td>
            <td>
                <select class="form-control frm-search-grp-1" name="search[interest_type_id][value]" disabled="">
                    <option value="">-- All Interest Type --</option>
                    <?php foreach($optionInterestTypes as $key => $value){ ?>
                        <option value="<?php echo $key; ?>"><?php echo $value; ?></option>
                    <?php } ?>
                </select>
            </td>
        </tr>
        <tr>                            
            <td class="field-name">Status</td>
            <td style="width:11%;">
                <select class="form-control frm-search-grp-1" name="search[status_id][operator]" disabled="">                    
                    <?php foreach($option_logical_operators as $o){ ?>
                        <option value="<?php echo $o; ?>"><?php echo $o; ?></option>
                    <?php } ?>
                </select>
            </td>
            <td>
                <select class="form-control frm-search-grp-1" name="search[status_id][value]" disabled="">
                    <option value="">-- Select Status --</option>
                    <?php foreach($optionStatuses as $key => $value){ ?>
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
        <tr>                            
            <td class="field-name">Date Created</td>
            <td style="width:11%;">
                <select class="form-control frm-search-grp-1" name="search[date_created][operator]" disabled="">                    
                    <option value="BETWEEN">BETWEEN</option>
                </select>
            </td>
            <td>
                <input type="text" class="form-control frm-search-grp-1 default-datepicker" name="search[date_created][value][from]" id="date_created_from" disabled="" placeholder="Date From" style="margin-bottom:5px;" />
                <input type="text" class="form-control frm-search-grp-1 default-datepicker" name="search[date_created][value][to]" id="date_created_to" disabled="" placeholder="Date To" />
            </td>
        </tr>      
    </table>
    </div>
</div>