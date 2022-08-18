# alura-php-mvc
Exercícios do curso MVC com PHP: entenda o padrão Model-View-Controller da Alura.
## Requisitos:
Ter instalado o composer e o PHP (versão 7.3 ou superior) com com extensão do pdo_sqlite habilitada.
No windows tem de descomentar (remover o ;) a linha "extension=pdo_sqlite" no arquivo php.ini.
## Instalação:
No terminal: 
```
git clone https://github.com/carlosmadsen/alura-php-mvc.git
cd alura-php-mvc 
composer install 
```
Criação do banco de dados sqlite.
```
php .\commands\doctrine.php orm:schema-tool:create
```
Criando cursos:
```
php .\commands\criar-cursos.php
```
Criando usuário:
```
php .\commands\criar-usuario.php <seu-email> <sua-senha>
```
por exemplo:
```
php .\commands\criar-usuario.php carlos.exemplo@gmail.com senha123
```
Inicializando o servidor web: 
```
php -S localhost:8080 -t public
```
## Exemplo de uso:
Acesse no seu navegador o endereço http://localhost:8080/login e se identifique com o e-mail e senha definidos no comando "criar-usuario.php". 