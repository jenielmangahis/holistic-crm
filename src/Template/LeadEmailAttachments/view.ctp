
<section class="content-header">
    <h1><?= __('View Lead Email Attachment') ?></h1>
</section>

<section class="content">   
    <table class="table table-striped table-bordered table-hover">
    <tbody>
        <tr>
            <th><?= __('Lead Email Message') ?></th>
            <td><?= $leadEmailAttachment->has('lead_email_message') ? $this->Html->link($leadEmailAttachment->lead_email_message->id, ['controller' => 'LeadEmailMessages', 'action' => 'view', $leadEmailAttachment->lead_email_message->id]) : '' ?></td>
        </tr>
        <tr>
            <th><?= __('Id') ?></th>
            <td><?= $this->Number->format($leadEmailAttachment->id) ?></td>
        </tr>
    <tr>
        <th><?= __('Attachment') ?></th>
        <td><?= $this->Text->autoParagraph(h($leadEmailAttachment->attachment)); ?></td>        
    </tr>
        <tr>
            <th><?= __('Created') ?></th>
            <td><?= h($leadEmailAttachment->created) ?></td>
        </tr>
        <tr>
            <th><?= __('Modified') ?></th>
            <td><?= h($leadEmailAttachment->modified) ?></td>
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
