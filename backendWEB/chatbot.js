// Sélection des éléments DOM
const chatBody = document.querySelector(".chat-body");
const txtInput = document.querySelector("#txtInput");
const send = document.querySelector(".send");

// Ajout d'un écouteur d'événements pour le clic sur le bouton d'envoi
send.addEventListener("click", () => renderUserMessage());

// Ajout d'un écouteur d'événements pour la touche "Entrée" lors de la saisie dans le champ de texte
txtInput.addEventListener("keyup", (event) => {
  if (event.keyCode === 13) {
    renderUserMessage();
  }
});

// Fonction pour afficher le message de l'utilisateur
const renderUserMessage = () => {
  const userInput = txtInput.value;
  renderMessageEle(userInput, "user");
  txtInput.value = "";
  setTimeout(() => {
    renderChatbotResponse(userInput);
    setScrollPosition();
  }, 600);
};


// Fonction pour obtenir la réponse du chatbot via une requête fetch
const renderChatbotResponse = (userInput) => {
  fetch(`../backendWEB/chatbot.php?option=${userInput}`)
    .then(response => {
      if (!response.ok) {
        throw new Error('Erreur lors de la récupération de la réponse.');
      }
      return response.json(); // Utilisez response.json() pour traiter la réponse comme un objet JSON
    })
    .then(data => {
      if (data.reponses) {
        renderMessageEle(data.reponses, 'chatbot');
        setScrollPosition();
      } else if (data.options) {
        renderMessageEle(data.reponse, 'chatbot');
        setScrollPosition();
        renderOptionsAsButtons(data.options, chatBody);
        setScrollPosition();
      } else {
        renderMessageEle(data.reponse, 'chatbot');
        setScrollPosition();
      }
    })
    .catch(error => {
      console.error('Erreur:', error);
      renderMessageEle('Une erreur s\'est produite.', 'chatbot');
      setScrollPosition();
    });
};

// Fonction pour afficher un message dans le chat
const renderMessageEle = (txt, type) => {
  let className = "user-message";
  if (type !== "user") {
    className = "chatbot-message";
  }
  const messageEle = document.createElement("div");
  const txtNode = document.createTextNode(txt);
  messageEle.classList.add(className);
  messageEle.append(txtNode);
  chatBody.append(messageEle);
};

// Fonction pour définir la position de défilement du chat
const setScrollPosition = () => {
  if (chatBody.scrollHeight > 0) {
    chatBody.scrollTop = chatBody.scrollHeight;
  }
};

// Fonction pour afficher les options sous forme de boutons
const renderOptionsAsButtons = (options, container) => {
  const listContainer = document.createElement("ul");
  listContainer.classList.add("options-list");

  options.forEach(option => {
    const listItem = document.createElement("li");
    const button = document.createElement("button");
    button.textContent = option;
    button.addEventListener("click", () => handleOptionClick(option));
    listItem.appendChild(button);
    listContainer.appendChild(listItem);
  });

  container.append(listContainer);
};

// Fonction pour gérer le clic sur un bouton d'option
const handleOptionClick = (option) => {
    fetch(`../backendWEB/chatbot.php?option=${option}`)
      .then(response => {
        if (!response.ok) {
          throw new Error('Erreur lors de la récupération de la réponse.');
        }
        return response.json();
      })
      .then(data => {
        if (data.options) {
            renderMessageEle(data.reponse, 'chatbot');
            setScrollPosition();
            renderOptionsAsButtons(data.options, chatBody);
            setScrollPosition();
        } else {
          renderMessageEle(data.reponse, 'chatbot');
          setScrollPosition();
        }
      })
      .catch(error => {
        console.error('Erreur:', error);
        renderMessageEle('Une erreur s\'est produite.', 'chatbot');
        setScrollPosition();
      });
  };
  
  // Fonction pour afficher un message et des options
  const renderMessageAndOptions = (message, options) => {
    const container = document.createElement("div");
  
    // Ajouter la réponse
    const messageEle = document.createElement("div");
    const txtNode = document.createTextNode(message);
    messageEle.classList.add("chatbot-message");
    messageEle.append(txtNode);
    container.append(messageEle);
  
    // Ajouter les options comme boutons
    const listContainer = document.createElement("ul");
    listContainer.classList.add("options-list");
  
    options.forEach(option => {
      const listItem = document.createElement("li");
      const button = document.createElement("button");
      button.textContent = option;
      button.addEventListener("click", () => handleOptionClick(option));
      listItem.appendChild(button);
      listContainer.appendChild(listItem);
    });
  
    container.append(listContainer);
  
    return container;
  };

document.addEventListener("DOMContentLoaded", () => {
  // Message d'accueil du chatbot
  const welcomeMessage = "Bonjour! Besoin d'aide? Veuillez sélectionner l'une des options suivantes:";
  const options = ["Réservations","Politique","Autre"];
  const listContainer = document.createElement("ul");
  listContainer.classList.add("options-list");
  const responseContainer = renderMessageAndOptions(welcomeMessage, options);
  chatBody.append(responseContainer);
  setScrollPosition()

});

