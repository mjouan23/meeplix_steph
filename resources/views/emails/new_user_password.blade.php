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

                            <p>Votre compte Meeplix a été créé par l'administrateur.</p>

                            <p>Voici votre mot de passe temporaire :</p>
                            <p><strong>{{ $password }}</strong></p>

                            <p>Merci de le changer lors de votre première connexion.</p>

                            <p>Cordialement,<br>L'équipe Meeplix</p>

                            <p style="margin-top: 30px; color: #aaa; font-size: 12px;">
                                © {{ date('Y') }} {{ config('app.name') }} - Tous droits réservés.
                            </p>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
</body>
</html>
