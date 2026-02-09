# Documentação: Sistema de Verificação de E-mail com Código de 6 Dígitos

## 1. Introdução

Este documento detalha a implementação de um sistema de verificação de e-mail robusto para o projeto Laravel, utilizando o Jetstream e Fortify. O objetivo principal é garantir que novos usuários validem seu endereço de e-mail através de um código de 6 dígitos antes de terem acesso completo à plataforma, impedindo o login até que a verificação seja concluída.

## 2. Visão Geral do Projeto

O projeto `testejetstream` é construído sobre o framework Laravel, utilizando o Jetstream para funcionalidades de autenticação e gerenciamento de usuários, que por sua vez se baseia no Fortify. As modificações foram realizadas para integrar a lógica de verificação de e-mail personalizada com o fluxo de autenticação existente.

## 3. Alterações na Base de Dados

Para armazenar o código de verificação, foi adicionado um novo campo à tabela `users`.

### 3.1. Migração `2026_02_09_000000_add_verification_code_to_users_table.php`

Foi criada uma nova migração para adicionar a coluna `verification_code` à tabela `users`. Esta coluna é do tipo `string` com um tamanho máximo de 6 caracteres e é `nullable`, permitindo que o campo seja nulo após a verificação do e-mail. O código de 6 dígitos é armazenado como string para preservar zeros à esquerda, caso sejam gerados.

```php
Schema::table(\'users\', function (Blueprint $table) {
    $table->string(\'verification_code\', 6)->nullable()->after(\'password\');
});
```

## 4. Alterações no Modelo `User`

O modelo `App\Models\User` foi modificado para integrar a funcionalidade de verificação de e-mail e a notificação personalizada.

### 4.1. Implementação de `MustVerifyEmail`

A interface `Illuminate\Contracts\Auth\MustVerifyEmail` foi implementada no modelo `User`. Esta interface é crucial para que o Laravel e o Fortify reconheçam que este modelo de usuário requer verificação de e-mail, ativando automaticamente middlewares e rotas relacionadas à verificação.

```php
class User extends Authenticatable implements \Illuminate\Contracts\Auth\MustVerifyEmail
{
    // ...
}
```

### 4.2. Adição ao `$fillable`

O campo `verification_code` foi adicionado ao array `$fillable` do modelo `User`, permitindo que ele seja atribuído em massa durante a criação ou atualização do usuário.

```php
protected $fillable = [
    // ...
    \'password\',
    \'verification_code\',
    // ...
];
```

### 4.3. Sobrescrita de `sendEmailVerificationNotification`

O método `sendEmailVerificationNotification` foi sobrescrito para utilizar a notificação personalizada `VerifyEmailWithCode`. Isso garante que, ao invés do e-mail de verificação padrão do Laravel, seja enviado um e-mail contendo o código de 6 dígitos gerado.

```php
public function sendEmailVerificationNotification()
{
    $this->notify(new \App\Notifications\VerifyEmailWithCode);
}
```

## 5. Lógica de Criação de Usuário (`CreateNewUser.php`)

A classe `App\Actions\Fortify\CreateNewUser`, responsável por criar novos usuários no sistema, foi modificada para gerar e armazenar o código de verificação.

### 5.1. Geração e Armazenamento do Código

No método `create`, antes de salvar o novo usuário no banco de dados, um código de 6 dígitos é gerado aleatoriamente usando `random_int` e formatado com `str_pad` para garantir que sempre tenha 6 dígitos (preenchendo com zeros à esquerda, se necessário). Este código é então salvo na coluna `verification_code` do usuário.

```php
return tap(User::create([
    // ...
    \'password\' => Hash::make($input[\'password\']),
    \'verification_code\' => str_pad(random_int(0, 999999), 6, \'0\', STR_PAD_LEFT),
]), function (User $user) {
    // ...
});
```

## 6. Lógica de Autenticação (`FortifyServiceProvider.php`)

O `App\Providers\FortifyServiceProvider` foi ajustado para interceptar o processo de autenticação e impedir que usuários com e-mail não verificado façam login.

### 6.1. Bloqueio de Login para E-mails Não Verificados

No método `authenticateUsing`, foi adicionada uma condição para verificar se o e-mail do usuário foi verificado (`$user->hasVerifiedEmail()`). Se o e-mail não estiver verificado, o método retorna `null`, efetivamente bloqueando o login do usuário. Esta lógica é executada após a verificação de credenciais e antes de permitir o acesso.

