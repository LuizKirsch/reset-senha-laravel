
# Redefinição de Senha com Laravel

Este projeto é uma aplicação Laravel que permite aos usuários redefinirem suas senhas através de um link enviado por e-mail.




## Funcionalidades

* Envio de e-mail para redefinição de senha
* Formulário para alterar a senha do usuário
* Verificação de token de redefinição de senha
* Suporte a expiração de tokens de redefinição de senha

## Requisitos

* PHP 8.1+
* Composer
* MySQL ou outro banco de dados suportado
* Laravel 11.x
## Instalação

Clone o repositório para sua máquina local:

```bash
  git clone https://github.com/LuizKirsch/reset-senha-laravel.git
  cd reset-senha-laravel
```

Instale as dependências do Composer:

```bash
  composer install
```
Crie o arquivo .env:

```bash
  cp .env.example .env
```

Configure o arquivo .env com as informações do seu banco de dados e servidor de e-mail:

```bash
  DB_CONNECTION=mysql
  DB_HOST=127.0.0.1
  DB_PORT=3306
  DB_DATABASE=sua_base_de_dados
  DB_USERNAME=seu_usuario
  DB_PASSWORD=sua_senha

  MAIL_MAILER=smtp
  MAIL_HOST=seu_host
  MAIL_PORT=sua_porta
  MAIL_USERNAME=null
  MAIL_PASSWORD=null
  MAIL_ENCRYPTION=null
  MAIL_FROM_ADDRESS="noreply@suaaplicacao.com"
  MAIL_FROM_NAME="${APP_NAME}"
```

Execute as migrações do banco de dados:

```bash
  php artisan migrate
```

## Personalização

Expiração do Token de Redefinição de Senha
Você pode ajustar o tempo de expiração dos tokens de redefinição de senha no arquivo config/auth.php:



```php
'passwords' => [
    'users' => [
        'provider' => 'users',
        'table' => 'password_resets',
        'expire' => 60, // Expira em 60 minutos
        'throttle' => 60,
    ],
],
```
## Notificações Personalizadas (URL)

Caso queira personalizar o conteúdo do e-mail de redefinição de senha, você pode sobrescrever o método sendPasswordResetNotification no modelo de usuário (App\Models\User):

```php
public function sendPasswordResetNotification($token): void
    {
        $url = URL::to('/reset-password/' . $token);

        $this->notify(new PasswordResetNotification($url));
    }
```
## Referência

 - [Documentação Oficial do Laravel sobre Redefinição de Senha](https://laravel.com/docs/11.x/passwords)
