// // States
// const parsedCookies = {};
// const messagesList = document.querySelector("#messages-list");
// // const msg = document.querySelector("#msg-input");
// // const btn = document.querySelector("#submit-btn");
// let startMsgIndex = -1;

// // Events
// document.addEventListener("DOMContentLoaded", async () => {
//   const { data } = await axios.get(
//     "http://localhost/15/2/src/api/get_messages.php"
//   );
//   const newCoockies = document.cookie.split("; ").map((el) => {
//     return el.split("=");
//   });

//   console.log("Cookies: ", parsedCookies);

//   newCoockies.forEach((cookie) => {
//     parsedCookies[cookie[0]] = cookie[1];
//   });

//   let dataToDisplay = null;
//   // let startMsgIndex = -1;

//   // console.log(data);

//   if (data.length !== 0) {
//     if (parsedCookies["last_msg_id"] === "-1") {
//       dataToDisplay = data[data.length - 1];
//       startMsgIndex = data[data.length - 1].id;
//     } else {
//       data.forEach((msg, index) => {
//         if (msg.id === parsedCookies["last_msg_id"]) {
//           startMsgIndex = parseInt(msg.id, 10);
//         }
//       });

//       if (startMsgIndex !== -1) {
//         dataToDisplay = data.filter(
//           (msg) => parseInt(msg.id, 10) >= parseInt(startMsgIndex, 10)
//         );
//       }
//     }

//     console.log("Data to display on DOM loaded: ", dataToDisplay);

//     updateMessagesList(dataToDisplay);
//   }

//   setInterval(async () => {
//     const { data } = await axios.get(
//       "http://localhost/15/2/src/api/get_messages.php"
//     );

//     dataToDisplay = data.filter(
//       (msg) => parseInt(msg.id, 10) >= parseInt(startMsgIndex, 10)
//     );

//     updateMessagesList(dataToDisplay);
//   }, 3000);
// });

// // Functions
// function updateMessagesList(dataToDisplay) {
//   let newList = "";

//   if (!Array.isArray(dataToDisplay)) {
//     formMsgHTMLElement(dataToDisplay);
//   } else {
//     if (messagesList.children.length === dataToDisplay.length) {
//       return;
//     }
//     dataToDisplay.forEach(formMsgHTMLElement);
//   }

//   messagesList.innerHTML = newList;
//   console.log("Updated: ", dataToDisplay);

//   function formMsgHTMLElement(msg) {
//     newList += `<li class="message other_user"><span class="message__user_name">${msg.name} <span class="message__date">(${msg.date})</span></span><span class="message__title">${msg.title}</span></li>`;
//   }
// }
