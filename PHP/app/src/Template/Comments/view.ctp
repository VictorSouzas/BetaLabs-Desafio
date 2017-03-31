<?php
/**
  * @var \App\View\AppView $this
  */
foreach ($comment as $comment) {
    continue;
}
?>
<div class="col col-lg-3 col-sm-2 col-md-4">
    <ul class="nav nav-pills nav-stacked">
      <li role="presentation" class="active">Menu: </li>
        <li role="presentation"><?= $this->Form->postLink(__('Deletar comentario'), ['action' => 'delete', $comment->id], ['confirm' => __('Are you sure you want to delete # {0}?', $comment->id)]) ?> </li>
        <li role="presentation"><?= $this->Html->link(__('Listar comentarios'), ['action' => 'index']) ?> </li>
        <li role="presentation"><?= $this->Html->link(__('Novo comentario'), ['action' => 'add']) ?> </li>
    </ul>
</div>
<div class="col col-lg-9 col-sm-10 col-md-8">

    <div class="panel panel-default">
      <!-- Default panel contents -->
      <div class="panel-heading"><?= __('Comments') ?></div>

       <table class="table">
        <tr>
                <th> Dono </th>
                <th> Comentario </th>
                <th> Criado </th>
                <th> Ações </th>
            </tr>

           <tr>
                    <td> <?= h($comment->u['name']) ?> </td>
                    <td> <?= h($comment->comment) ?> </td>
                    <td>  <?php $date = new DateTime(h($comment->created)); echo $date->format('d-m-Y H:i:s'); ?> </td>
                    <td> 
                    <?php if ($this->request->session()->read('Auth.User.id') == $comment->owner): ?>
                        <?= $this->Html->link(__('Editar'), ['action' => 'edit', $comment->id]) ?>
                      <?php endif; ?>
                        <?php if ($this->request->session()->read('Auth.User.admin') == 1 || $this->request->session()->read('Auth.User.id') == $comment->owner): ?>
                        <?= $this->Form->postLink(__('Excluir'), ['action' => 'delete', $comment->id], ['confirm' => __('Tem certeza que deseja excluir o comentario # {0}?', $comment->id)]) ?> 
                      <?php endif; ?>
                    </td>
                </tr>        
        </table>
    </div>

    <div class="row">
    <div class="col col-lg-12 col-sm-12 col-md-12">

    <div class="panel panel-default">
      <!-- Default panel contents -->
      <div class="panel-heading"><?= __('Historico') ?></div>

       <table class="table">
        <tr>
                <th> Dono </th>
                <th> Comentario </th>
                <th> Data de alteração </th>
            </tr>

<?php foreach ($history as $comments): ?> 
     <tr>
                    <td> <?= h($comments->u['name']) ?> </td>
                    <td> <?= h($comments->comment) ?> </td>
                    <td> <?php $date = new DateTime(h($comments->created)); echo $date->format('d-m-Y H:i:s'); ?> </td>
                    
                </tr>  
<?php endforeach; ?>
    </table>
    </div>
    </div>
</div>
