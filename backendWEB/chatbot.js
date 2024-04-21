const chatBody = document.querySelector(".chat-body");
const txtInput = document.querySelector("#txtInput");
const send = document.querySelector(".send");

send.addEventListener("click", () => renderUserMessage());

txtInput.addEventListener("keyup", (event) => {
  if (event.keyCode === 13) {
    renderUserMessage();
  }
});

const renderUserMessage = () => {
  const userInput = txtInput.value;
  renderMessageEle(userInput, "user");
  txtInput.value = "";
  setTimeout(() => {
    renderChatbotResponse(userInput);
    setScrollPosition();
  }, 600);
};

const renderChatbotResponse = (userInput) => {
  fetch(`TCH099_PROJET2.0/backendWEB/chatbot.php?option=${userInput}`)
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

const setScrollPosition = () => {
  if (chatBody.scrollHeight > 0) {
    chatBody.scrollTop = chatBody.scrollHeight;
  }
};

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
    fetch(`/TCH099_PROJET2.0/backendWEB/chatbot.php?option=${option}`)
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

