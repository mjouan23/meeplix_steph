<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Confirmation de votre adresse e-mail</title>
</head>
<body style="margin: 0; padding: 0; font-family: Arial, sans-serif; background-color: #f9f9f9;">
    <table width="100%" cellpadding="0" cellspacing="0" style="background-color: #f9f9f9;">
        <tr>
            <td align="center">
                <table width="600" cellpadding="0" cellspacing="0" style="background-color: #ffffff; padding: 40px;">
                    <tr>
                        <td align="center" style="padding-bottom: 20px;">
                            <img src="{{ asset('images/logo.png') }}" alt="Logo {{ config('app.name') }}" style="height: 60px;">
                        </td>
                    </tr>

                    <tr>
                        <td>
                            <h2 style="color: #333;">Bonjour {{ $user->name ?? 'utilisateur' }} 👋</h2>
                            <p style="color: #555; font-size: 16px;">
                                Merci de vous être inscrit sur <strong>{{ config('app.name') }}</strong>.<br>
                                Veuillez confirmer votre adresse e-mail en cliquant sur le bouton ci-dessous :
                            </p>

                            <p style="text-align: center; margin: 30px 0;">
                                <a href="{{ $url }}" style="background-color: #3490dc; color: white; padding: 12px 24px; text-decoration: none; border-radius: 6px; display: inline-block; font-weight: bold;">
                                    Confirmer mon adresse e-mail
                                </a>
                            </p>

                            <p style="color: #777; font-size: 14px;">
                                Si vous n'avez pas créé de compte, ignorez simplement cet e-mail.
                            </p>

                            <p style="margin-top: 30px; color: #aaa; font-size: 12px;">
                                © {{ date('Y') }} {{ config('app.name') }} – Tous droits réservés.
                            </p>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
</body>
</html>
