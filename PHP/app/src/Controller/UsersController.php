<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\Event\Event;
use Cake\Auth\DefaultPasswordHasher;


class UsersController extends AppController
{   
    public $paginate = [
        'limit' => 10,
        'order' => [
            'Users.id' => 'DESC'
        ]
    ];
    public function initialize()
    {
        parent::initialize();
        $this->loadComponent('RequestHandler');
    }

    
    public function index()
    {
        $users = $this->paginate($this->Users);

        $this->set(compact('users'));
        $this->set('_serialize', ['users']);
    }

    
    public function view($id = null)
    {
        if($id == null)
                $id = $this->Auth->user('id');
        $user = $this->Users->get($id, [
            'contain' => []
        ]);

        $this->set('user', $user);
        $this->set('_serialize', ['user']);
    }

    
    public function add()
    {
        $user = $this->Users->newEntity();
        if ($this->request->is('post')) {
            $user = $this->Users->patchEntity($user, $this->request->getData());
            if(!$user->errors()){
                if ($this->Users->save($user)) {
                    echo 1;
                    exit();
                    //$this->Flash->success(__('O usuario foi cadastrado com sucesso.'));
                    //return $this->redirect(['action' => 'login']);
                }
            }
            $validationMessage = "";
            foreach ($user->errors() as $error) {
                $validationMessage .= implode("\n", $error);
            }
            echo $validationMessage;
            exit();
        }
        $this->set(compact('user'));
        $this->set('_serialize', ['user']);
    }

    
    public function edit($id = null)
    {   
        if($id === null)
            $id = $this->Auth->user('id');
        $user = $this->Users->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $user = $this->Users->patchEntity($user, $this->request->getData());
            if ($this->Users->save($user)) {
                echo 1;
                exit();
            }
            if($user->errors()){
                $validationMessage = "";
                foreach ($user->errors() as $error) {
                    $validationMessage .= implode("\n", $error);
                }
                echo $validationMessage;
                exit();
            }
        }
        $this->set(compact('user'));
        $this->set('_serialize', ['user']);
    }

    
    public function delete($id = null)
    {   
        
        $this->request->allowMethod(['post', 'delete']);
        $user = $this->Users->get($id);
        if ($this->Users->delete($user)) {
            $this->Flash->success(__('O usuario foi excluido com sucesso.'));
        } else {
            $this->Flash->error(__('O Usuario não pode ser excluido, você possui comentarios nesse site.'));
        }
        if($this->Auth->user('id') == $id || $id == null){
            return $this->redirect(['action' => 'logout']);
        }
        return $this->redirect(['action' => 'view']);
    }



   
    public function beforeFilter(Event $event)
    {
        parent::beforeFilter($event);
        $this->Auth->allow(['add', 'logout']);
        $this->Auth->deny(['view','edit', 'delete', 'index', 'upload']);
    }

    /*
     * verifica se o email e senha batem e loga o usuario.
     */
    public function login() {
        if($this->request->is('post')) {
            $login = $this->request->getData();

            $user = $this->Users->find()
                         ->where(['email' => $login['email']])
                         ->first();

            $hash = new DefaultPasswordHasher();

            if(isset($user) && $hash->check($login['password'], $user->password)) {

                echo 1;
                $this->Auth->setUser($user);
                //return $this->redirect($this->Auth->redirectUrl());
                exit();
            }
            echo "E-mail ou senha invalidos.";
            exit();
            
        }

    }

    public function logout()
    {
        return $this->redirect($this->Auth->logout());
    }

    public function isAuthorized($user)
    {
        // All registered users can add articles
        if ($this->request->getParam('action') === 'add') {
            return true;
        }

        //só o proprio usuario pode editar seu comentario 
        if (in_array($this->request->getParam('action'), ['edit', 'view', 'delete', 'upload'])) {
            if($this->Auth->user() !== null)
                return true;
        }

        return parent::isAuthorized($user);
    }

    public function upload($id = null){

        if($id == null)
            $id = $this->Auth->user('id');
        if (!empty($this->request->data)) {
        if (!empty($this->request->data['upload']['name'])) {
        $imagem = $this->request->data['upload']; 

        $extensao = substr(strtolower(strrchr($imagem['name'], '.')), 1); 
        $extensaoValida = array('jpg', 'jpeg', 'gif', 'png'); 
        $novoNomeDaImagem = time() . "_" . rand(000000, 999999);

        
        if (in_array($extensao, $extensaoValida)) {
            
            move_uploaded_file($imagem['tmp_name'], WWW_ROOT . 'upload/' . $novoNomeDaImagem . '.' . $extensao);

            
            $nomeDaImagem = $novoNomeDaImagem . '.' . $extensao;
            }else{

                $this->Flash->success('extensão invalida.');
                return $this->redirect(['action' => 'edit']);
            }
        }

        if (!empty($this->request->data['upload']['name'])) {
            $user = $this->Users->get($id);
            $user->picture = $nomeDaImagem;
        }


        if ($this->Users->save($user)) {
            if($this->Auth->user('picture') != "")
                unlink(WWW_ROOT . 'upload/'.$this->Auth->user('picture'));
            $this->Auth->setUser($user);
            return $this->redirect(['action' => 'view']);
           } else {
                $this->Flash->error('Não foi possivel atualizar sua imagem.');

                return $this->redirect(['action' => 'edit']);
           }
        }
    }

}
