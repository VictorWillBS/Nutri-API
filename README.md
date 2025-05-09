## Introdução
Este projeto é uma api de suporte a equipes de nutricionistas da empresa Fitness Foods LC

### Instalação
## Log de Desenvolvimento
### Primeiros passos a ser definidos:

- Qual Stack uitlizar? PHP / Laravel
- Qual Bancos de dados usar? MySql (Tenho mais habilidade, mas posso mudar para Mongo caso não seja custoso)
- Qual Design Pattern seguir? TDD (Inicialmente acredito não ser custoso e cobre um extra)
- Vou usar docker? Não
- Iniciar Desenho do projeto
    - Modelar o Banco de dados
    - Desenhar a Arquitetura da aplicação

- ##### Dúvida!
    - não compreendi como utilizar os arquivos exatamente. Talvez eu tenha que importar eles diariamente até 100 items. Isso explicaria a necessidade do cron. Porém entendi que era para consultar a própria Open Food para atualizar os dados. Necessito entender melhor.

### Segundo Dia: Início do projeto:
- Projeto iniciado seguindo o planejado.
- Adicionei o Sail para cobrir um `Extra[Uso de Docker]` de modo não custoso.
- Enviei a dúvida sobre os imports, Espero ter sanado até amanhã a noite.

- Status atual da aplicação: ~30% (tudo instalado, endpoints de CRUD feitos)
- Próximos passos: Finalizar o desenho de uso do CRON e Jobs Assíncronos para garantir a importação sem quebrar a aplicação.
- Possíveis desafios: Fazer o Handle de uma importação de arquivos tão grandes (se for realmente necessário).


