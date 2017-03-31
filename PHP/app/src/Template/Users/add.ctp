<?php
$this->start('script');
    echo '$().ready(function() {
            $( "#add" ).submit(function( event ) {
                event.preventDefault();
                $.post("/PHP/app/users/add",{
                    name: $("#name").val(),
                    email: $("#email").val(),
                    password: $("#password").val()
                }).done(function( data ){
                    if(data !== "1"){
                        alert(data);
                    }else{
                        alert("Usuário cadastrado com sucesso.");
                        window.location.href = "/PHP/app/users/";
                    }
                });
            });
        });';
$this->end();
?>

<div class="col col-lg-3 col-sm-2 col-md-4">
    <ul class="nav nav-pills nav-stacked">

      <li role="presentation"><label>Menu: </label></li>
      <li role="presentation"><?= $this->Html->link(__('Listar Comentarios'), ['controller' => 'Comments', 'action' => 'index']) ?></li>
    </ul>
</div>

<div class="col col-lg-9 col-sm-10 col-md-8">
    <?= $this->Form->create($user,['id' => 'add']) ?>
    <div class="input-group">
        <span class="input-group-addon" id="basic-addon1">Nome:</span>
        <input type="text" class="form-control" placeholder="Nome" name="name" id="name" aria-describedby="basic-addon1" required>
    </div>
    <br />
    <div class="input-group">
        <span class="input-group-addon" id="basic-addon1">E-mail: </span>
        <input type="email" class="form-control" placeholder="exemplo@exemplo.com.br" name="email" id="email" aria-describedby="basic-addon1" required>
    </div>
    <br />
    <div class="input-group">
        <span class="input-group-addon" id="basic-addon1">Senha: </span>
        <input type="password" class="form-control" placeholder="**********" name="password" id="password" aria-describedby="basic-addon1" required>
    </div>
    <br />
    <?= $this->Form->button(__('Cadastar'), ['class' => 'btn btn-primary']) ?>
    <?= $this->Form->end() ?>

</div>
