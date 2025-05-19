## Introdução

Este projeto é uma api de suporte a equipes de nutricionistas da empresa Fitness Foods LC

This is a challenge by [Coodesh](https://coodesh.com/)

## Requirementos

-   Composer [^2.7].
-   Docker [^28.0].
-   Docker Compose [^2.30.0].

## Instalação

Siga os passos abaixo para configurar o ambiente:

---

#### Instale o Laravel (caso ainda não tenha)

```bash
composer global require laravel/installer
```

---

#### Inicie o servidor

```bash
exec ./init.sh
```

---

#### Execute as migrações e popule o banco de dados

```bash
./vendor/bin/sail artisan migrate --seed
```

---

#### Inicie o agendador (cron)

```bash
./vendor/bin/sail artisan schedule:work
```

---

#### Inicie a fila de tarefas (Horizon)

Abra outra janela do terminal e execute:

```bash
./vendor/bin/sail artisan horizon
```

## Log de Desenvolvimento

### Primeiros passos a ser definidos:

-   Qual Stack uitlizar? PHP / Laravel
-   Qual Bancos de dados usar? MySql (Tenho mais habilidade, mas posso mudar para Mongo caso não seja custoso)
-   Qual Design Pattern seguir? TDD (Inicialmente acredito não ser custoso e cobre um extra)
-   Vou usar docker? Não
-   Iniciar Desenho do projeto

    -   Modelar o Banco de dados
    -   Desenhar a Arquitetura da aplicação

-   ##### Dúvida!
    -   não compreendi como utilizar os arquivos exatamente. Talvez eu tenha que importar eles diariamente até 100 items. Isso explicaria a necessidade do cron. Porém entendi que era para consultar a própria Open Food para atualizar os dados. Necessito entender melhor.

### Segundo Dia: Início do projeto:

-   Projeto iniciado seguindo o planejado.
-   Adicionei o Sail para cobrir um `Extra[Uso de Docker]` de modo não custoso.
-   Enviei a dúvida sobre os imports, Espero ter sanado até amanhã a noite.

-   Status atual da aplicação: ~30% (tudo instalado, endpoints de CRUD feitos)
-   Próximos passos: Finalizar o desenho de uso do CRON e Jobs Assíncronos para garantir a importação sem quebrar a aplicação.
-   Possíveis desafios: Fazer o Handle de uma importação de arquivos tão grandes (se for realmente necessário).

### Terceiro Dia: Imprevistos:

-   tive alguns problemas de saúde que me impediu de avançar neste dia.

### Quarto Dia: Construção das importações:

-   como previsto no dia 3, iniciei a construção da parte de imporatações. Fiz de maneira dinâmica de modo que bastasse
    inicializar o projeto com o como `exec ./init.sh` para que ja iniciassem todas importações.
-   Temos uma meta importação, Index.txt, que ordena a importação de outros arquivos products.json.gz
-   Também temos a importação e a extração desse json do arquivo gz, nesta parte eu travei quanto o decode do json e a
    conversão do dado para aplicação. Mas acredito que so seja um problema de extração do json e não de conversão.
-

### Quinto Dia:

-   Após alguns dias do prazo estendido, consegui melhorar. Fico grato pela consideração e oportunidade.
    Isto muito me animou para dar o meu melhor para o desafio. Muito grato!   

-   Fiz a finalização das importações usando um conversor nas models.
-   Fiz a implementação da atualização do diaria dos produtos atendendo o limite de RPM 100 produtos por arquivo.
-   Fiz a implementação do cron para executar a importação diaria dos produtos.
-   Fiz a implementação do serviço de importação para garantir que a importação seja feita de maneira assíncrona.
-   Fiz a implementação de testes unitários para garantir a isonomia dos métodos e permitir alterações futuras/
-   Fiz a implementação de um job assincrono para limpeza do banco de dados de importações ja completadas, para
    garantir limpeza do DB.
-   Fiz a implementação de um job assincrono para lidar com as importações que não foram concluídas.

-   Utilizei bastante assincronicidade para garantir a operância da api em primeiro plano.
