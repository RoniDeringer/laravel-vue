<!doctype html>
<html lang="pt-BR">
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1" />
        <title>{{ config('app.name') }}</title>
    </head>
    <body style="margin:0;padding:24px;background:#f6f7fb;font-family:ui-sans-serif,system-ui,-apple-system,Segoe UI,Roboto,Helvetica,Arial;">
        <div style="max-width:640px;margin:0 auto;background:#ffffff;border:1px solid #e5e7eb;border-radius:16px;overflow:hidden;">
            <div style="padding:18px 22px;background:linear-gradient(135deg,#EEF2FF,#F5F3FF);border-bottom:1px solid #e5e7eb;">
                <div style="font-weight:700;color:#111827;">mixed salad</div>
                <div style="margin-top:4px;color:#4b5563;font-size:13px;">Email de estudo (fila assíncrona)</div>
            </div>
            <div style="padding:22px;color:#111827;">
                <div style="white-space:pre-wrap;line-height:1.5;">{{ $messageText }}</div>
            </div>
            <div style="padding:14px 22px;border-top:1px solid #e5e7eb;color:#6b7280;font-size:12px;">
                Enviado por {{ config('app.name') }} • {{ now()->format('Y-m-d H:i') }}
            </div>
        </div>
    </body>
</html>

