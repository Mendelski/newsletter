## Desafio - Newsletter System 
Sistema de newsletter


# Descrição
O sistema permitirá que um usuário admin crie tópicos (temas de interesse) e gerencie postagens nos mesmos. Usuários cadastrados em tópcios deverão receber emails a cada nova postagem.

# Requisitos técnicos

- Utilizar a ultima versão stable do Laravel
- É necessário garantir uma cobertura de 100% nos testes
- Adoção do [PHP Insights](https://phpinsights.com/)
- [Laravel Pint](https://laravel.com/docs/11.x/pint)
- O uso do [Sail](https://laravel.com/docs/11.x/sail) é obrigatório para facilitar a configuração e a execução do ambiente de desenvolvimento.
- Utilizar o recurso [Mailpit](https://laravel.com/docs/11.x/sail#previewing-emails), já embutido no Sail
- Frontend: Não é necessário desenvolver um frontend para este projeto. O foco será nas funcionalidades de backend.
- Deve ser criado um arquivo README.md com instruções detalhadas sobre como configurar e executar o projeto.
- Uma seed deve adicionar o usuário admin ao banco de dados.
- Seguir a especificação REST para desenvolvimento de APIs.
- Documentação da API ( OPEN API ou Colleciton do Postman )

# Funcionalidades

- O usuário admin poderá criar TÓPICOS: `pesca, automóveis, programação e etc`
- O admin poderá criar (n) conteúdo(s) para um TÓPICO.
- O sistema deve permitir o cadastro de qualquer usuário.
- Qualquer usuário poderá assinar um ou mais tópicos de seu interesse.
- Quando um tópico receber um novo conteudo, os usuários assinates deverão receber um e-mail.

Encaminhar link do repositório com as instruções para rodar o projeto: lucas.cardial@themembers.com.br e danilo@themembers.com.br com o assunto "Desenvolvedor Backend - [NOME]"

## Observação:
Este é um teste para sênior. Não se limite a soluções simplistas. Considere expressar todos os conhecimentos que você achar válido.

## Instruções para rodar o projeto

Antes de tudo é necessário que você tenha o docker instalado na sua máquina, e caso utilize windows, que tenha um ambiente WSL2 configurado. 

1. Clone o repositório
2. Acesse a pasta do projeto
3. Execute o comando `./vendor/bin/sail up -d`
4. Execute o comando `./vendor/bin/sail artisan migrate --seed`

Pronto! O projeto está rodando. 

### Testes

- Atenção: Ao rodar os testes o banco será resetado, então se você já tiver rodado o comando `./vendor/bin/sail artisan migrate --seed`, será necessário rodar novamente.
Para rodar os testes, execute o comando `./vendor/bin/sail artisan test`
- Foi construido o comando `./vendor/bin/sail artisan email:send-test para enviar um email de teste e verificar se o envio de email está funcionando corretamente.
- Para visualizar os emails enviados, acesse o link `http://localhost:8025/` no seu navegador.

### Documentação da API
A collection do postman está disponível no arquivo `Newsletter.postman_collection.json` na raiz do projeto.
