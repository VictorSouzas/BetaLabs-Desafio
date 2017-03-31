<?php
/**
  * @var \App\View\AppView $this
  */
?>

<div class="col col-lg-3 col-sm-2 col-md-4">
    <ul class="nav nav-pills nav-stacked">
      <li role="presentation" class="active">Menu: </li>
      <li role="presentation"><?= $this->Html->link(__('Novo Usuario'), ['action' => 'add']) ?></li>
      <li role="presentation"><?= $this->Html->link(__('Listar Comentarios'), ['controller' => 'Comments','action' => 'index']) ?></li>
      <li role="presentation"><?= $this->Html->link(__('Novo Comentario'), ['controller' => 'Comments','action' => 'add']) ?></li>
    </ul>
</div>




<div class="col col-lg-9 col-sm-10 col-md-8">
<?= $this->Flash->render() ?>
    <div class="panel panel-default">
      <!-- Default panel contents -->
      <div class="panel-heading"><?= __('Usuarios') ?></div>
      <div class="panel-body">
        <p>Usuarios</p>
      </div>

       <table class="table">
           <tr>
                <th> Nome </th>
                <th> Email </th>
                <th> Imagem</th>
                <th> Ações </th>
            </tr>

            <?php foreach ($users as $user): ?>
                <tr>
                    <td> <?= h($user->name) ?> </td>
                    <td> <?= h($user->email) ?> </td>
                   <td> 
                            <img src="/PHP/app/upload/<?= $user->picture ?>" width="120" alt="sem imagem" class="thumbnail">
                    </td>
                    <td> <?php if ($this->request->session()->read('Auth.User.id') == $user->id): ?>
                        <?= $this->Html->link(__('Editar'), ['action' => 'edit', $user->id]) ?>
                      <?php endif; ?>
                      <?php if ($this->request->session()->read('Auth.User.admin') == 1 || $this->request->session()->read('Auth.User.id') == $user->id): ?>
                        <?= $this->Form->postLink(__('Excluir'), ['action' => 'delete', $user->id], ['confirm' => __('Tem certeza que deseja excluir o usuario # {0}?', $user->id)]) ?> 
                      <?php endif; ?>
                    </td>
                </tr>
             <?php endforeach; ?>

        </table>
    </div>
    <div class="btn btn-default">
          <?= $this->Paginator->prev(__('Anterior')) ?>
        </div>
        <?= $this->Paginator->counter(
    'Pagina {{page}} de {{pages}}, mostrando {{current}} registros de {{count}} total') ?>

        <div class="btn btn-default">
        <?= $this->Paginator->next(__('Proxima')) ?>
        </div>
</div>
