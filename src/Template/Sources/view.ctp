
<section class="content-header">
    <h1><?= __('View Source') ?></h1>
</section>

<section class="content">   
    <table class="table table-striped table-bordered table-hover">
    <tbody>
        <tr>
            <th><?= __('Id') ?></th>
            <td><?= $this->Number->format($source->id) ?></td>
        </tr>    
        <tr>
            <th><?= __('Name') ?></th>
            <td><?= h($source->name) ?></td>
        </tr>
        <tr>
            <th><?= __('Allocated to') ?></th>
            <td><?= h($source->allocation->name) ?></td>
        </tr>        
        <tr>
            <th><?= __('Created') ?></th>
            <td><?= h($source->created) ?></td>
        </tr>
        <tr>
            <th><?= __('Modified') ?></th>
            <td><?= h($source->modified) ?></td>
        </tr>
    </tbody>
    </table>

    <table class="table table-striped table-bordered table-hover">
        <tbody>
            <tr>
                <th></th>
                <td><br/><?= $this->Html->link('<i class="fa fa-angle-left"> </i> Back To list', ['action' => 'index'],['class' => 'btn btn-warning', 'escape' => false]) ?></td>
            </tr>                                      
        </tbody>
    </table>    
</section>
