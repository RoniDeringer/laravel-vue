# RabbitMQ (fila) + Management UI

Se `http://localhost:15672` da "This site can't be reached", isso significa que o **RabbitMQ (Management UI)** nao esta rodando localmente.

## 1) Como ver a fila (interface)

- URL: `http://localhost:15672`
- Usuario/senha padrao (quando voce sobe com defaults): `guest` / `guest`

Na UI voce consegue ver:
- `Queues` -> fila `emails` (mensagens "Ready" e "Unacked")
- `Connections` / `Channels`
- `Exchanges` / `Bindings`

## 2) Subir RabbitMQ com Docker (mais simples)

Pre-requisito: **Docker Desktop** instalado.

No projeto, rode:

```powershell
docker compose -f docker-compose.rabbitmq.yml up -d
```

Depois abra:
- `http://localhost:15672`

E valide portas:

```powershell
powershell -ExecutionPolicy Bypass -File scripts/rabbitmq-check.ps1
```

## 3) Importante para o Laravel

- O Docker aqui sobe o **RabbitMQ broker**. O **worker do Laravel** roda no seu terminal com `php artisan queue:work`.
- O projeto usa `QUEUE_CONNECTION=rabbitmq` e a fila padrao `RABBITMQ_QUEUE=emails`.

Para consumir a fila `emails`:

```powershell
php artisan queue:work rabbitmq --queue=emails -vvv
```

## 4) Documentacao do menu de email

Veja: `docs/emails.md`