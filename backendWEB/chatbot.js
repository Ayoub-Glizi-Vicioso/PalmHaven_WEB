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
  const res = getChatbotResponse(userInput);
  renderMessageEle(res);
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

const getChatbotResponse = (userInput) => {
  return responseObj[userInput] == undefined
    ? "Please try something else"
    : responseObj[userInput];
};

const setScrollPosition = () => {
  if (chatBody.scrollHeight > 0) {
    chatBody.scrollTop = chatBody.scrollHeight;
  }
};

// Ajoutez ce code à la fin de votre script JavaScript

// Attendez que le contenu de la page soit chargé
document.addEventListener("DOMContentLoaded", () => {
    // Message d'accueil du chatbot
    const welcomeMessage = "Bonjour! Besoin d'aide? Veuillez sélectionner l'une des options suivantes:";
    renderMessageEle(welcomeMessage, "chatbot");
  
    const options = ["Réservations", "Autre"];
  
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
  
    const chatbotMessage = document.querySelector(".chatbot-message");
    chatbotMessage.appendChild(listContainer); // Ajoutez la liste à l'intérieur du message du chatbot
  });
  