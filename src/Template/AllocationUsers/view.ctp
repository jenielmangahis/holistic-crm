
<section class="content-header">
    <h1><?= __('View Allocation User') ?></h1>
</section>

<section class="content">   
    <table class="table table-striped table-bordered table-hover">
    <tbody>
        <tr>
            <th><?= __('Allocation') ?></th>
            <td><?= $allocationUser->has('allocation') ? $this->Html->link($allocationUser->allocation->name, ['controller' => 'Allocations', 'action' => 'view', $allocationUser->allocation->id]) : '' ?></td>
        </tr>
        <tr>
            <th><?= __('User') ?></th>
            <td><?= $allocationUser->has('user') ? $this->Html->link($allocationUser->user->id, ['controller' => 'Users', 'action' => 'view', $allocationUser->user->id]) : '' ?></td>
        </tr>
        <tr>
            <th><?= __('Id') ?></th>
            <td><?= $this->Number->format($allocationUser->id) ?></td>
        </tr>
        <tr>
            <th><?= __('Created') ?></th>
            <td><?= h($allocationUser->created) ?></td>
        </tr>
    </tbody>
    </table>

    <div class="form-group" style="margin-top: 80px;">
    <div class="col-sm-offset-2 col-sm-10">
        <div class="action-fixed-bottom">        
        <?= $this->Html->link('<i class="fa fa-angle-left"> </i> Back To list', ['action' => 'index'],['class' => 'btn btn-warning', 'escape' => false]) ?>
        </div>
    </div>
    </div>
</section>
