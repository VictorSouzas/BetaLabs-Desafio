<?php
$this->start('script');
    echo '$().ready(function() {
            $( "#edit" ).submit(function( event ) {
                event.preventDefault();
                $.post("/PHP/app/comments/edit/'.$comment->id.'",{
                    comment: $("#comment").val(),
                }).done(function( data ){
                    if(data !== "1"){
                        alert(data);
                    }else{
                        alert("Comentário atualizado com sucesso.");
                        window.location.href = "/PHP/app/comments/";
                    }
                });
            });
        });';
$this->end();
?>
<div class="col col-lg-3 col-sm-2 col-md-4">
    <ul class="nav nav-pills nav-stacked">
      <li role="presentation" class="active">Menu: </li>
      <li role="presentation">
        <?= $this->Form->postLink(
                __('Excluir'),
                ['action' => 'delete', $comment->id],
                ['confirm' => __('Tem certeza que deseja excluir esse comentário ?', $comment->id)]
            )
        ?>
      </li>
      <li role="presentation"><?= $this->Html->link(__('Listar Comentários'), ['action' => 'index']) ?></li>
    </ul>
</div>

<div class="col col-lg-9 col-sm-10 col-md-8">
    <?= $this->Form->create($comment, ['id'=>'edit']) ?>
    <label>Editar: </label>
    <textarea class="form-control " name="comment" id="comment" rows="5"> <?= $comment->comment ?></textarea>
    <?= $this->Form->button(__('Enviar'),['class' => 'btn btn-primary']) ?>
    <?= $this->Form->end() ?>
</div>