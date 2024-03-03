# DesafioAdoorei



Para começar, siga estas instruções para criar um usuário e obter um token bearer para testar suas APIs no Postman:

Abra o terminal e execute o comando abaixo para acessar o Tinker, uma ferramenta interativa do Laravel:
bash
Copy code
php artisan tinker
No Tinker, execute o seguinte código para criar um novo usuário:
php
Copy code
$user = new App\Models\User;
$user->name = 'User';
$user->email = 'usuario@example.com';
$user->password = bcrypt('senha');
$user->save();
Isso criará um usuário com o nome 'User', o email 'usuario@example.com' e a senha 'senha'.

Agora, abra o Postman e faça uma solicitação POST para localhost/token com o seguinte corpo da solicitação:
json
Copy code
{
    "email": "usuario@example.com",
    "password": "senha",
    "device_name": "Postman"
}
Isso enviará suas credenciais de usuário para a rota /token e retornará um token de acesso pessoal, que você pode usar para autenticar outras solicitações.

Lembre-se de substituir localhost pelo endereço do seu aplicativo Laravel, se necessário.