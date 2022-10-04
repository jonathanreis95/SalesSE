# Desafio da empresa Soft Expert 
 
Para rodar o projeto:
1. Git clone;
2. Criar as tabelas através do script que se encontra no caminho: storage/backup_database.dump se necessário tbm tem o arquivo tables.sql
3. Modificar as Configurações de conexão do banco(Nome/Senha) no caminho: app/dabase.php
3. Renomear o arquivo htacess para .htaccess que se encontra em public/
3. Rodar o composer install
4. rodar o servidor através do comando: php -S localhost:8080 -t public



Futures do projeto:
- Criar Entidades e Services, Repositores
- Ajuste do htacess para rodar o projeto sem o  -t public
- Inserir os dados de texto no banco em Maisculo
- Verificação de dados existentes antes de salvar (Ex: Produto com mesma descrição)
- Transformar o campo de Impostos em Combo.
- Validação de tamanho dos campos (limite de caracteres)
- Validação de caracteres para prevenir SQLInjection [Urls e Inputs]
- Tradução do Datatable

