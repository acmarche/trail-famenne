<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Marche 100km Famenne-Ardenne</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600&display=swap" rel="stylesheet"
          media="screen">
    <style>
        .hover-bg-slate-800:hover {
            background-color: #1e293b !important
        }

        @media (max-width: 600px) {
            .sm-p-6 {
                padding: 24px !important
            }

            .sm-px-4 {
                padding-left: 16px !important;
                padding-right: 16px !important
            }
        }

        @media (prefers-color-scheme: dark) {
            .dark-border-green-800 {
                border-color: #166534 !important
            }

            .dark-bg-gray-800 {
                background-color: #1f2937 !important
            }

            .dark-text-green-400 {
                color: #4ade80 !important
            }
        }
    </style>
</head>
<body
    style="background-color: #f8fafc; font-family: Inter, ui-sans-serif, system-ui, -apple-system, 'Segoe UI', sans-serif">
<div class="sm-px-4"
     style="background-color: #f8fafc; font-family: Inter, ui-sans-serif, system-ui, -apple-system, 'Segoe UI', sans-serif">
    <table align="center" style="margin: 0 auto" cellpadding="0" cellspacing="0" role="none">
        <tr>
            <td style="width: 752px; max-width: 100%">
                <div role="separator" style="line-height: 24px">&zwj;</div>
                <table style="width: 100%" cellpadding="0" cellspacing="0" role="none">
                    <tr>
                        <td class="sm-p-6"
                            style="border-radius: 8px; background-color: #fffffe; padding: 24px 36px; border: 1px solid #e2e8f0">
                            <a href="https://marche-famenne-ardenne.marche.be">
                                <img src="{{$message->embed($logo)}}" width="70" alt="logo"
                                     style="max-width: 100%; vertical-align: middle">
                            </a>
                        </td>
                        <td class="sm-p-6"
                            style="border-radius: 8px; background-color: #fffffe; padding: 24px 36px; border: 1px solid #e2e8f0">
                            {{ config('app.name') }}
                        </td>
                    </tr>
                </table>
                <div role="separator" style="line-height: 24px">&zwj;</div>
                <table style="width: 100%" cellpadding="0" cellspacing="0" role="none">
                    <tr>
                        <td class="sm-p-6"
                            style="border-radius: 8px; background-color: #fffffe; padding: 24px 36px; border: 1px solid #e2e8f0">
                            <p style="margin: 0 0 24px; font-size: 16px; color: #475569">
                                Thank you for your payment. Your registration has been successfully confirmed.<br/>
                                Merci pour votre paiement. Votre inscription est bien validée.<br/>
                                Bedankt voor je betaling. Je inschrijving is succesvol bevestigd.<br/>
                                Vielen Dank für Ihre Zahlung. Ihre Anmeldung wurde erfolgreich bestätigt.<br/><br/>
                                {{$walker->first_name}} {{$walker->last_name}}
                            </p>
                            <div role="separator" style="line-height: 24px">&zwj;</div>
                            <div class="dark-bg-gray-800 dark-text-green-400 dark-border-green-800" role="alert"
                                 style="margin-bottom: 16px; display: flex; align-items: center; border-radius: 8px; border-width: 1px; border-color: #86efac; background-color: #f0fdf4; padding: 16px; font-size: 14px; color: #166534">
                                <svg aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor"
                                     viewBox="0 0 20 20"
                                     style="margin-inline-end: 12px; display: inline; height: 16px; width: 16px; flex-shrink: 0">
                                    <path
                                        d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5ZM9.5 4a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM12 15H8a1 1 0 0 1 0-2h1v-3H8a1 1 0 0 1 0-2h2a1 1 0 0 1 1 1v4h1a1 1 0 0 1 0 2Z"></path>
                                </svg>
                                <span
                                    style="position: absolute; width: 1px; height: 1px; padding: 0; margin: -1px; overflow: hidden; clip: rect(0, 0, 0, 0); white-space: nowrap; border-width: 0">Information</span>
                                <div>
                                    <span
                                        style="font-weight: 500"> {{__('invoices::messages.email.invoice.paid.body')}} </span>
                                </div>
                            </div>
                            <div>
                                <a href="{{ $url }}"
                                   style="display: inline-block; text-decoration: none; padding: 16px 24px; font-size: 16px; line-height: 1; border-radius: 4px; color: #fffffe; background-color: #020617"
                                   class="hover-bg-slate-800">
                                    <!--[if mso]><i style="mso-font-width: 150%; mso-text-raise: 31px" hidden>&emsp;</i><![endif]-->
                                    <span style="mso-text-raise: 16px">{{$textbtn}}</span>
                                    <!--[if mso]><i hidden style="mso-font-width: 150%">&emsp;&#8203;</i><![endif]-->
                                </a>
                            </div>
                            <div role="separator" style="line-height: 24px">&zwj;</div>
                            <p style="margin: 0; font-size: 16px; line-height: 24px; color: #475569">
                                Thanks,
                                <br>
                                <span style="font-weight: 600">Marcheurs de la Famenne</span>
                            </p>
                            <div role="separator"
                                 style="height: 1px; line-height: 1px; background-color: #cbd5e1; margin-top: 24px; margin-bottom: 24px">
                                &zwj;
                            </div>
                            <p style="margin: 0; font-size: 12px; line-height: 20px; color: #475569">
                                <a href="https://marcheursdelafamenne.marche.be"
                                   style="color: #1e293b; text-decoration: underline">Site web des Marcheurs de la
                                    Famenne</a>
                            </p>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
</div>
</body>
</html>
