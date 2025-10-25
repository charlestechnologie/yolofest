<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Compte à rebours dynamique</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        
        body {
            background: linear-gradient(135deg, #1a2a6c, #b21f1f, #fdbb2d);
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            padding: 20px;
            color: white;
        }
        
        .container {
            background-color: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(10px);
            border-radius: 20px;
            padding: 40px;
            text-align: center;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.3);
            max-width: 800px;
            width: 100%;
        }
        
        h1 {
            font-size: 2.5rem;
            margin-bottom: 20px;
            text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.5);
        }
        
        .target-date {
            font-size: 1.2rem;
            margin-bottom: 30px;
            opacity: 0.9;
        }
        
        .countdown {
            display: flex;
            justify-content: center;
            gap: 20px;
            margin: 30px 0;
            flex-wrap: wrap;
        }
        
        .time-unit {
            background-color: rgba(255, 255, 255, 0.15);
            border-radius: 10px;
            padding: 20px;
            min-width: 120px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.2);
        }
        
        .time-value {
            font-size: 3rem;
            font-weight: bold;
            margin-bottom: 5px;
            text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.3);
        }
        
        .time-label {
            font-size: 1rem;
            text-transform: uppercase;
            letter-spacing: 2px;
        }
        
        .progress-bar {
            margin-top: 30px;
            width: 100%;
            background-color: rgba(255, 255, 255, 0.2);
            border-radius: 10px;
            overflow: hidden;
            height: 20px;
        }
        
        .progress {
            height: 100%;
            background: linear-gradient(to right, #4facfe, #00f2fe);
            width: 0%;
            transition: width 1s ease;
            border-radius: 10px;
        }
        
        .message {
            margin-top: 30px;
            font-size: 1.5rem;
            font-weight: bold;
            min-height: 40px;
        }
        
        .completed {
            color: #4CAF50;
            text-shadow: 0 0 10px rgba(76, 175, 80, 0.5);
        }
        
        .info {
            margin-top: 20px;
            font-size: 0.9rem;
            opacity: 0.7;
        }
        
        @media (max-width: 600px) {
            .container {
                padding: 20px;
            }
            
            .time-unit {
                min-width: 80px;
                padding: 15px;
            }
            
            .time-value {
                font-size: 2rem;
            }
            
            h1 {
                font-size: 2rem;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Compte à Rebours</h1>
        
        <div class="target-date" id="targetDate">
            <!-- La date cible sera affichée ici par PHP -->
        </div>
        
        <div class="countdown">
            <div class="time-unit">
                <div class="time-value" id="days">00</div>
                <div class="time-label">Jours</div>
            </div>
            <div class="time-unit">
                <div class="time-value" id="hours">00</div>
                <div class="time-label">Heures</div>
            </div>
            <div class="time-unit">
                <div class="time-value" id="minutes">00</div>
                <div class="time-label">Minutes</div>
            </div>
            <div class="time-unit">
                <div class="time-value" id="seconds">00</div>
                <div class="time-label">Secondes</div>
            </div>
        </div>
        
        <div class="progress-bar">
            <div class="progress" id="progress"></div>
        </div>
        
        <div class="message" id="message"></div>
        
        <div class="info">
            <!-- Ce compte à rebours se met à jour automatiquement chaque seconde. -->
        </div>
    </div>

    <script>
        // Fonction pour calculer et afficher le compte à rebours
        function updateCountdown() {
            // Récupérer la date cible depuis l'attribut data
            const targetTimestamp = parseInt(document.getElementById('targetDate').getAttribute('data-timestamp')) * 1000;
            const now = new Date().getTime();
            const distance = targetTimestamp - now;
            
            // Si le compte à rebours est terminé
            if (distance < 0) {
                document.getElementById('days').innerText = '00';
                document.getElementById('hours').innerText = '00';
                document.getElementById('minutes').innerText = '00';
                document.getElementById('seconds').innerText = '00';
                document.getElementById('message').innerText = 'Le compte à rebours est terminé !';
                document.getElementById('message').className = 'message completed';
                document.getElementById('progress').style.width = '100%';
                return;
            }
            
            // Calculs du temps restant
            const days = Math.floor(distance / (1000 * 60 * 60 * 24));
            const hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
            const minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
            const seconds = Math.floor((distance % (1000 * 60)) / 1000);
            
            // Affichage des résultats
            document.getElementById('days').innerText = days.toString().padStart(2, '0');
            document.getElementById('hours').innerText = hours.toString().padStart(2, '0');
            document.getElementById('minutes').innerText = minutes.toString().padStart(2, '0');
            document.getElementById('seconds').innerText = seconds.toString().padStart(2, '0');
            
            // Mise à jour de la barre de progression
            const totalTime = 30 * 24 * 60 * 60 * 1000; // 30 jours en millisecondes
            const progressPercentage = Math.min(100, 100 - (distance / totalTime * 100));
            document.getElementById('progress').style.width = progressPercentage + '%';
            
            // Message spécial pour les derniers instants
            if (days === 0 && hours === 0 && minutes < 10) {
                document.getElementById('message').innerText = 'Plus que quelques minutes !';
            } else if (days === 0 && hours < 6) {
                document.getElementById('message').innerText = 'Presque là !';
            } else {
                document.getElementById('message').innerText = '';
            }
        }
        
        // Mise à jour initiale
        updateCountdown();
        
        // Mise à jour toutes les secondes
        setInterval(updateCountdown, 1000);
    </script>

    <?php
    // Définir la date cible (dans 30 jours à minuit)
    $targetDate = strtotime('+300 days 15:00:00');
    
    // Formater la date pour l'affichage
    $formattedDate = date('d/m/Y à H:i:s', $targetDate);
    
    // Afficher la date cible et passer le timestamp au JavaScript
    echo "<script>
        document.getElementById('targetDate').innerHTML = 'Date cible: $formattedDate';
        document.getElementById('targetDate').setAttribute('data-timestamp', '$targetDate');
    </script>";
    ?>
</body>
</html>