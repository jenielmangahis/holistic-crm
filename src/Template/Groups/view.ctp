<section class="content-header">
    <h1>View Groups</h1>
</section>

<section class="content">
    <table class="table table-striped table-bordered table-hover">
        <tbody>
            <tr>
                <th width="140"><?= __('Name') ?></th>
                <td><?= h($group->name) ?></td>
            </tr>  
            <tr>
                <th width="140"><?= __('Id') ?></th>
                <td><?= $this->Number->format($group->id) ?></td>
            </tr>  
            <tr>
                <th width="140"><?= __('Created') ?></th>
                <td><?= h($group->created) ?></td>
            </tr>
            <tr>
                <th width="140"><?= __('Modified') ?></th>
                <td><?= h($group->modified) ?></td>
            </tr>                                        
        </tbody>
    </table>


    <h3 class="subheader"><strong><?= __('Related Users') ?></strong></h3>
    <?php if (!empty($group->users)): ?>

        <table class="table table-striped table-bordered table-hover">
            <tr>
                <th><?= __('Id') ?></th>
                <th><?= __('Username') ?></th>
                <th><?= __('Password') ?></th>
                <th><?= __('Group Id') ?></th>
                <th><?= __('Created') ?></th>
                <th><?= __('Modified') ?></th>
                <th class=""><?= __('Actions') ?></th>
            </tr>
            <?php foreach ($group->users as $users): ?>
            <tr>
                <td><?= h($users->id) ?></td>
                <td><?= h($users->username) ?></td>
                <td><?= substr($users->password, 0, 10); ?>...</td>
                <td><?= h($users->group_id) ?></td>
                <td><?= h($users->created) ?></td>
                <td><?= h($users->modified) ?></td>

                <td class="">
                    <?= $this->Html->link(__('View'), ['controller' => 'Users', 'action' => 'view', $users->id], ['class' => 'btn btn-primary']) ?>
                    <?= $this->Html->link(__('Edit'), ['controller' => 'Users', 'action' => 'edit', $users->id], ['class' => 'btn btn-info']) ?>
                    <?= $this->Form->postLink(__('Delete'), ['controller' => 'Users', 'action' => 'delete', $users->id], ['class' => 'btn btn-danger'], ['confirm' => __('Are you sure you want to delete # {0}?', $users->id)]) ?>
                </td>
            </tr>

            <?php endforeach; ?>
        </table>

    <?php endif; ?>
    <br />
    <table class="table table-striped table-bordered table-hover">
        <tbody>
            <tr>
                <th></th>
                <td><br/><?= $this->Html->link('<i class="fa fa-angle-left"> </i> Back To list', ['action' => 'index'],['class' => 'btn btn-warning', 'escape' => false]) ?></td>
            </tr>                                      
        </tbody>
    </table>
</section>
