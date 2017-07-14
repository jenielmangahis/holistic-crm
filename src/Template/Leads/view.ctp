
<section class="content-header">
    <h1><?= __('View Lead') ?></h1>
</section>

<section class="content">   
    <table class="table table-striped table-bordered table-hover">
    <tbody>
        <tr>
            <th style="width:20%;"><?= __('Status') ?></th>
            <td><?= $lead->has('status') ? $lead->status->name : '' ?></td>
        </tr>
        <tr>
            <th><?= __('Source') ?></th>
            <td><?= $lead->has('source') ? $lead->source->name : '' ?></td>
        </tr>

        <tr>
            <th><?= __('Lead Type') ?></th>
            <td><?= $lead->has('lead_type') ? $lead->lead_type->name : '' ?></td>
        </tr>

        <tr>
            <th><?= __('Allocated to') ?></th>
            <td><?= $lead->has('allocation') ? $lead->allocation->name : '' ?></td>
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
            <th><?= __('Id') ?></th>
            <td><?= $this->Number->format($lead->id) ?></td>
        </tr>
        <tr>
            <th><?= __('Interest Type Id') ?></th>
            <td>
                <?= $lead->has('interest_type') ? $lead->interest_type->name : ''; ?>
            </td>
        </tr>
    <tr>
        <th><?= __('Address') ?></th>
        <td><?= $this->Text->autoParagraph(h($lead->address)); ?></td>        
    </tr>
    <tr>
        <th><?= __('Notes') ?></th>
        <td><?= $lead->notes ?></td>        
    </tr>
        <tr>
            <th><?= __('Allocation Date') ?></th>
            <td><?= date("d F, Y", strtotime($lead->allocation_date)); ?></td>
        </tr>
        <tr>
            <th><?= __('Followup Date') ?></th>
            <td><?= date("d F, Y", strtotime($lead->followup_date)); ?></td>
        </tr>
        <tr>
            <th><?= __('Followup Note') ?></th>
            <td><?= $lead->followup_notes ?></td>
        </tr>
        <tr>
            <th><?= __('Followup Action Reminder Date') ?></th>
            <td><?= date("d F, Y", strtotime($lead->followup_action_reminder_date)); ?></td>
        </tr>
        <tr>
            <th><?= __('Followup Action Note') ?></th>
            <td><?= $lead->followup_action_notes ?></td>
        </tr>        
        <tr>
            <th><?= __('Created') ?></th>
            <td><?= date("d F, Y H:i A", strtotime($lead->created)); ?></td>
        </tr>
        <tr>
            <th><?= __('Modified') ?></th>
            <td><?= date("d F, Y H:i A", strtotime($lead->modified)); ?></td>
        </tr>
        <tr>
            <td colspan="2"><?= $this->Html->link('<i class="fa fa-angle-left"> </i> Back To list', ['action' => 'index'],['class' => 'btn btn-warning', 'escape' => false]) ?></td>
        </tr>
    </tbody>
    </table>   
</section>
