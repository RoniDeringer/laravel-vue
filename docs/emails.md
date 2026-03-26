# Menu de Email (Fila + Jobs)

Este projeto tem um menu de **Envio de email** (`/email`) feito para estudar **filas** (RabbitMQ) e a execucao assincrona de jobs no Laravel.

## Tecnologias usadas

- Backend: **Laravel 12** (Jobs/Queues/Mail)
- Frontend: **Vue 3** + **Vue Router** + **Tailwind CSS** + **Vite**
- Fila (broker): **RabbitMQ** (subido via **Docker Compose** com Management UI)
- Driver RabbitMQ no Laravel: `vladimir-yuldashev/laravel-queue-rabbitmq`
- Tracking de execucoes: tabela `job_executions` (banco) + tela `/jobs`

## Rotas / telas

- `GET /email`: formulario para enfileirar envio de email
- `POST /api/email`: endpoint que valida e enfileira o job
- `GET /jobs`: datalist com execucoes (status + log)
- `GET /api/jobs/executions`: lista execucoes
- `GET /api/jobs/executions/{id}`: detalhes + log da execucao
- RabbitMQ UI: `http://127.0.0.1:15672/#/`

## Fluxo (resumo)

1) Usuario preenche e envia o formulario em `/email`.
2) O front chama `POST /api/email` e mostra um modal com status (sucesso/erro).
3) O backend enfileira `SendStudyEmailJob` na fila `emails` (RabbitMQ).
4) O **worker do Laravel** (rodando no seu terminal) consome a fila e executa o job.
5) O job monta o `Envelope` do `Mailable`, tenta enviar o email e registra logs.
6) Cada execucao fica registrada em `job_executions` e pode ser visualizada em `/jobs`.

## RabbitMQ via Docker

O Docker aqui e usado para subir o **RabbitMQ broker + Management UI** (nao para rodar o worker do Laravel).

- Subir RabbitMQ: `docker compose -f docker-compose.rabbitmq.yml up -d`
- Abrir UI: `http://127.0.0.1:15672/#/` (padrao: `guest` / `guest`)

## Worker (consumidor da fila)

O worker e um processo separado do servidor HTTP.

- Rodar worker na fila `emails`:

```powershell
php artisan queue:work rabbitmq --queue=emails -vvv
```

## Onde ver "se executou"

- RabbitMQ UI (fila):
  - `Ready` > 0: ainda esta na fila
  - `Unacked` > 0: ja foi entregue ao worker e aguarda ACK
- Tela `/jobs`:
  - `processing` -> `processed` (sucesso) ou `failed` (erro)
  - Botao **Ver log** mostra o log completo (Envelope, envio, erro/stacktrace)