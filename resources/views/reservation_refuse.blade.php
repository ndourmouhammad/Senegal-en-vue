<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Refus de Réservation</title>
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
            color: #ff0000; /* Rouge pour indiquer une annulation */
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
        <h1>Votre Réservation a été Refusée</h1>
        <p>Bonjour {{ $reservation->user->name }},</p>
        <p>Nous regrettons de vous informer que votre réservation pour l'événement <strong>"{{ $reservation->evenement->nom }}"</strong> a été refusée.</p>
        
        <p>Nous nous excusons pour les éventuels désagréments et vous encourageons à essayer de nouveau ou à contacter notre service clientèle pour plus d'informations.</p>
        <p>Merci de votre compréhension.</p>
        
        <div class="footer">
            <p>Senegal en vue &copy; 2024</p>
        </div>
    </div>
</body>
</html>