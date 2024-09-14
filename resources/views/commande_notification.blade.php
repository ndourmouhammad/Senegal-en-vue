<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Réservation en Cours de Traitement</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 20px;
        }
        .email-container {
            background-color: #ffffff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
            max-width: 600px;
            margin: 0 auto;
        }
        h1 {
            color: #333333;
        }
        p {
            color: #555555;
            line-height: 1.6;
        }
        .footer {
            margin-top: 20px;
            font-size: 12px;
            color: #999999;
            text-align: center;
        }
    </style>
</head>
<body>
    <div class="email-container">
        <h1>Commande en cours de traitement</h1>
        <p>Bonjour {{ $commande->user->name }},</p>
        <p>Nous vous informons que votre commande pour <strong>"{{ $commande->site_touristique->libelle }}"</strong> a bien été prise en compte.</p>
        <p>Votre commande est actuellement en cours de traitement. Vous recevrez une notification dès que son statut évoluera.</p>
        <p>Merci de votre patience et de votre confiance.</p>
        
        <div class="footer">
            <p>Senegal en vue &copy; 2024</p>
        </div>
    </div>
</body>
</html>