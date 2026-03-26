param(
    [string] $HostName = '127.0.0.1',
    [int] $AmqpPort = 5672,
    [int] $ManagementPort = 15672
)

$ErrorActionPreference = 'Stop'

function Test-Port {
    param(
        [string] $HostName,
        [int] $Port
    )

    try {
        $result = Test-NetConnection -ComputerName $HostName -Port $Port -WarningAction SilentlyContinue
        return [bool] $result.TcpTestSucceeded
    } catch {
        return $false
    }
}

$amqpOk = Test-Port -HostName $HostName -Port $AmqpPort
$mgmtOk = Test-Port -HostName $HostName -Port $ManagementPort

Write-Host ("AMQP  ({0}:{1}) : {2}" -f $HostName, $AmqpPort, ($(if ($amqpOk) { 'OK' } else { 'OFF' })))
Write-Host ("MGMT  ({0}:{1}) : {2}" -f $HostName, $ManagementPort, ($(if ($mgmtOk) { 'OK' } else { 'OFF' })))

if (-not $mgmtOk) {
    Write-Host ""
    Write-Host 'RabbitMQ Management UI não está acessível.'
    Write-Host '- Se estiver usando Docker: docker compose -f docker-compose.rabbitmq.yml up -d'
    Write-Host '- Se estiver instalando nativo no Windows: habilite o plugin rabbitmq_management e inicie o serviço.'
    exit 1
}

Write-Host ""
Write-Host ("Abra: http://{0}:{1}" -f $HostName, $ManagementPort)
