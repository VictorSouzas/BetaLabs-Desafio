<div class="col col-lg-3 col-sm-2 col-md-4">
    <ul class="nav nav-pills nav-stacked">
      <li role="presentation active"><?= __('Actions') ?></li>
      <li role="presentation"><?= $this->Html->link(__('Novo comentário'), ['controller'=>'Comments','action' => 'add']) ?> </li><li role="presentation"><?= $this->Html->link(__('Listar comentários'), ['controller'=>'Comments','action' => 'index']) ?> </li>
        <li role="presentation"><?= $this->Html->link(__('Editar usuario'), ['action' => 'edit', $user->id]) ?> </li>
        <li><?= $this->Form->postLink(__('Excluir usuario'), ['action' => 'delete', $user->id], ['confirm' => __('Are you sure you want to delete # {0}?', $user->id)]) ?> </li>
        <?php if($this->request->session()->read('Auth.User.admin') == 1): ?>
        <li role="presentation"><?= $this->Html->link(__('Listar todos os usuarios'), ['action' => 'index']) ?>
        </li>
        <?php endif; ?>

        <li role="presentation"><?= $this->Html->link(__('Novo usuario'), ['action' => 'add']) ?> </li>
    </ul>
</div>
<div class="col col-lg-9 col-sm-10 col-md-8">

    <?= $this->Flash->render() ?>
    <div class="panel panel-default">
      <!-- Default panel contents -->
      <div class="panel-heading">Perfil de usuario</div>
      

        <table class="table">
            <tr>
                <th>Nome: </th>
                <td><?= h($user->name) ?></td>
            </tr>

            <tr>
                <th>E-mail: </th>
                <td><?= h($user->email) ?></td>
            </tr>

            <tr>
                <th>Foto: </th>
                <td> 
                            <img src="/PHP/app/upload/<?= $user->picture ?>" width="120" alt="sem imagem" class="thumbnail">
                    </td>
            </tr>

            <tr>
                <th>Data de cadastro: </th>
                <td><?php $date = new DateTime(h($user->created)); echo $date->format('d-m-Y H:i'); ?></td>
            </tr>
        </table>


    </div>
</div>

