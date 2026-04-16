# InteliBolsas: Plataforma de Divulgacao de Bolsas e Cursos 🎓

## Visao Geral do Projeto

**InteliBolsas** e uma plataforma **CRUD (Create, Read, Update, Delete)** desenvolvida para divulgar oportunidades de bolsas de estudo e cursos, sem hospedagem propria (funciona localmente em ambiente XAMPP).

O projeto foi desenvolvido por alunos do segundo semestre do curso de **Desenvolvimento de Software Multiplataforma (FATEC Zona Sul)**.

---

## Tecnologias Principais 💻

| Componente | Tecnologia | Observacao |
| :--- | :--- | :--- |
| **Backend** | **PHP** | Logica de servidor, utilizando a extensao **MySQLi** para a conexao com o banco de dados. |
| **Banco de Dados** | **MariaDB/MySQL** | Utilizado atraves do XAMPP para armazenamento de dados (usuarios, instituicoes, cursos, etc.). |
| **Ambiente Local** | **XAMPP** | Servidor Apache e MariaDB. |

---

## Estrutura de Pastas 📁

A arquitetura do projeto separa o codigo de apresentacao (Frontend) da logica de aplicacao (Backend) e dos recursos (Assets e Documentacao).

| Pasta Principal | Conteudo e Responsabilidade |
| :--- | :--- |
| **admin/** | Modulos e rotinas exclusivas da **Area Administrativa** (Ex: Gerenciamento de usuarios e instituicoes). |
| **aluno/** | Modulos e funcionalidades da **Area do Aluno** (Ex: Inscricao, atualizacao de dados). |
| **banco de dados/** | Scripts SQL e arquivos principais do banco de dados (Ex: `inteligolsas_v2`). |
| **documentacao/** | Documentos de apoio, UML, DER, DR,  Dicionario de Dados e a **documentacao Base**. |
| **instituicao/** | Modulos relacionados ao cadastro e gestao de cursos e oportunidades (**Area da Instituicao**). |
| **publico/** | Arquivos acessiveis pelo navegador (Telas, Assets, CSS/JS). Contem o ponto de entrada e o arquivo **`conexao.php`** (configuracao do BD). |
| **testes/** | Scripts e modelos para testes automatizados ou funcionais. |

### Estrutura de Frontend (CSS/JS) 🎨

O projeto utiliza uma estrategia de modularizacao de estilos e scripts:
* A pagina **`home.php`** possui seus proprios arquivos CSS e JS externos.
* **Qualquer nova pagina** ou modulo utiliza um conjunto **exclusivo** de arquivos CSS e JS externos para evitar conflito de estilos e facilitar a manutencao.

---

## Como Colocar o Projeto para Rodar 🚀

Siga estes passos rapidos para configurar o ambiente de desenvolvimento local (XAMPP):

1. **Pre-requisito:** Tenha o **XAMPP** instalado e com os servicos **Apache** e **MySQL** ativos.
2. **Localizacao:** Mova a pasta `InteliBolsas` para o diretorio `C:\xampp\htdocs\`.
3. **Banco de Dados:** Importe o arquivo SQL do banco de dados (`inteligolsas_v2`) atraves do phpMyAdmin (`http://localhost/phpmyadmin`). O arquivo esta localizado em **`banco de dados/`**.
4. **Configuracao:** Verifique e ajuste as credenciais de conexao (usuario, senha, nome do BD) no arquivo **`publico/conexao.php`**.
5. **Acesso:** Acesse o projeto no navegador atraves do endereco: `http://localhost/InteliBolsas/publico/`.
