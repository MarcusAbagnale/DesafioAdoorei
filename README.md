## DesafioAdoorei
Este é um projeto desenvolvido utilizando Docker e Laravel Sail para facilitar o ambiente de desenvolvimento. Antes de começar, assegure-se de ter o Docker instalado em sua máquina.

## Instalação e Configuração
## 1. Instalar Dependências
Execute o seguinte comando para instalar as dependências do projeto:

bash
``` 
docker run --rm \
    -u "$(id -u):$(id -g)" \
    -v "$(pwd):/var/www/html" \
    -w /var/www/html \
    laravelsail/php82-composer:latest \
    composer install --ignore-platform-reqs
```
## 2. Configurar o arquivo .env
Configure o arquivo .env conforme necessário para o seu ambiente.

## 3. Inicializar o Servidor
Execute o seguinte comando para iniciar o servidor:

bash
 ```
./vendor/bin/sail up -d
```
## 4. Acessar o Container Laravel
Para executar comandos no ambiente Laravel, acesse o container utilizando o seguinte comando:

bash
 ```
docker-compose exec laravel.test bash
```

## 5. Instalar Dependências e Configurações
Dentro do container Laravel, execute os seguintes comandos:

bash
 
```
composer install
php artisan key:generate
php artisan migrate
php artisan db:seed
```

## 6. Testar Autenticação com Sanctum
Após configurar o ambiente, efetue os testes com usuário autenticado via Sanctum.

Testando suas APIs com Postman
Para começar, siga estas instruções para criar um usuário e obter um token bearer para testar suas APIs no Postman:

Abra o terminal e execute o comando abaixo para acessar o Tinker, uma ferramenta interativa do Laravel:
bash
 ```
php artisan tinker
```
No Tinker, execute o seguinte código para criar um novo usuário:
```
php
 
$user = new App\Models\User;
$user->name = 'User';
$user->email = 'usuario@example.com';
$user->password = bcrypt('senha');
$user->save();
Isso criará um usuário com o nome 'User', o email 'usuario@example.com' e a senha 'senha'.

```

Agora, abra o Postman e faça uma solicitação POST para localhost/token com o seguinte corpo da solicitação:
json
 ```
{
    "email": "usuario@example.com",
    "password": "senha",
    "device_name": "Postman"
}
```
Isso enviará suas credenciais de usuário para a rota /token e retornará um token de acesso pessoal, que você pode usar para autenticar outras solicitações.

Lembre-se de substituir localhost pelo endereço do seu aplicativo Laravel, se necessário.

Agora você está pronto para testar suas APIs utilizando o token de acesso pessoal gerado. 

Este é um projeto criado como parte do desafio "Adoorei". 
