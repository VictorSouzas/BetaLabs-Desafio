<?php
namespace App\Controller;

use App\Controller\AppController;


class CommentsController extends AppController
{   
    public $paginate = [
        'limit' => 10,
        'order' => [
            'Comments.id' => 'DESC'
        ]
    ];

    public function initialize()
    {
        parent::initialize();
        $this->loadComponent('Paginator');
    }



    public function index()
    {
        
        $comments = $this->Comments->getCommentsAndAuthors();
        $comments = $this->paginate($comments);

        $this->set('comments', $comments);
        $this->set('_serialize', ['comments']);
    }


    public function view($id = null)
    {
        $comment = $this->Comments->getCommentAndAuthor($id);
        $history = $this->Comments->getHistoryByParent($id);
        $this->set('history', $history);
        $this->set('_serialize', 'history');
        $this->set('comment', $comment);
        $this->set('_serialize', ['comment']);
    }


    public function add()
    {
        $comment = $this->Comments->newEntity();
        if ($this->request->is('post')) {
            $comment = $this->Comments->patchEntity($comment, $this->request->getData());
            $comment->owner = $this->Auth->user('id');
            if(!$comment->errors()){
                if ($this->Comments->save($comment)) {
                    echo 1;
                    exit();
                }
            }

            
            $validationMessage = "";
            foreach ($comment->errors() as $error) {
                $validationMessage .= implode("\n", $error);
            }
            echo $validationMessage;
            exit();
            

        }
        $this->set(compact('comment'));
        $this->set('_serialize', ['comment']);
    }


    public function edit($id = null)
    {
        $comment = $this->Comments->get($id, [
            'contain' => []
        ]);
        if ($this->request->is('post')) {
            $newComent = $this->Comments->newEntity();
            $newComent = $this->Comments->patchEntity($newComent, $this->request->getData());
            $newComent->owner = $this->Auth->user('id');
            if(!$newComent->errors()){
                if ($this->Comments->save($newComent) && $this->Comments->editComment($newComent->id, $id)) {                
                    foreach ($this->Comments->getHistoryByParent($id) as $comment) {
                        $comment->parent = $newComent->id;
                        $this->Comments->save($comment);
                    }
                    echo 1;
                    exit();
                    // redirecionamento feito via javascript
                    //return $this->redirect(['action' => 'index']);
                }
            }   
            $erro = "";
            foreach ($newComent->errors() as $error) {
                $erro = $error;
            }
            $this->Flash->error(__($erro));
            exit();
        }
        $this->set(compact('comment'));
        $this->set('_serialize', ['comment']);
    }


    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $comment = $this->Comments->get($id);
        if ($this->Comments->delete($comment)) {
            $comentariosVelhos = $this->Comments->find()->where(['parent'=>$id]);
            foreach ($comentariosVelhos as $comentario) {
                $this->Comments->delete($comentario);
            }
            $this->Flash->success(__('O comentário foi excluido com sucesso.'));
        } else {
            $this->Flash->error(__('Não foi possivel excluir o comentario tente novamente mais tarde.'));
        }

        return $this->redirect(['action' => 'index']);
    }



    public function isAuthorized($user)
    {
        // todo usuario logado pode adicionar comentario
        if ($this->request->getParam('action') === 'add') {
            return true;
        }

        //só o proprio usuario pode editar seu comentario 
        if (in_array($this->request->getParam('action'), ['edit'])) {
            $commentId = (int)$this->request->getParam('pass.0');
            if ($this->Comments->isOwnedBy($commentId, $user['id'])) {
                return true;
            }
            return false;
        }
        // o administrador pode excluir qualquer comentario
        if (in_array($this->request->getParam('action'), ['delete'])) {
            $commentId = (int)$this->request->getParam('pass.0');
            if ($this->Comments->isOwnedBy($commentId, $user['id'])) {
                return true;
            }
        }

        return parent::isAuthorized($user);
    }


}
