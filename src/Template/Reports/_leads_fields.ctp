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
    <h2 class="form-header">Fields</h2>
    <table class="table table-striped table-bordered table-hover">
        <?php foreach($fields as $f){ ?>
            <tr>                            
                <td style="Width:1%;"><input class="" type="checkbox" checked /></td>
                <td><?php echo $f; ?></td>                
            </tr>
        <?php } ?>          
    </table>       
</div>
<?= $this->Form->end() ?>