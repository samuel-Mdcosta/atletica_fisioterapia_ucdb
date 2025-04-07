<?php

    namespace App\Controllers;

    use MF\Controller\Action;
    use MF\Model\Container;

    class authController extends Action {
        public $associados; 

        public function autenticar(){
            session_start();

            $usuario = Container::getModel('usuario');

            $usuario->__set('email', $_POST['email']);
            $usuario->__set('senha', $_POST['senha']);

           $usuario->autenticar();

            if(!empty($usuario->__get('id')) && !empty($usuario->__get('nome'))){
                $_SESSION['id'] = $usuario->__get('id');
                $_SESSION['nome'] = $usuario->__get('nome');
                if($usuario->__get('status_pagamento_id')==1){
                    $this->render('index/telaPagamento');
                }else if($usuario->__get('email') == 'adm@admin.com'){
                    $this->tabelaAssociados();
                    $this->render('index/adm');
                }else{
                    header("location: /autenticar/carterinha");
                }
            }else{
                header('location: /?login=erro');
                exit();
            }

        }

        public function telaPagamento(){
            $this->render('index/telaPagamento');
        }

        public function tabelaAssociados(){
            $usuario = Container::getModel('Usuario');
            $this->associados = $usuario->listarTodos();
        }

        public function newStatus(){
            $usuario = Container::getModel('Usuario');
            $usuario->__set('id', $_POST['id']);
            $usuario->__set('status_pagamento_id', (int)$_POST['status_pagamento_id']);
            $usuario->novoStatus();
        }

    }