<?php ?>
<style>
.form-header{
    font-size: 16px;
    background-color: #374850;
    padding:10px;
    color:#ffffff;
}
.fields-list{
    padding:10px;
}
.fields-list li{
    list-style: none;
    display: inline-block;
    width:250px;
}
</style>
<?= $this->Form->create(null,[                
  'url' => ['action' => 'search_result'],
  'class' => 'form-horizontal',
  'type' => 'POST'
]) ?>                 
<div class="row">
    <div class="col-sm-11">
    <h2 class="form-header">Fields</h2>
    <ul class="fields-list">
        <?php foreach($fields as $key => $f){ ?>
            <li><div class="checkbox"><label><input class="" name="fields[<?php echo $key; ?>]" value="<?php echo $f; ?>" type="checkbox" checked > <?php echo $f; ?></label></div></li>
        <?php } ?>
    </ul>       
    <div class="col-sm-11">
        <h2 class="form-header">Report Type</h2>
        <table class="table table-striped table-bordered table-hover">
            <tr>
                <td style="width:20%;">Report Type: </td>
                <td style="width:80%;">
                    <select class="form-control frm-search-grp-1" name="report_type">                    
                        <option value="view_report">View In Other Tab</option>
                        <option value="excel_download">Excel Download</option>
                    </select>
                </td>
            </tr>            
        </table>
    </div>
</div>
<?= $this->Form->end() ?>