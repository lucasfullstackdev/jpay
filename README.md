<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400"></a></p>

# JPay - Sistema de Gestão de Domicílio Fiscal

<p align="center">
<a href="https://github.com/laravel/framework/actions"><img src="https://github.com/laravel/framework/workflows/tests/badge.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

## 📋 Visão Geral

O JPay é um sistema robusto de gestão de assinaturas e pagamentos, desenvolvido com Laravel 10.x. O sistema oferece uma API RESTful completa para gerenciamento de assinaturas, documentos, pagamentos e afiliados.

## 🎯 Por que este projeto?

Este projeto simula um cenário real onde uma empresa precisa gerenciar um grande volume de assinaturas digitais e pagamentos recorrentes. O desafio principal é integrar diferentes serviços externos (ClickSign para assinaturas e Asaas para pagamentos) de forma eficiente e confiável, garantindo o processamento adequado de documentos e cobranças.

O cenário apresenta diversos desafios técnicos como:
- Sincronização entre assinaturas e pagamentos
- Gestão de múltiplos signatários
- Rastreabilidade de documentos
- Monitoramento de status de pagamentos
- Escalabilidade do sistema

O JPay foi desenvolvido como uma solução para este cenário, demonstrando como construir uma aplicação robusta e integrada que automatiza todo o processo de gestão de assinaturas e pagamentos.

## 🛠 Stack

### Backend

