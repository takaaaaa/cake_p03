<?php
// app/Controller/TasksController.php

class TasksController extends AppController {
	public $scaffold;

	public function index() {

	    // データをモデルから取得してビューへ渡す
	    $options = array(
	        'conditions' => array(
	        'Task.status' => 0
	        )
	    );
	    $tasks_data = $this->Task->find('all',$options);
	    $this->set('tasks_data',$tasks_data);

	    // app/View/Tasks/index.ctpを表示
	    $this->render('index');
	}

  public function done() {

      // URLの末尾からタスクのIDを取得してデータを更新
      $id = $this->request->pass[0];
      $this->Task->id = $id;
      $this->Task->saveField('status',1);
      $msg = sprintf('タスク %s を完了しました。',$id);

      // メッセージを表示してリダイレクト
      $this->flash($msg,array('controller' => 'tasks', 'action' => 'index', 'full_base' => true));
  }

  public function create() {

      // POSTされた場合だけ処理を行う
      if ($this->request->is('post')) {
          $data = array(
              'name' => $this->request->data['name']
          );
          // データを登録
          $id = $this->Task->save($data);
          $msg = sprintf(
              'タスク %s を登録しました。',
              $this->Task->id
          );

          // メッセージを表示してリダイレクト
          $this->flash($msg, array('controller' => 'tasks', 'action' => 'index', 'full_base' => true));
          return;
      }
      $this->render('create');
  }
}