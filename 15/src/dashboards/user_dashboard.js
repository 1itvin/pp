// States
const parsedCookies = {};
const messagesList = document.querySelector("#messages-list");
const pmMessagesList = document.querySelector("#pm-messages-list");
const msg = document.querySelector("#msg-input");
const btn = document.querySelector("#submit-btn");
const receiver = document.querySelector("#receiver");
const pm = document.querySelector("#pm");
const sendPmBtn = document.querySelector("#send-pm-btn");
let startMsgIndex = -1;

// Events
document.addEventListener("DOMContentLoaded", async () => {
  // General
  const { data } = await axios.get(
    "http://localhost/15/2/src/api/get_messages.php"
  );
  const newCoockies = document.cookie.split("; ").map((el) => {
    return el.split("=");
  });

  console.log("Cookies: ", parsedCookies);

  newCoockies.forEach((cookie) => {
    parsedCookies[cookie[0]] = cookie[1];
  });

  let dataToDisplay = null;
  // let startMsgIndex = -1;

  if (data.length !== 0) {
    if (parsedCookies["last_msg_id"] === "-1") {
      dataToDisplay = data[data.length - 1];
      startMsgIndex = data[data.length - 1].id;
    } else {
      data.forEach((msg, index) => {
        if (msg.id === parsedCookies["last_msg_id"]) {
          startMsgIndex = parseInt(msg.id, 10);
        }
      });

      if (startMsgIndex !== -1) {
        dataToDisplay = data.filter(
          (msg) => parseInt(msg.id, 10) >= parseInt(startMsgIndex, 10)
        );
      }
    }

    console.log("Data to display on DOM loaded: ", dataToDisplay);

    updateMessagesList(dataToDisplay, messagesList);
  }

  setInterval(async () => {
    const { data } = await axios.get(
      "http://localhost/15/2/src/api/get_messages.php"
    );

    dataToDisplay = data.filter(
      (msg) => parseInt(msg.id, 10) >= parseInt(startMsgIndex, 10)
    );

    updateMessagesList(dataToDisplay, messagesList);
  }, 3000);

  // PM
  const { data: pmData } = await axios.get(
    "http://localhost/15/2/src/api/get_pm_messages.php"
  );

  let pmDataToDisplay = null;
  // let startMsgIndex = -1;

  if (pmData.length !== 0) {
    pmDataToDisplay = pmData.filter((msg) => msg.to === parsedCookies.name);
    // if (parsedCookies["last_msg_id"] === "-1") {
    //   dataToDisplay = data[data.length - 1];
    //   startMsgIndex = data[data.length - 1].id;
    // } else {
    //   data.forEach((msg, index) => {
    //     if (msg.id === parsedCookies["last_msg_id"]) {
    //       startMsgIndex = parseInt(msg.id, 10);
    //     }
    //   });

    //   if (startMsgIndex !== -1) {
    //     dataToDisplay = data.filter(
    //       (msg) => parseInt(msg.id, 10) >= parseInt(startMsgIndex, 10)
    //     );
    //   }
    // }

    console.log("PM data to display on DOM loaded: ", pmDataToDisplay);

    updateMessagesList(pmDataToDisplay, pmMessagesList);
  }

  setInterval(async () => {
    const { data: pmData } = await axios.get(
      "http://localhost/15/2/src/api/get_pm_messages.php"
    );

    pmDataToDisplay = pmData.filter((msg) => msg.to === parsedCookies.name);

    updateMessagesList(pmDataToDisplay, pmMessagesList);
  }, 3000);
});

btn.addEventListener("click", async (e) => {
  e.preventDefault();

  const inputVal = msg.value;
  if (inputVal.length === 0) {
    return;
  }

  const now = new Date();
  const date = `${now.getHours()}:${now.getMinutes()} ${
    now.getUTCMonth() + 1
  }-${now.getUTCDate()}-${now.getUTCFullYear()}`;

  const { data } = await axios.get(
    "http://localhost/15/2/src/api/get_messages.php"
  );
  let id = 1;
  if (data.length > 0) {
    id = parseInt(data[data.length - 1].id, 10) + 1;
  }

  await axios.post("http://localhost/15/2/src/api/add_message.php", {
    id,
    login: parsedCookies.login,
    name: parsedCookies.name,
    title: inputVal,
    date,
  });

  msg.value = "";

  const { data: newData } = await axios.get(
    "http://localhost/15/2/src/api/get_messages.php"
  );

  const dataToDisplay = newData.filter(
    (msg) => parseInt(msg.id, 10) >= parseInt(startMsgIndex, 10)
  );

  updateMessagesList(dataToDisplay, messagesList);
});

sendPmBtn.addEventListener("click", async (e) => {
  e.preventDefault();

  const from = parsedCookies.login;
  const to = receiver.value;
  const name = parsedCookies.name;
  const msg = pm.value;

  if (to.length === 0 || msg.length === 0) {
    return;
  }

  const now = new Date();
  const date = `${now.getHours()}:${now.getMinutes()} ${
    now.getUTCMonth() + 1
  }-${now.getUTCDate()}-${now.getUTCFullYear()}`;

  await axios.post("http://localhost/15/2/src/api/add_pm_message.php", {
    from,
    to,
    name,
    msg,
    date,
  });

  // msg.value = "";
  receiver.value = "";
  pm.value = "";

  const { data: pmData } = await axios.get(
    "http://localhost/15/2/src/api/get_pm_messages.php"
  );

  const pmDataToDisplay = pmData.filter((msg) => msg.to === parsedCookies.name);

  updateMessagesList(pmDataToDisplay, pmMessagesList);
});

// Functions
function updateMessagesList(dataToDisplay, list) {
  let newList = "";
  console.log(dataToDisplay);

  if (!Array.isArray(dataToDisplay)) {
    formMsgHTMLElement(dataToDisplay);
  } else {
    if (list.children.length === dataToDisplay.length) {
      return;
    }
    dataToDisplay.forEach(formMsgHTMLElement);
  }

  list.innerHTML = newList;
  console.log("Updated: ", dataToDisplay);

  function formMsgHTMLElement(msg) {
    // console.log(msg);
    const isUsersMsg = msg.login === parsedCookies["login"] ? true : false;

    newList += `<li class="${
      isUsersMsg ? "message user" : "message other_user"
    }"><span class="message__user_name">${
      isUsersMsg ? "You" : msg.name
    } <span class="message__date">(${
      msg.date
    })</span></span><span class="message__title">${msg.title}</span></li>`;
  }
}
