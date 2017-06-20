
<section class="content-header">
    <h1><?= __('View Interest Type') ?></h1>
</section>

<section class="content">   
    <table class="table table-striped table-bordered table-hover">
    <tbody>
        <tr>
            <th><?= __('Name') ?></th>
            <td><?= h($interestType->name) ?></td>
        </tr>
        <tr>
            <th><?= __('Id') ?></th>
            <td><?= $this->Number->format($interestType->id) ?></td>
        </tr>
        <tr>
            <th><?= __('Created') ?></th>
            <td><?= h($interestType->created) ?></td>
        </tr>
        <tr>
            <th><?= __('Modified') ?></th>
            <td><?= h($interestType->modified) ?></td>
        </tr>
    </tbody>
    </table>

    <div class="form-group" style="margin-top: 50px;">
    <!--
    <div class="col-sm-offset-2 col-sm-10">
        <div class="action-fixed-bottom">        
        <?= $this->Html->link('<i class="fa fa-angle-left"> </i> Back To list', ['action' => 'index'],['class' => 'btn btn-warning', 'escape' => false]) ?>
        </div>
    </div>
    -->
    </div>
    <div class="related">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title"><?= __('Related Leads') ?></h3>
            </div>
        </div>        
        <?php if (!empty($interestType->leads)): ?>
        <table class="table table-striped table-bordered table-hover">
            <tbody>
            <tr>
                <th><?= __('Id') ?></th>
                <th><?= __('Status Id') ?></th>
                <th><?= __('Source Id') ?></th>
                <th><?= __('Allocation Id') ?></th>
                <th><?= __('Allocation Date') ?></th>
                <th><?= __('Firstname') ?></th>
                <th><?= __('Surname') ?></th>
                <th><?= __('Email') ?></th>
                <th><?= __('Phone') ?></th>
                <th><?= __('Address') ?></th>
                <th><?= __('City') ?></th>
                <th><?= __('State') ?></th>
                <th><?= __('Interest Type Id') ?></th>
                <th><?= __('Followup Date') ?></th>
                <th><?= __('Followup Action Reminder Date') ?></th>
                <th><?= __('Notes') ?></th>
                <th><?= __('Created') ?></th>
                <th><?= __('Modified') ?></th>
                <th class="actions"><?= __('Actions') ?></th>
            </tr>
            <?php foreach ($interestType->leads as $leads): ?>
            <tr>
                <td><?= h($leads->id) ?></td>
                <td><?= h($leads->status_id) ?></td>
                <td><?= h($leads->source_id) ?></td>
                <td><?= h($leads->allocation_id) ?></td>
                <td><?= h($leads->allocation_date) ?></td>
                <td><?= h($leads->firstname) ?></td>
                <td><?= h($leads->surname) ?></td>
                <td><?= h($leads->email) ?></td>
                <td><?= h($leads->phone) ?></td>
                <td><?= h($leads->address) ?></td>
                <td><?= h($leads->city) ?></td>
                <td><?= h($leads->state) ?></td>
                <td><?= h($leads->interest_type_id) ?></td>
                <td><?= h($leads->followup_date) ?></td>
                <td><?= h($leads->followup_action_reminder_date) ?></td>
                <td><?= h($leads->notes) ?></td>
                <td><?= h($leads->created) ?></td>
                <td><?= h($leads->modified) ?></td>
                <td class="actions">
                    <?= $this->Html->link('<i class="fa fa-eye"></i>', ['controller' => 'Leads', 'action' => 'view', $leads->id], ['class' => 'btn btn-info', 'escape' => false]) ?>

                    <?= $this->Html->link('<i class="fa fa-pencil"></i>', ['controller' => 'Leads', 'action' => 'edit', $leads->id], ['class' => 'btn btn-success', 'escape' => false]) ?>

                    <?= $this->Form->postLink('<i class="fa fa-trash"></i>', ['controller' => 'Leads', 'action' => 'delete', $leads->id], ['class' => 'btn btn-danger', 'escape' => false], ['confirm' => __('Are you sure you want to delete # {0}?', $leads->id)]) ?>

                </td>
            </tr>
            <?php endforeach; ?>      
            </tbody>      
        </table>
    <?php endif; ?>
    <table class="table table-striped table-bordered table-hover">
        <tbody>
            <tr>
                <th></th>
                <td><br/><?= $this->Html->link('<i class="fa fa-angle-left"> </i> Back To list', ['action' => 'index'],['class' => 'btn btn-warning', 'escape' => false]) ?></td>
            </tr>                                      
        </tbody>
    </table>     
    </div>
</section>
