<?php
    namespace App\Controllers;

use App\Models\Usuario;
use FPDF as GlobalFPDF;
use MF\Controller\Action;
    use MF\Model\Container;
    use MF\fpdf\fpdf;

    class cardController extends Action{

        public function view() {
            $this->enderecoimg(); // Carrega a imagem do usuário

            if (session_status() !== PHP_SESSION_ACTIVE) {
                session_start();
            }

            if (empty($_SESSION['id'])) {
                http_response_code(401); // Define o código de resposta HTTP como "Não autorizado"
                header('Location: /'); // Redireciona para a página de login
                exit('Erro: Usuário não autenticado. Faça login para continuar.');
            }

            $usuario = Container::getModel('Usuario');
            $usuario->__set('id', $_SESSION['id']);
            $carterinha = $usuario->carterinha($_SESSION['id']); // Busca os dados da carteirinha
            $this->view->carterinha = $carterinha; // Passa os dados para a view

            $this->render('index/carterinha');
        }

        public function saveimg() {
            if (session_status() !== PHP_SESSION_ACTIVE) {
                session_start(); // Inicia a sessão apenas se ainda não estiver ativa
            }
        
            // Verifica se o ID do usuário está definido na sessão
            if (empty($_SESSION['id'])) {
                http_response_code(401); // Define o código de resposta HTTP como "Não autorizado"
                header('Location: /'); // Redireciona para a página de login
                exit('Erro: Usuário não autenticado. Faça login para continuar.');
            }
        
            $usuario = Container::getModel('Usuario');
            $usuario->__set('id', $_SESSION['id']);
        
            if (!isset($_FILES["foto"])) {
                die('Erro: Nenhuma imagem enviada.');
            }
        
            if ($_FILES["foto"]["error"] !== UPLOAD_ERR_OK) {
                die('Erro no upload da imagem: ' . $_FILES["foto"]["error"]);
            }
        
            $foto = $_FILES["foto"];
            $nome = pathinfo($foto["name"], PATHINFO_FILENAME); // Pega apenas o nome do arquivo
            $extensao = strtolower(pathinfo($foto["name"], PATHINFO_EXTENSION)); // Pega a extensão
            $permitidas = ['jpg', 'jpeg', 'png', 'gif'];
        
            if (!in_array($extensao, $permitidas)) {
                die('Erro: Formato de imagem inválido. Use JPG, JPEG, PNG ou GIF.');
            }
        
            $tmp_name = $foto["tmp_name"];
            $pasta = "img/fotosassociados/";
            $novo_nome = uniqid() . "_" . $nome . "." . $extensao;
            $caminho = $pasta . $novo_nome;
        
            if (!move_uploaded_file($tmp_name, $caminho)) {
                die('Erro ao mover o arquivo.');
            }
        
            if ($usuario->updateimgpasta($caminho)) {
                header('location: /autenticar/carterinha');
            } else {
                echo 'Erro ao salvar a imagem no banco de dados.';
            }
        }

        public function enderecoimg() {
            if (session_status() !== PHP_SESSION_ACTIVE) {
                session_start(); // Inicia a sessão apenas se ainda não estiver ativa
            }
        
            if (empty($_SESSION['id'])) {
                http_response_code(401); // Define o código de resposta HTTP como "Não autorizado"
                header('Location: /'); // Redireciona para a página de login
                exit('Erro: Usuário não autenticado. Faça login para continuar.');
            }
        
            $usuario = Container::getModel('Usuario');
            $usuario->__set('id', $_SESSION['id']);
        
            $retornaimg = $usuario->temounao($_SESSION['id']); 
            error_log('Caminho da imagem retornado no controller: ' . json_encode($retornaimg)); // Log para depuração
            $this->view->retornaimg = $retornaimg; // Certifique-se de que está atribuindo corretamente
        }

    }