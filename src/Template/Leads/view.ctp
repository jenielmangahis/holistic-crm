
<section class="content-header">
    <h1><?= __('View Lead') ?></h1>
</section>

<section class="content">   
    <table class="table table-striped table-bordered table-hover">
    <tbody>
        <tr>
            <th><?= __('Status') ?></th>
            <td><?= $lead->has('status') ? $this->Html->link($lead->status->name, ['controller' => 'Statuses', 'action' => 'view', $lead->status->id]) : '' ?></td>
        </tr>
        <tr>
            <th><?= __('Source') ?></th>
            <td><?= $lead->has('source') ? $this->Html->link($lead->source->name, ['controller' => 'Sources', 'action' => 'view', $lead->source->id]) : '' ?></td>
        </tr>
        <tr>
            <th><?= __('Allocation') ?></th>
            <td><?= $lead->has('allocation') ? $this->Html->link($lead->allocation->name, ['controller' => 'Allocations', 'action' => 'view', $lead->allocation->id]) : '' ?></td>
        </tr>
        <tr>
            <th><?= __('Firstname') ?></th>
            <td><?= h($lead->firstname) ?></td>
        </tr>
        <tr>
            <th><?= __('Surname') ?></th>
            <td><?= h($lead->surname) ?></td>
        </tr>
        <tr>
            <th><?= __('Email') ?></th>
            <td><?= h($lead->email) ?></td>
        </tr>
        <tr>
            <th><?= __('Phone') ?></th>
            <td><?= h($lead->phone) ?></td>
        </tr>
        <tr>
            <th><?= __('City') ?></th>
            <td><?= h($lead->city) ?></td>
        </tr>
        <tr>
            <th><?= __('State') ?></th>
            <td><?= h($lead->state) ?></td>
        </tr>
        <tr>
            <th><?= __('Interest Type') ?></th>
            <td><?= h($lead->interest_type) ?></td>
        </tr>
        <tr>
            <th><?= __('Id') ?></th>
            <td><?= $this->Number->format($lead->id) ?></td>
        </tr>
    <tr>
        <th><?= __('Address') ?></th>
        <td><?= $this->Text->autoParagraph(h($lead->address)); ?></td>        
    </tr>
        <tr>
            <th><?= __('Allocation Date') ?></th>
            <td><?= h($lead->allocation_date) ?></td>
        </tr>
        <tr>
            <th><?= __('Followup Date') ?></th>
            <td><?= h($lead->followup_date) ?></td>
        </tr>
        <tr>
            <th><?= __('Followup Action Reminder Date') ?></th>
            <td><?= h($lead->followup_action_reminder_date) ?></td>
        </tr>
        <tr>
            <th><?= __('Created') ?></th>
            <td><?= h($lead->created) ?></td>
        </tr>
        <tr>
            <th><?= __('Modified') ?></th>
            <td><?= h($lead->modified) ?></td>
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
