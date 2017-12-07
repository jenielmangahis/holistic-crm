<?php ?>
<section class="content-header">
    <h1><?= __('View Audit Trail') ?></h1>
</section>

<section class="content">   
    <table class="table table-striped table-bordered table-hover">
    <tbody>
        <tr>
            <th><?= __('User') ?></th>
            <td><?= $auditTrail->has('user') ? $this->Html->link($auditTrail->user->id, ['controller' => 'Users', 'action' => 'view', $auditTrail->user->id]) : '' ?></td>
        </tr>
        <tr>
            <th><?= __('Action') ?></th>
            <td><?= h($auditTrail->action) ?></td>
        </tr>
        <tr>
            <th><?= __('Event Status') ?></th>
            <td><?= h($auditTrail->event_status) ?></td>
        </tr>
        <tr>
            <th><?= __('Ip Address') ?></th>
            <td><?= h($auditTrail->ip_address) ?></td>
        </tr>
        <tr>
            <th><?= __('Id') ?></th>
            <td><?= $this->Number->format($auditTrail->id) ?></td>
        </tr>
        <!-- <tr>
            <th><?= __('Details') ?></th>
            <td><?= $this->Number->format($auditTrail->details) ?></td>
        </tr> -->
        <tr>
            <th><?= __('Audit Date') ?></th>
            <td><?= h($auditTrail->audit_date) ?></td>
        </tr>
        <tr>
            <th><?= __('Created') ?></th>
            <td><?= h($auditTrail->created) ?></td>
        </tr>
        <tr>
            <th><?= __('Modified') ?></th>
            <td><?= h($auditTrail->modified) ?></td>
        </tr>
    </tbody>
    </table>

    <br />
    <table class="table table-striped table-bordered table-hover">
        <tbody>
            <tr>
                <th></th>
                <td>
                    <br/>
                    <?= $this->Html->link('<i class="fa fa-angle-left"> </i> Back To list', ['action' => 'index'],['class' => 'btn btn-warning', 'escape' => false]) ?>
                </td>
            </tr>                                      
        </tbody>
    </table>    
</section>