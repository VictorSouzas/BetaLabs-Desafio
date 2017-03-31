<?php
$this->start('script');
    echo '$().ready(function() {
            $( "#login" ).submit(function( event ) {
                event.preventDefault();
                $.post("/PHP/app/login",{
                    email: $("#email").val(),
                    password: $("#password").val()
                }).done(function( data ){
                    if(data !== "1"){
                        alert(data);
                    }else{
                        alert("Login feito com sucesso");
                        window.location.href = "/PHP/app/users/view";
                    }
                });
            });
        });';
$this->end();
?>


<div class="col col-lg-3 col-sm-2 col-md-3">
</div>
<div class="col col-lg-7 col-sm-8 col-md-6">
<?= $this->Form->create('', ['id'=>'login']) ?>
	<div class="input-group input-group-lg">
	<!-- não utilizado padrão form control pois adiciona um label e zoa o bootstrap -->
	  <span class="input-group-addon" id="basic-addon1">E-mail: </span><input type="text" name="email" id="email" class="form-control" placeholder="exemplo@exemplo.com.br" aria-describedby="sizing-addon1">
	</div>
	<div class="input-group input-group-lg">
	  <span class="input-group-addon" id="basic-addon1">Senha: </span>
        <input type="password" class="form-control" name='password' id='password' placeholder="*********" aria-describedby="sizing-addon1">
	</div>
	<?= $this->Form->button(__('Login'), ['class'=>'btn btn-primary']); ?>
<?= $this->Form->end() ?>
</div>
<div class="col col-lg-2 col-sm-2 col-md-3">
</div>