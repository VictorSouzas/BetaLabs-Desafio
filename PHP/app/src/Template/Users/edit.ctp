<?php
$this->start('script');
    echo '$().ready(function() {
            $( "#edit" ).submit(function( event ) {
                event.preventDefault();
                $.post("/PHP/app/users/edit/'.$user->id.'",{
                    name: $("#name").val(),
                    email: $("#email").val(),
                    password: $("#password").val()
                }).done(function( data ){
                    if(data !== "1"){
                        alert(data);
                    }else{
                        alert("Usuário atualizado com sucesso.");
                        window.location.href = "/PHP/app/users/view/";
                    }
                });
            });
        });';
$this->end();
?>

<div class="col col-lg-3 col-sm-2 col-md-4">
    <ul class="nav nav-pills nav-stacked">
      <li role="presentation"><?= __('Actions') ?></li>
        <li role="presentation"><?= $this->Form->postLink(
                __('Delete'),
                ['action' => 'delete', $user->id],
                ['confirm' => __('Are you sure you want to delete # {0}?', $user->id)]
            )
        ?></li>
        <li role="presentation"><?= $this->Html->link(__('List Users'), ['action' => 'index']) ?></li>
    </ul>
</div>

<div class="col col-lg-7 col-sm-8 col-md-6">
    <?= $this->Form->create($user, ['id'=> 'edit','onsubmit'=>'']) ?>
    <div class="input-group input-group-lg">
    <!-- não utilizado padrão form control pois adiciona um label e zoa o bootstrap -->
      <span class="input-group-addon" id="basic-addon1">Nome : </span><input type="text" name="name" id="name" class="form-control" value="<?= $user->name ?>" aria-describedby="sizing-addon1">
    </div>
    <br />
    <div class="input-group input-group-lg">
    <!-- não utilizado padrão form control pois adiciona um label e zoa o bootstrap -->
      <span class="input-group-addon" id="basic-addon1">E-mail : </span><input type="text" name="email" id="email" class="form-control" value="<?= $user->email ?>" aria-describedby="sizing-addon1">
    </div>
    <br />
    <div class="input-group input-group-lg">
    <!-- não utilizado padrão form control pois adiciona um label e zoa o bootstrap -->
      <span class="input-group-addon" id="basic-addon1">Senha : </span><input type="password" name="password" id="password" class="form-control" value="<?= $user->password ?>" aria-describedby="sizing-addon1">
    </div>
        
    <?= $this->Form->button(__('Submit'), ['class'=>'btn btn-primary']) ?>
    <?= $this->Form->end() ?>
    <br /><br />
    <?= $this->Flash->render() ?>
    <?php 
            echo $this->Form->create('', ['enctype' => 'multipart/form-data', 'url'=>'/users/upload/'.$user->id]);
            echo $this->Form->input('Atualizar imagem', ['type' => 'file', 'name'=> 'upload']);
            echo '.png .jpg .jpeg. .gif <br />';
            echo $this->Form->button('Atualizar imagem', ['class' => 'btn btn-success']);
            echo $this->Form->end();       
    ?>
</div>