```php
Fortify::authenticateUsing(function (Request $request) {
    $user = User::where(\'email\', $request->email)->first();

    if ($user && Hash::check($request->password, $user->password)) {
        // ... (regra existente para bloquear admin)

        // Bloqueia se o e-mail não estiver verificado
        if (!$user->hasVerifiedEmail()) {
            return null;
        }

        return $user;
    }
});
```

## 7. Componente Livewire para Verificação de Código

Foi criado um componente Livewire para gerenciar a interface e a lógica de validação do código de 6 dígitos na página de verificação de e-mail.

### 7.1. Classe `App\Livewire\VerifyEmailCode.php`

Este componente Livewire possui:

*   **Propriedade `$code`**: Armazena o código digitado pelo usuário.
*   **Regras de Validação**: Garante que o código seja uma string de 6 caracteres (`required|string|size:6`).
*   **Método `verify()`**: 
    *   Valida o código inserido.
    *   Compara o `$code` digitado com o `verification_code` armazenado no modelo `User`.
    *   Se os códigos coincidirem, chama `$user->markEmailAsVerified()` para marcar o e-mail como verificado no Laravel.
    *   Define `verification_code` como `null` no banco de dados para segurança e limpeza.
    *   Redireciona o usuário para a página inicial (`dashboard`) após a verificação bem-sucedida.
    *   Se os códigos não coincidirem, adiciona um erro de validação para exibir uma mensagem ao usuário.

### 7.2. View `resources/views/livewire/verify-email-code.blade.php`

Esta view contém um formulário simples com um campo de entrada para o código de 6 dígitos e um botão de submissão. Ela utiliza as diretivas `@wire` para interagir com o componente Livewire, exibindo mensagens de erro de validação, se houver.

## 8. Notificação Personalizada (`VerifyEmailWithCode.php`)

A notificação `App\Notifications\VerifyEmailWithCode` é responsável por formatar e enviar o e-mail contendo o código de verificação.

### 8.1. Conteúdo do E-mail

Esta notificação cria um `MailMessage` que inclui:

*   Um assunto claro: "Seu Código de Verificação - Projeto Ellas".
*   Uma saudação personalizada ao usuário.
*   Instruções para usar o código.
*   O código de 6 dígitos em destaque.
*   Uma mensagem de segurança padrão.

## 9. View de Verificação (`verify-email.blade.php`)

A view `resources/views/auth/verify-email.blade.php` foi completamente redesenhada para acomodar o novo fluxo de verificação por código.

### 9.1. Integração do Componente Livewire

O componente `VerifyEmailCode` é incluído diretamente na view usando a diretiva `@livewire('verify-email-code')`. Isso substitui o fluxo de verificação por link padrão do Jetstream por uma interface de entrada de código.

### 9.2. Funcionalidade de Reenvio

Um formulário para reenviar o código de verificação foi mantido, permitindo que o usuário solicite um novo código caso o primeiro não chegue ou expire. O método `sendEmailVerificationNotification` no modelo `User` será acionado novamente, gerando um novo código e enviando um novo e-mail.

## 10. Fluxo do Usuário

1.  **Cadastro**: O usuário se cadastra na plataforma.
2.  **Geração do Código**: No momento do cadastro, um código de 6 dígitos é gerado e salvo no banco de dados para o usuário.
3.  **E-mail de Verificação**: Um e-mail contendo o código de 6 dígitos é enviado para o endereço de e-mail do usuário.
4.  **Redirecionamento para Verificação**: O usuário é redirecionado para a página `/email/verify` (ou a rota configurada para verificação de e-mail).
5.  **Tentativa de Login Bloqueada**: Se o usuário tentar fazer login antes de verificar o e-mail, o sistema o impedirá, pois o `FortifyServiceProvider` bloqueará o acesso.
6.  **Entrada do Código**: Na página de verificação, o usuário insere o código de 6 dígitos recebido por e-mail no campo fornecido pelo componente Livewire.
7.  **Validação**: Ao submeter o código, o componente Livewire `VerifyEmailCode` valida o código. Se correto, o e-mail do usuário é marcado como verificado, o código é limpo do banco de dados e o usuário é redirecionado para o dashboard.
8.  **Acesso Liberado**: Com o e-mail verificado, o usuário pode fazer login normalmente e acessar todas as funcionalidades da plataforma.

## 11. Considerações Finais

Este sistema proporciona uma camada adicional de segurança e controle sobre o processo de registro, garantindo que apenas usuários com e-mails válidos possam acessar a plataforma. A utilização do Livewire oferece uma experiência de usuário fluida para a entrada do código, sem a necessidade de recarregar a página. O commit `ea2eb74` no repositório `MauricioLopes-Dev/testejetstream` contém todas as alterações descritas neste documento.
