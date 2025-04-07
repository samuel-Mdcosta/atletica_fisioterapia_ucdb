<?php
    namespace App\Models;

    use MF\Model\Model;
    use PDO;

    class Usuario extends Model{

        private $id;
        private $nome;
        private $email;
        private $cpf;
        private $senha;
        private $telefone;
        private $status_pagamento_id;
        private $foto_perfil;

        public function __get($atributo){
            return $this->$atributo;
        }

        public function __set($atributo, $valor){
            $this->$atributo = $valor;
        }

        //salva
        public function save(){
            //insere as informacoes do cadastro no banco
            $query = "
            INSERT INTO usuarios (nome, email, cpf, senha, status_pagamento_id, telefone) 
            VALUES (:nome, :email, :cpf, :senha, :status_pagamento_id, :telefone);
            ";
            $stmt = $this->db->prepare($query);
            $stmt->bindValue(':nome', $this->__get('nome'));
            $stmt->bindValue(':email', $this->__get('email'));
            $stmt->bindValue(':cpf', $this->__get('cpf'));
            $stmt->bindValue(':senha', $this->__get('senha'));
            $stmt->bindValue(':telefone', $this->__get('telefone'));
            $stmt->bindValue(':status_pagamento_id', 1);
            $stmt->execute();

            return $this;
        } 

        //valida o login
        public function validaCadastro(){
            $valido = true;

            if (strlen($this->__get('nome'))< 3){
                $valido = false;
            }
            if (strlen($this->__get('email'))< 3){
                $valido = false;
            }
            if (strlen($this->__get('cpf'))< 3){
                $valido = false;
            }
            if (strlen($this->__get('senha'))< 3){
                $valido = false;
            }
            if (strlen($this->__get('telefone'))< 3){
                $valido = false;
            }

            return $valido;
        }

        //recupera o usuario por e-mail;
        public function getUsuarioEmail(){
            $query = "
                SELECT 
                    nome, 
                    email,
                    cpf,
                    senha,
                    telefone,
                    status_pagamento_id ,
                    foto_perfil
                FROM 
                    usuarios 
                WHERE 
                    email = :email
            ";
            $stmt= $this->db->prepare($query);
            $stmt->bindValue(':email', $this->__get('email'));
            $stmt->execute();

            //gera um array assosciativo
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }

        public function autenticar() {
            $query = "
                SELECT
                    id, nome, email, cpf, senha, telefone, status_pagamento_id
                FROM
                    usuarios
                WHERE
                    email = :email AND senha = :senha
            ";
            $stmt = $this->db->prepare($query);
            $stmt->bindValue(':email', $this->__get('email'));
            $stmt->bindValue(':senha', $this->__get('senha'));
            $stmt->execute();

            $usuario = $stmt->fetch(\PDO::FETCH_ASSOC);

            if ($usuario && $usuario['id'] != '' && $usuario['nome'] != '') {
                $this->__set('id', $usuario['id']);
                $this->__set('nome', $usuario['nome']);
                $this->__set('status_pagamento_id', $usuario['status_pagamento_id']);
                $_SESSION['id'] = $usuario['id']; // Define o ID do usuário na sessão
            }

            return $this;
        }

        public function listarTodos(){
            $query = '
                select
                    id, nome, email, cpf, senha, telefone, status_pagamento_id
                from
                    usuarios
            ';
            $stmt = $this->db->prepare($query);
            $stmt->execute();
            $usuario = $stmt->fetchAll(\PDO::FETCH_ASSOC);
            return $usuario;
        }        

        public function novoStatus(){
            // Retrieve the current status from the database
            $query = '
                SELECT status_pagamento_id
                FROM usuarios
                WHERE id = :id
            ';
            $stmt = $this->db->prepare($query);
            $stmt->bindValue(':id', $this->__get('id'));
            $stmt->execute();
            $currentStatus = $stmt->fetchColumn();

            $newStatus = ($currentStatus == 1) ? 2 : 1;

            $query = '
                UPDATE
                    usuarios
                SET
                    status_pagamento_id = :status_pagamento_id
                WHERE
                    id = :id
            ';
            $stmt = $this->db->prepare($query);
            $stmt->bindValue(':status_pagamento_id', $newStatus);
            $stmt->bindValue(':id', $this->__get('id'));
            $stmt->execute();

            $this->__set('status_pagamento_id', $newStatus);
        }

        public function updateimgpasta($caminho) {
            try {
                error_log('Função updateimgpasta chamada');
                
                if (!$this->__get('id')) {
                    error_log('Erro: ID do usuário não definido.');
                    return false;
                }
                
                $id = $this->__get('id');
                error_log('ID do usuário: ' . $id);
                error_log('Caminho da imagem: ' . $caminho);
                
                $query = "
                    UPDATE usuarios
                    SET foto_perfil = :foto_perfil
                    WHERE id = :id
                ";
                
                $stmt = $this->db->prepare($query);
                $stmt->bindValue(':foto_perfil', $caminho);
                $stmt->bindValue(':id', $id);
                
                if ($stmt->execute()) {
                    error_log('Imagem salva no banco: ' . $caminho);
                    return true;
                } else {
                    $errorInfo = $stmt->errorInfo();
                    error_log('Erro no banco: SQLSTATE[' . $errorInfo[0] . '] Código: ' . $errorInfo[1] . ' Mensagem: ' . $errorInfo[2]);
                    return false;
                }
            } catch (\Exception $e) {
                error_log('Exceção capturada: ' . $e->getMessage());
                return false;
            }
        }

        public function temounao($id) {
            $query = '
                SELECT 
                    foto_perfil
                FROM
                    usuarios
                WHERE
                    id = :id
            ';

            $stmt = $this->db->prepare($query);
            $stmt->bindValue(':id', $id);
            $stmt->execute();

            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            error_log('Resultado do banco de dados (temounao): ' . json_encode($result)); // Log para depuração
            return $result ? $result : ['foto_perfil' => null]; // Retorna null se não houver imagem
        }

        public function carterinha($id) {
            $query = '
                SELECT 
                    nome, cpf
                FROM 
                    usuarios
                WHERE 
                    id = :id
            ';

            $stmt = $this->db->prepare($query);
            $stmt->bindParam(':id', $id);
            $stmt->execute();
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            return $result;
        }

    }