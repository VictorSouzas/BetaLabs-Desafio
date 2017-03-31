<?php
/**
  * @var \App\View\AppView $this
  */
?>

<div class="col col-lg-3 col-sm-2 col-md-4">
    <ul class="nav nav-pills nav-stacked">
      <li role="presentation"><?= $this->Html->link(__('Novo Comentário'), ['action' => 'add']) ?></li>
      <?php if ($this->request->session()->read('Auth.User.name') != ""): ?>
      <li role="presentation"><?= $this->Html->link(__('Perfil'), ['controller' => 'Users', 'action' => 'view']) ?></li>
    <?php endif; ?>
    </ul>
</div>


<div class="col col-lg-9 col-sm-10 col-md-8">
    <?= $this->Flash->render() ?>
    <div class="panel panel-default">
      <!-- Default panel contents -->
      <div class="panel-heading"><?= __('Comentários') ?></div>
      <div class="panel-body">
        <p>Comentários sobre o Produto ArrayEnterprises</p>
      </div>

       <table class="table">
           <tr>
                <th> Dono </th>
                <th> Comentario </th>
                <th> Criação </th>
                <th> Ações </th>
            </tr>
            <?php foreach ($comments as $comment): ?>
                <tr>
                    <td> <img src="/PHP/app/upload/<?= $comment->u['picture'] ?>" width="120" alt="sem imagem" class="thumbnail">
                    <?= h($comment->u['name']) ?> </td>
                    <td> <?= h($comment->comment) ?> </td>
                    <td><?php $date = new DateTime(h($comment->created)); echo $date->format('d-m-Y H:i:s'); ?> </td>
                    <td> 
                    <?php if ($this->request->session()->read('Auth.User.admin') == 1 || $this->request->session()->read('Auth.User.id') == $comment->owner): ?>

                        <?= $this->Html->link(__('Visualizar historico'), ['action' => 'view', $comment->id]) ?>
                        <br />
                        <?php endif; ?>
                        <?php if ($this->request->session()->read('Auth.User.id') == $comment->owner): ?>
                        <?= $this->Html->link(__('Editar'), ['action' => 'edit', $comment->id]) ?>
                      <?php endif; ?>
                        <?php if ($this->request->session()->read('Auth.User.admin') == 1 || $this->request->session()->read('Auth.User.id') == $comment->owner): ?>
                        <?= $this->Form->postLink(__('Excluir'), ['action' => 'delete', $comment->id], ['confirm' => __('Tem certeza que deseja excluir o comentario # {0}?', $comment->id)]) ?> 
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
    'Pagina {{page}} de {{pages}}') ?>

        <div class="btn btn-default">
        <?= $this->Paginator->next(__('Proxima')) ?>
        </div>
</div>
