<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Politique</title>
    <link rel="stylesheet" href="css/pourAIDE/styleAIDE.css">
</head>
<body>
    <nav class="navbar">
        <a href="index.php" class="navbar-brand">
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-house" viewBox="0 0 16 16">
                <path d="M8.707 1.5a1 1 0 0 0-1.414 0L.646 8.146a.5.5 0 0 0 .708.708L2 8.207V13.5A1.5 1.5 0 0 0 3.5 15h9a1.5 1.5 0 0 0 1.5-1.5V8.207l.646.647a.5.5 0 0 0 .708-.708L13 5.793V2.5a.5.5 0 0 0-.5-.5h-1a.5.5 0 0 0-.5.5v1.293zM13 7.207V13.5a.5.5 0 0 1-.5.5h-9a.5.5 0 0 1-.5-.5V7.207l5-5z"/>
            </svg>
        </a>
        <div class="navbar-brand">ACCUEIL</div>
    </nav>

    <div class="container">
        <div class="content">
            <h1>Bonjour, comment pouvons nous vous aider?</h1>
            <br>
            <p>CONCERNANT:</p>

            <div class="aide">
                <span> Reservation:</span>
                <a href="AideReservation.html"><button > > </button></a>
            </div>
            <br>
            <div class="aide">
                <span>Comment PALM HAVEN fonctionne: </span>
                <a href="AideFonctionnement.html"><button> > </button></a>
            </div>
            <br>
            <div class="aide">
                <span>Support</span>
                <a href="AideSupport.html"><button> > </button></a>
            </div>
            <br>
            <div class="aide"> 
                <span>Autre</span>
                <a href="AideAutre.html"><button> > </button></a>
            </div>
            <br>
        </div>
    </div>

    <footer>
        <p>[] est représenté au Québec par nous (Canada) Inc., une licence québécoise. [], Inc. n'est pas responsable du contenu des sites Web externes.</p>
        <p>© 2024 [], Inc. Tous droits réservés.</p>
    </footer>
    <div class="container_">
      <div class="chat-header">
        <div class="logo">
        </div>
        <div class="title">Clavardage</div>
      </div>
      <div class="chat-body"></div>
      <div class="chat-input">
        <div class="input-sec">
          <input type="text" id="txtInput" placeholder="Écrire un message" autofocus />
        </div>
        <div class="send">
          <button>Envoyer</button>
</div>
</div>

    <script src="../backendWEB/chatbot.js"></script>
</body>
</html>