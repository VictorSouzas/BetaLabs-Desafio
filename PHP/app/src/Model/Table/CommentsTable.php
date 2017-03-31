<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\Table;
use Cake\Validation\Validator;
use Cake\ORM\TableRegistry;


class CommentsTable extends Table
{   
    


    public function initialize(array $config)
    {
        parent::initialize($config);

        $this->setTable('comments');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');
    }


    public function validationDefault(Validator $validator)
    {
        $validator
            ->integer('id')
            ->allowEmpty('id', 'create');

        $validator
            ->integer('parent')
            ->allowEmpty('parent');

        $validator
            ->integer('owner')
            ->requirePresence('owner', 'create')
            ->notEmpty('owner');
        $validator     
            ->requirePresence('comment')
            ->notEmpty('comment', 'Favor preencher o comentario.');
        $validator
            ->add('comment', 'minLength',
                [
                'rule' => ['minLength', 10],
                'message' => 'Seu comentario deve ter no minimo 10 caracteres'
                ]);

        return $validator;
    }

    public function isOwnedBy($commentId, $userId)
    {
        return $this->exists(['id' => $commentId, 'owner' => $userId]);
    }

    
    public function getAuthorByID($id)
    {
        $users = TableRegistry::get('Users');
        $user = $users->find()->where(['id' => $id]);
        if($user){
            return $user;
        }
        return null;
    }

    public function getParents(){
        return $this->find()->where(['parent' => 0]);
    }
    
    public function getHistoryByParent($id){
        return $this->find()->where(['parent' => $id])
            ->join([
                    'table' => 'users',
                    'alias' => 'u',
                    'type' => 'LEFT',
                    'conditions' => 'Comments.owner = u.id'
                ])
            ->select(['u.name', 'u.picture', 'Comments.comment', 'Comments.id', 'Comments.created'])
            ->order(['Comments.id' => 'DESC']);
    }

    /*
     * troca a data dos comentarios e atualiza o parent do comentario anterior
     */
    public function editComment($novoId, $antigoId){
        $comment = $this->get($antigoId);
        $novo = $this->get($novoId);
        $dataNovo = $novo->created;
        $novo->created = $comment->created;
        $comment->created = $dataNovo;
        $comment->parent = $novoId;
        $this->save($novo);
        return $this->save($comment);
    }

    public function getCommentsAndAuthors(){
         return $this->find('all')
            ->where(['parent' => 0])
            ->join([
                    'table' => 'users',
                    'alias' => 'u',
                    'type' => 'LEFT',
                    'conditions' => 'Comments.owner = u.id'
                ])
            ->select(['u.name', 'u.picture', 'Comments.comment', 'Comments.id', 'Comments.created', 'Comments.owner'])
            ->order(['Comments.id' => 'DESC']);
    }

    public function getCommentAndAuthor($id){
         return $this->find('all')
            ->where(['Comments.id' => $id])
            ->join([
                    'table' => 'users',
                    'alias' => 'u',
                    'type' => 'LEFT',
                    'conditions' => 'Comments.owner = u.id'
                ])
            ->select(['u.name', 'u.picture', 'Comments.comment', 'Comments.id','Comments.created'])
            ->order(['Comments.id' => 'DESC']);
    }

}
