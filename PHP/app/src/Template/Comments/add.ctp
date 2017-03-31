<?php
$this->start('script');
    echo '$().ready(function() {
            $( "#edit" ).submit(function( event ) {
                event.preventDefault();
                $.post("/PHP/app/comments/add/",{
                    comment: $("#comment").val(),
                }).done(function( data ){
                    if(data !== "1"){
                        alert(data);
                    }else{
                        alert("Comentário feito com sucesso.");
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
      <li role="presentation"><?= $this->Html->link(__('Listar Comentários'), ['action' => 'index']) ?></li>
    </ul>
</div>

<div class="col col-lg-9 col-sm-10 col-md-8">
    <?= $this->Form->create($comment, ['id'=>'edit']) ?>
    <label>Novo comentário: </label>
    <textarea class="form-control " name="comment" id="comment" rows="5"></textarea>
    <?= $this->Form->button(__('Enviar'),['class' => 'btn btn-primary']) ?>
    <?= $this->Form->end() ?>
</div>