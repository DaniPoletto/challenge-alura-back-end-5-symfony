# Challenge Alura Back-end 5 edição

> :construction: Projeto em construção :construction:

## O que é um challenge
São 4 semanas de desafios propostos pela plataforma de ensino Alura com o objetivo de praticar construindo um projeto. Toda semana são disponibilizados desafios e o aluno deve usar o material de apoio fornecido a cada semana para resolver o desafio proposto. 

### Projeto
Essa edição tem como objetivo construir uma api de plataforma de streaming. 

### Desafios de cada semana
- [X] <b>1ª semana</b> - CRUD de videos e testes de api utilizando Postman

- [ ] <b>2ª semana</b> - Nesta segunda semana do desafio o objetivo é criar mais de um modelo/entidade, rotas CRUD e relacionais, buscas na base via parâmetros de query, fazer testes de unidade e integração.

- [ ] <b>3ª e 4ª semana</b> - Na última fase do desafio o objetivo será a implementação de mais funcionalidades: paginação, autenticação; deploy da aplicação.-

## Tecnologias utilizadas
[Symfony 5.4](https://symfony.com/doc/5.4/setup.html), Doctrine e PHP 7.3.5. 

## Versão em Laravel
> [Versão em Laravel](https://github.com/DaniPoletto/challenge-alura-back-end-5-laravel)

## Como inicializar o projeto
1 - Baixar os arquivos do repositório utilizando git clone

2 - Instalar as dependências do projeto
``` 
componser install
```

3 - Editar o arquivo .env com as credencias do banco de dados

4 - Criar banco
```
php bin\console doctrine:database:create
```

5 - Rodar as migrations
```
php bin\console doctrine:migrations:migrate
```

6 - Subir servidor
```
php -S localhost:8080 -t public
```

## Padrão
O padrão de formato utilizado é o Json tanto para requisições como resposta.

## URL Base
 > http://localhost:8080

## Rotas

### Autenticação
| Método | Rota | Descrição | BODY PARAMS | QUERY PARAMS |
| --- | --- | --- | --- | --- |
| GET | /login | Retorna token obrigatório em todas as outras requisições | <pre>{<br>"usuario": "teste@teste.com.br",<br>"senha": "123456"<br>}</pre> | - |

O login e senha padrão são "teste@teste.com.br" e "123456". A autenticação é feita passando um Bearer Token como Authorization.

### Videos
#### Retornar videos
| Método | Rota | Descrição | BODY PARAMS | QUERY PARAMS |
| --- | --- | --- | --- | --- |
| GET | /videos | Retornar todos os videos | - | - |

##### Ordenação
```
http://localhost:8080/videos?sort[titulo]=ASC&sort[url]=DESC
```

##### Filtros
```
http://localhost:8080/videos?titulo=curso laravel
```

##### Paginação
```
http://localhost:8080/videos?page=1&per_page=2
```

![Video](https://github.com/DaniPoletto/challenge-alura-back-end-5-symfony/blob/main/get_videos.jpg)

#### Retornar um video
| Método | Rota | Descrição | BODY PARAMS | QUERY PARAMS |
| --- | --- | --- | --- | --- |
|GET | /videos/{id} | Retornar um video por id | - | - |

![Video](https://github.com/DaniPoletto/challenge-alura-back-end-5-symfony/blob/main/get_video.jpg)

#### Cadastrar um video
| Método | Rota | Descrição | BODY PARAMS | QUERY PARAMS |
| --- | --- | --- | --- | --- |
|POST | /videos | Cadastrar um video | <pre>{<br> "titulo": "Aula Laravel",<br> "descricao": "videoaula de laravel",<br> "url": "laravel.com.br"<br>}</pre> | - |

##### Campos

| Nome | Tipo | Descrição | 
| --- | --- | --- | 
|titulo | string | Obrigatório | 
|descricao | string | Obrigatório | 
|url | string | Obrigatório | 

![Video](https://github.com/DaniPoletto/challenge-alura-back-end-5-symfony/blob/main/post_video.jpg)

#### Atualizar um video
| Método | Rota | Descrição | BODY PARAMS | QUERY PARAMS |
| --- | --- | --- | --- | --- |
|PUT | /videos/{id} |Atualizar um video por id | <pre>{<br> "titulo": "Aula Laravel",<br> "descricao": "videoaula de laravel",<br> "url": "laravel.com.br"<br>}</pre> | - |

##### Campos

| Nome | Tipo | Descrição | 
| --- | --- | --- | 
|titulo | string | Obrigatório | 
|descricao | string | Obrigatório | 
|url | string | Obrigatório | 

![Video](https://github.com/DaniPoletto/challenge-alura-back-end-5-symfony/blob/main/update_video.jpg)

#### Deletar um video
| Método | Rota | Descrição | BODY PARAMS | QUERY PARAMS |
| --- | --- | --- | --- | --- |
|DELETE | /videos/{id} |Deletar um video por id | - | - |

![Video](https://github.com/DaniPoletto/challenge-alura-back-end-5-symfony/blob/main/delete_video.jpg)
