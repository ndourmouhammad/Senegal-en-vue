<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Confirmation de Réservation</title>
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
            color: green;
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
        <h1>Votre commande est confirmée</h1>
        <p>Bonjour {{ $commande->user->name }},</p>
        <p>Nous avons le plaisir de vous informer que votre commande pour <strong>"{{ $commande->excursion->libelle }}"</strong> a été confirmée.</p>
        <p>Nous sommes impatients de vous accueillir lors de cet événement. Veuillez trouver ci-dessous les détails de votre commande :</p>
        <ul>
            <li><strong>Événement :</strong> {{ $commande->excursion->libelle }}</li>
            <li><strong>Date début:</strong> {{ $commande->excursion->date_debut }}</li>
            <li><strong>Date de fin :</strong> {{ $commande->excursion->date_fin }}</li>
            <li><strong>Prix :</strong> {{ $commande->excursion->tarif_entree }} FCFA</li>
            <li><strong>Statut de la commande :</strong> Confirmé</li>
        </ul>
        <p>Si vous avez des questions ou des besoins particuliers, n'hésitez pas à nous contacter.</p>
        <p>Merci de votre confiance.</p>
        
        <div class="footer">
            <p>Senegal en vue &copy; 2024</p>
        </div>
    </div>
</body>
</html>