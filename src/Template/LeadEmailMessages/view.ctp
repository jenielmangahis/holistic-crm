
<section class="content-header">
    <h1><?= __('View Lead Email Message') ?></h1>
</section>

<section class="content">   
    <table class="table table-striped table-bordered table-hover">
    <tbody>
        <tr>
            <th><?= __('User') ?></th>
            <td><?= $leadEmailMessage->has('user') ? $this->Html->link($leadEmailMessage->user->id, ['controller' => 'Users', 'action' => 'view', $leadEmailMessage->user->id]) : '' ?></td>
        </tr>
        <tr>
            <th><?= __('Lead') ?></th>
            <td><?= $leadEmailMessage->has('lead') ? $this->Html->link($leadEmailMessage->lead->id, ['controller' => 'Leads', 'action' => 'view', $leadEmailMessage->lead->id]) : '' ?></td>
        </tr>
        <tr>
            <th><?= __('Subject') ?></th>
            <td><?= h($leadEmailMessage->subject) ?></td>
        </tr>
        <tr>
            <th><?= __('Id') ?></th>
            <td><?= $this->Number->format($leadEmailMessage->id) ?></td>
        </tr>
    <tr>
        <th><?= __('Content') ?></th>
        <td><?= $this->Text->autoParagraph(h($leadEmailMessage->content)); ?></td>        
    </tr>
        <tr>
            <th><?= __('Date') ?></th>
            <td><?= h($leadEmailMessage->date) ?></td>
        </tr>
        <tr>
            <th><?= __('Created') ?></th>
            <td><?= h($leadEmailMessage->created) ?></td>
        </tr>
        <tr>
            <th><?= __('Modified') ?></th>
            <td><?= h($leadEmailMessage->modified) ?></td>
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