| Tecnologia | Versão | Descrição |
|------------|--------|-----------|
| [Laravel](https://laravel.com/docs/10.x) | 10.x | Framework PHP para desenvolvimento web |
| [PHP](https://www.php.net/releases/8.1/pt_BR.php) | 8.1+ | Linguagem de programação |
| [MySQL](https://dev.mysql.com/doc/relnotes/mysql/8.0/en/) | 8.0 | Banco de dados relacional |
| [Redis](https://redis.io/documentation) | Latest | Cache e sistema de filas |
| [Laravel Sanctum](https://laravel.com/docs/10.x/sanctum) | Latest | Autenticação API |
| [Laravel Sail](https://laravel.com/docs/10.x/sail) | Latest | Ambiente Docker para desenvolvimento |

### Infraestrutura

| Tecnologia | Descrição |
|------------|-----------|
| Docker | Containerização da aplicação |
| Laravel Sail | Ambiente de desenvolvimento Docker |
| Redis | Cache, sessões e filas |
| Laravel Horizon | Monitoramento de filas |
| Discord | Logs e monitoramento |
| GitHub Actions | CI/CD e automação |

## 🔌 Integrações

<details>
<summary><strong>ClickSign (Assinatura Digital)</strong></summary>

**Documentação**: [https://developers.clicksign.com/](https://developers.clicksign.com/)

**Propósito**: Gestão completa do processo de assinatura digital de documentos.

**Funcionalidades**:
- Assinatura digital de documentos com validade jurídica
- Suporte a múltiplos signatários com diferentes níveis de autenticação
- Webhooks para monitoramento de eventos de assinatura
- Notificações automáticas para signatários
- API para assinatura automática por signatários oficiais
- Suporte a diferentes tipos de documentos e fluxos de assinatura

**Desafios Técnicos**:
- Gestão de estados de assinatura
- Tratamento de timeouts e falhas
- Validação de documentos
- Segurança na autenticação

**Modelos Relacionados**:
- `Document`: Gerencia os documentos a serem assinados
- `Signer`: Controla os signatários
- `DocumentSigner`: Gerencia o processo de assinatura
- `ClickSignEvent`: Registra eventos da plataforma

**Endpoints Principais**:
- Webhook para eventos de assinatura
- API para criação de documentos
- API para gestão de signatários
- API para assinatura automática
</details>

<details>
<summary><strong>Asaas (Pagamentos)</strong></summary>

**Documentação**: [https://www.asaas.com/desenvolvedores](https://www.asaas.com/desenvolvedores)

**Propósito**: Processamento de pagamentos e gestão financeira.

**Funcionalidades**:
- Processamento de pagamentos via múltiplos métodos
- Gestão de cobranças recorrentes
- Geração de boletos e faturas
- Webhooks para eventos financeiros
- Gestão de assinaturas e planos
- Reconciliação automática

**Desafios Técnicos**:
- Conciliação de pagamentos
- Tratamento de chargebacks
- Gestão de assinaturas recorrentes
- Segurança nas transações

**Modelos Relacionados**:
- `Subscription`: Gerencia as assinaturas
- `BillingMonitoring`: Controla eventos de cobrança
- `AsaasEvent`: Registra eventos do gateway
- `BillingSending`: Gerencia o envio de cobranças

**Endpoints Principais**:
- Webhook para eventos de pagamento
- API para criação de cobranças
- API para gestão de assinaturas
- API para consulta de status
</details>

<details>
<summary><strong>Discord (Monitoramento)</strong></summary>

**Documentação**: [https://discord.com/developers/docs/intro](https://discord.com/developers/docs/intro)

**Propósito**: Logs e monitoramento em tempo real.

**Funcionalidades**:
- Logs de erros e exceções
- Alertas do sistema
- Monitoramento de jobs e filas
- Métricas de performance
- Notificações de eventos críticos

**Desafios Técnicos**:
- Rate limiting
- Formatação de mensagens
- Priorização de alertas
- Retry em caso de falhas

**Modelos Relacionados**:
- `DocumentMonitoring`: Registra eventos de documentos
- `BillingMonitoring`: Registra eventos de cobrança
- `AsaasEvent`: Registra eventos de pagamento
- `ClickSignEvent`: Registra eventos de assinatura

**Canais de Notificação**:
- Canal de erros
- Canal de alertas
- Canal de métricas
- Canal de eventos críticos
</details>

<details>
<summary><strong>Laravel Horizon (Filas)</strong></summary>

**Documentação**: [https://laravel.com/docs/10.x/horizon](https://laravel.com/docs/10.x/horizon)

**Propósito**: Gerenciamento e monitoramento de filas.

**Funcionalidades**:
- Dashboard para monitoramento de jobs
- Métricas de processamento
- Retry automático de jobs falhos
- Balanceamento de carga
- Monitoramento de workers

**Desafios Técnicos**:
- Escalabilidade
- Gestão de recursos
- Monitoramento de performance
- Tratamento de falhas

**Jobs Principais**:
- Processamento de assinaturas
- Envio de cobranças
- Notificações
- Webhooks
- Reconciliação de pagamentos

**Métricas Monitoradas**:
- Tempo de processamento
- Taxa de falhas
- Uso de recursos
- Tamanho das filas
- Workers ativos
</details>

<details>
<summary><strong>Redis (Cache e Filas)</strong></summary>

**Documentação**: [https://redis.io/docs/latest/](https://redis.io/docs/latest/)

**Propósito**: Cache, sessões e sistema de filas.

**Funcionalidades**:
- Cache de dados
- Gerenciamento de sessões
- Sistema de filas
- Pub/Sub para eventos
- Rate limiting

**Desafios Técnicos**:
- Invalidação de cache
- Persistência de dados
- Escalabilidade
- Monitoramento de memória

**Uso no Sistema**:
- Cache de consultas frequentes
- Sessões de usuários
- Filas de processamento
- Eventos em tempo real
- Rate limiting de APIs

**Configurações Principais**:
- TTL de cache
- Tamanho máximo de memória
- Políticas de evição
- Configurações de cluster
- Monitoramento de performance
</details>

## 🏗 Arquitetura e Banco de Dados

### Modelos e Tabelas

<details>
<summary><strong>Customer (Cliente)</strong></summary>

**Descrição**: Gerencia clientes (PF/PJ), incluindo dados pessoais, endereço, documentos e relacionamentos com assinaturas e empresas.

**Tabela**: `customers`

| Coluna | Tipo | Descrição | Relacionamentos |
|--------|------|-----------|-----------------|
| id | bigint | ID único do cliente | Chave primária |
| name | string | Nome completo do cliente | - |
| email | string | Email do cliente | - |
| phone | string | Telefone do cliente | - |
| person | string | Tipo de pessoa (PF/PJ) | - |
| document | string | CPF/CNPJ do cliente | - |
| sku | string | Identificador único do cliente | Relacionamento com Subscription |
| street | string | Rua do endereço | - |
| number | string | Número do endereço | - |
| neighborhood | string | Bairro | - |
| city | string | Cidade | - |
| state | string | Estado | - |
| country | string | País | - |
| postal_code | string | CEP | - |
| complement | string | Complemento do endereço | - |
| created_at | timestamp | Data de criação | - |
| updated_at | timestamp | Data de atualização | - |

**Relacionamentos**:
- `subscription()`: HasOne com Subscription (via sku)
- `company()`: HasOne com Company (via owner_id)

**Acessores**:
- `documentFormatted`: Formata o documento (CPF/CNPJ)
- `address`: Retorna o endereço completo formatado
</details>

<details>
<summary><strong>Company (Empresa)</strong></summary>

**Descrição**: Representa empresas vinculadas a clientes, contendo dados fiscais, endereço e gestão de documentos empresariais.

**Tabela**: `companies`

| Coluna | Tipo | Descrição | Relacionamentos |
|--------|------|-----------|-----------------|
| id | bigint | ID único da empresa | Chave primária |
| owner_id | bigint | ID do cliente proprietário | Chave estrangeira para customers |
| name | string | Nome da empresa | - |
| document | string | CNPJ da empresa | - |
| street | string | Rua do endereço | - |
| number | string | Número do endereço | - |
| neighborhood | string | Bairro | - |
| city | string | Cidade | - |
| state | string | Estado | - |
| country | string | País | - |
| postal_code | string | CEP | - |
| complement | string | Complemento do endereço | - |
| created_at | timestamp | Data de criação | - |
| updated_at | timestamp | Data de atualização | - |

**Relacionamentos**:
- `owner()`: BelongsTo com Customer (via owner_id)
</details>

<details>
<summary><strong>Document (Documento)</strong></summary>

**Descrição**: Controla documentos fiscais, integração com sistema de assinaturas e monitoramento de eventos.

**Tabela**: `documents`

| Coluna | Tipo | Descrição | Relacionamentos |
|--------|------|-----------|-----------------|
| id | bigint | ID único do documento | Chave primária |
| customer | string | SKU do cliente | Relacionamento com Customer |
| key | string | Chave única do documento | - |
| status | string | Status do documento | - |
| created_at | timestamp | Data de criação | - |
| updated_at | timestamp | Data de atualização | - |

**Relacionamentos**:
- `customer()`: BelongsTo com Customer (via customer/sku)
- `signers()`: HasMany com DocumentSigner
</details>

<details>
<summary><strong>Subscription (Assinatura)</strong></summary>

**Descrição**: Gerencia assinaturas, incluindo vouchers, descontos e integração com sistema de cobrança.

**Tabela**: `subscriptions`

| Coluna | Tipo | Descrição | Relacionamentos |
|--------|------|-----------|-----------------|
| id | bigint | ID único da assinatura | Chave primária |
| customer | string | SKU do cliente | Relacionamento com Customer |
| value | decimal | Valor da assinatura | - |
| discount | decimal | Valor do desconto | - |
| status | string | Status da assinatura | - |
| cycle | string | Ciclo de cobrança | - |
| created_at | timestamp | Data de criação | - |
| updated_at | timestamp | Data de atualização | - |

**Relacionamentos**:
- `customer()`: BelongsTo com Customer (via customer/sku)
</details>

<details>
<summary><strong>Affiliate (Afiliado)</strong></summary>

**Descrição**: Sistema de afiliados com gestão de vouchers e rastreamento de conversões.

**Tabela**: `affiliates`

| Coluna | Tipo | Descrição | Relacionamentos |
|--------|------|-----------|-----------------|
| id | bigint | ID único do afiliado | Chave primária |
| name | string | Nome do afiliado | - |
| email | string | Email do afiliado | - |
| document | string | CPF/CNPJ do afiliado | - |
| status | string | Status do afiliado | - |
| created_at | timestamp | Data de criação | - |
| updated_at | timestamp | Data de atualização | - |

**Relacionamentos**:
- `vouchers()`: HasMany com AffiliateVoucher
</details>

<details>
<summary><strong>Voucher (Cupom)</strong></summary>

**Descrição**: Sistema de cupons de desconto com diferentes tipos e regras de aplicação.

**Tabela**: `vouchers`

| Coluna | Tipo | Descrição | Relacionamentos |
|--------|------|-----------|-----------------|
| id | bigint | ID único do voucher | Chave primária |
| type | string | Tipo do voucher | Relacionamento com VoucherType |
| code | string | Código do voucher | - |
| value | decimal | Valor do desconto | - |
| status | string | Status do voucher | - |
| created_at | timestamp | Data de criação | - |
| updated_at | timestamp | Data de atualização | - |

**Relacionamentos**:
- `type()`: BelongsTo com VoucherType
- `affiliates()`: HasMany com AffiliateVoucher
</details>

<details>
<summary><strong>VoucherType (Tipo de Cupom)</strong></summary>

**Descrição**: Define os tipos de vouchers disponíveis no sistema.

**Tabela**: `voucher_types`

| Coluna | Tipo | Descrição | Relacionamentos |
|--------|------|-----------|-----------------|
| id | bigint | ID único do tipo | Chave primária |
| name | string | Nome do tipo | - |
| description | string | Descrição do tipo | - |
| created_at | timestamp | Data de criação | - |
| updated_at | timestamp | Data de atualização | - |

**Relacionamentos**:
- `vouchers()`: HasMany com Voucher
</details>

<details>
<summary><strong>OfficeSigner (Signatário Oficial)</strong></summary>

**Descrição**: Gerencia signatários oficiais do sistema, incluindo testemunhas e autenticação.

**Tabela**: `office_signers`

| Coluna | Tipo | Descrição | Relacionamentos |
|--------|------|-----------|-----------------|
| id | bigint | ID único do signatário | Chave primária |
| name | string | Nome do signatário | - |
| email | string | Email do signatário | - |
| document | string | CPF do signatário | - |
| status | string | Status do signatário | - |
| created_at | timestamp | Data de criação | - |
| updated_at | timestamp | Data de atualização | - |

**Relacionamentos**:
- `signatures()`: HasMany com DocumentSigner
</details>

<details>
<summary><strong>Signer (Signatário)</strong></summary>

**Descrição**: Controla os signatários dos documentos, incluindo autenticação e status.

**Tabela**: `signers`

| Coluna | Tipo | Descrição | Relacionamentos |
|--------|------|-----------|-----------------|
| id | bigint | ID único do signatário | Chave primária |
| name | string | Nome do signatário | - |
| email | string | Email do signatário | - |
| document | string | CPF do signatário | - |
| created_at | timestamp | Data de criação | - |
| updated_at | timestamp | Data de atualização | - |

**Relacionamentos**:
- `signatures()`: HasMany com DocumentSigner
</details>

<details>
<summary><strong>DocumentSigner (Assinatura de Documento)</strong></summary>

**Descrição**: Gerencia a relação entre documentos e signatários, incluindo ordem e tipo de assinatura.

**Tabela**: `document_signers`

| Coluna | Tipo | Descrição | Relacionamentos |
|--------|------|-----------|-----------------|
| id | bigint | ID único da assinatura | Chave primária |
| document_id | bigint | ID do documento | Relacionamento com Document |
| signer_id | bigint | ID do signatário | Relacionamento com Signer |
| order | integer | Ordem da assinatura | - |
| type | string | Tipo de assinatura | - |
| status | string | Status da assinatura | - |
| created_at | timestamp | Data de criação | - |
| updated_at | timestamp | Data de atualização | - |

**Relacionamentos**:
- `document()`: BelongsTo com Document
- `signer()`: BelongsTo com Signer
</details>

<details>
<summary><strong>DocumentMonitoring (Monitoramento de Documento)</strong></summary>

**Descrição**: Registra eventos de documentos, status, alterações e histórico de ações.

**Tabela**: `document_monitoring`

| Coluna | Tipo | Descrição | Relacionamentos |
|--------|------|-----------|-----------------|
| id | bigint | ID único do registro | Chave primária |
| document_id | bigint | ID do documento | Relacionamento com Document |
| event | string | Tipo do evento | - |
| status | string | Status do documento | - |
| created_at | timestamp | Data de criação | - |

**Relacionamentos**:
- `document()`: BelongsTo com Document
</details>

<details>
<summary><strong>BillingMonitoring (Monitoramento de Cobrança)</strong></summary>

**Descrição**: Controla eventos de cobrança, status de pagamentos e histórico financeiro.

**Tabela**: `billing_monitoring`

| Coluna | Tipo | Descrição | Relacionamentos |
|--------|------|-----------|-----------------|
| id | bigint | ID único do registro | Chave primária |
| subscription_id | bigint | ID da assinatura | Relacionamento com Subscription |
| event | string | Tipo do evento | - |
| status | string | Status do pagamento | - |
| value | decimal | Valor da transação | - |
| created_at | timestamp | Data de criação | - |

**Relacionamentos**:
- `subscription()`: BelongsTo com Subscription
</details>

<details>
<summary><strong>AsaasEvent (Evento Asaas)</strong></summary>

**Descrição**: Armazena eventos do gateway de pagamento Asaas, status de transações e webhooks.

**Tabela**: `asaas_events`

| Coluna | Tipo | Descrição | Relacionamentos |
|--------|------|-----------|-----------------|
| id | bigint | ID único do evento | Chave primária |
| event | string | Tipo do evento | - |
| payload | json | Dados do evento | - |
| created_at | timestamp | Data de criação | - |

**Relacionamentos**: Nenhum
</details>

<details>
<summary><strong>ClickSignEvent (Evento ClickSign)</strong></summary>

**Descrição**: Registra eventos da plataforma de assinatura ClickSign, status de documentos e webhooks.

**Tabela**: `clicksign_events`

| Coluna | Tipo | Descrição | Relacionamentos |
|--------|------|-----------|-----------------|
| id | bigint | ID único do evento | Chave primária |
| event | string | Tipo do evento | - |
| payload | json | Dados do evento | - |
| created_at | timestamp | Data de criação | - |

**Relacionamentos**: Nenhum
</details>

<details>
<summary><strong>BillingSending (Envio de Cobrança)</strong></summary>

**Descrição**: Controla o envio de cobranças e faturas.

**Tabela**: `billing_sending`

| Coluna | Tipo | Descrição | Relacionamentos |
|--------|------|-----------|-----------------|
| id | bigint | ID único do envio | Chave primária |
| subscription_id | bigint | ID da assinatura | Relacionamento com Subscription |
| status | string | Status do envio | - |
| method | string | Método de envio | - |
| attempts | integer | Número de tentativas | - |
| created_at | timestamp | Data de criação | - |
| updated_at | timestamp | Data de atualização | - |

**Relacionamentos**:
- `subscription()`: BelongsTo com Subscription
</details>

<details>
<summary><strong>User (Usuário)</strong></summary>

**Descrição**: Gerencia usuários do sistema com autenticação e permissões.

**Tabela**: `users`

| Coluna | Tipo | Descrição | Relacionamentos |
|--------|------|-----------|-----------------|
| id | bigint | ID único do usuário | Chave primária |
| name | string | Nome do usuário | - |
| email | string | Email do usuário | - |
| password | string | Senha criptografada | - |
| remember_token | string | Token de "lembrar-me" | - |
| created_at | timestamp | Data de criação | - |
| updated_at | timestamp | Data de atualização | - |

**Relacionamentos**: Nenhum
</details>

## 🔌 API Endpoints

### Collections do Postman

A collection do Postman para testar a API está disponível no diretório `documentation`:

- [collections.json](https://github.com/lucasfullstackdev/jpay/blob/main/documentation/collections.json) - Collection com todos os endpoints e exemplos

Para importar a collection:
1. Abra o Postman
2. Clique em "Import"
3. Arraste o arquivo .json ou use a opção "File" para selecioná-lo
4. Configure as variáveis de ambiente:
   - `api`: URL base da API (ex: http://localhost:8000/api)
   - `landing_page_secret`: Chave secreta para acesso à landing page
   - `authToken`: Token de autenticação (gerado automaticamente após login)

### Fluxogramas

Para melhor compreensão do sistema, disponibilizamos os seguintes fluxogramas:

#### Fluxo da Jornada do Usuário
![Fluxograma da Jornada do Usuário](https://github.com/lucasfullstackdev/jpay/blob/main/documentation/fluxograma%20da%20jornada%20do%20usu%C3%A1rio.png)

#### Fluxo dos Dados do ASAAS
![Fluxograma dos Dados Enviados pelo ASAAS](https://github.com/lucasfullstackdev/jpay/blob/main/documentation/fluxograma%20dos%20dados%20enviados%20pelo%20ASAAS.png)

#### Fluxo dos Dados da ClickSign
![Fluxograma dos Dados Enviados pela ClickSign](https://github.com/lucasfullstackdev/jpay/blob/main/documentation/fluxograma%20dos%20dados%20enviados%20pela%20ClickSign.png)

### Endpoints Disponíveis

#### Autenticação
```http
POST /api/auth/login
POST /api/auth/register
GET  /api/auth/me
POST /api/auth/logout
POST /api/auth/logout/all
```

#### Domicílio Fiscal
```http
POST /api/v1/tax-domicile/purchase
```

#### Webhooks
```http
POST /api/v1/tax-domicile/purchase/webhook    # Webhook do Asaas (pagamentos)
POST /api/v1/tax-domicile/document/webhook    # Webhook do ClickSign (documentos)
```

#### Clientes
```http
GET    /api/v1/customers                      # Lista todos os clientes
POST   /api/v1/customers                      # Cria um novo cliente
GET    /api/v1/customers/{sku}               # Obtém dados de um cliente
PUT    /api/v1/customers/{sku}               # Atualiza dados de um cliente
DELETE /api/v1/customers/{sku}               # Remove um cliente
```

#### Empresas
```http
GET    /api/v1/companies                     # Lista todas as empresas
POST   /api/v1/companies                     # Cria uma nova empresa
GET    /api/v1/companies/{id}               # Obtém dados de uma empresa
PUT    /api/v1/companies/{id}               # Atualiza dados de uma empresa
DELETE /api/v1/companies/{id}               # Remove uma empresa
```

#### Documentos
```http
GET    /api/v1/documents                     # Lista todos os documentos
POST   /api/v1/documents                     # Cria um novo documento
GET    /api/v1/documents/{key}              # Obtém dados de um documento
PUT    /api/v1/documents/{key}              # Atualiza dados de um documento
DELETE /api/v1/documents/{key}              # Remove um documento
```

#### Assinaturas
```http
GET    /api/v1/subscriptions                 # Lista todas as assinaturas
POST   /api/v1/subscriptions                 # Cria uma nova assinatura
GET    /api/v1/subscriptions/{id}           # Obtém dados de uma assinatura
PUT    /api/v1/subscriptions/{id}           # Atualiza dados de uma assinatura
DELETE /api/v1/subscriptions/{id}           # Remove uma assinatura
```

#### Afiliados
```http
GET    /api/v1/affiliates                    # Lista todos os afiliados
POST   /api/v1/affiliates                    # Cria um novo afiliado
GET    /api/v1/affiliates/{id}              # Obtém dados de um afiliado
PUT    /api/v1/affiliates/{id}              # Atualiza dados de um afiliado
DELETE /api/v1/affiliates/{id}              # Remove um afiliado
```

#### Vouchers
```http
GET    /api/v1/vouchers                      # Lista todos os vouchers
POST   /api/v1/vouchers                      # Cria um novo voucher
GET    /api/v1/vouchers/{code}              # Obtém dados de um voucher
PUT    /api/v1/vouchers/{code}              # Atualiza dados de um voucher
DELETE /api/v1/vouchers/{code}              # Remove um voucher
```

#### Signatários
```http
GET    /api/v1/signers                       # Lista todos os signatários
POST   /api/v1/signers                       # Cria um novo signatário
GET    /api/v1/signers/{id}                 # Obtém dados de um signatário
PUT    /api/v1/signers/{id}                 # Atualiza dados de um signatário
DELETE /api/v1/signers/{id}                 # Remove um signatário
```

#### Monitoramento
```http
GET    /api/v1/monitoring/documents          # Lista eventos de documentos
GET    /api/v1/monitoring/billing            # Lista eventos de cobrança
GET    /api/v1/monitoring/asaas              # Lista eventos do Asaas
GET    /api/v1/monitoring/clicksign          # Lista eventos do ClickSign
```

## 🚀 Configuração do Ambiente

### Requisitos

- Docker e Docker Compose
- PHP 8.1+
- Composer
- Node.js (para assets)

### Instalação

```bash
# Clonar o repositório
git clone https://github.com/lucas-oliveira/jpay.git

# Instalar dependências
composer install
npm install

# Configurar ambiente
cp .env.example .env
php artisan key:generate

# Iniciar containers
./vendor/bin/sail up -d

# Executar migrações
./vendor/bin/sail artisan migrate

# Executar seeders (se necessário)
./vendor/bin/sail artisan db:seed
```

### Variáveis de Ambiente

- Configurações do banco de dados
- Chaves de API (Asaas, ClickSign)
- Configurações de email
- Configurações de cache

## 🛡 Segurança

- Autenticação via Laravel Sanctum
- Proteção contra CSRF
- Validação de dados
- Sanitização de inputs
- Logs de auditoria
- Soft deletes em modelos críticos

## 📊 Monitoramento

- Logs de eventos de documentos
- Logs de eventos de pagamento
- Monitoramento de webhooks
- Rastreamento de assinaturas
- Métricas de afiliados

## 📝 Considerações Finais

Esta API não representa uma amostra real, devendo ser utilizada apenas para se ter uma noção sobre como funciona uma API REST.

Qualquer dúvida ou sugestão, entre em contato pelo e-mail: contato@jellycode.com.br
