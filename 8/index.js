// Create containers
function appendContainer(myNodeList) {
  const div = document.createElement("div");
  div.className = "btns-container";
  myNodeList.appendChild(div);
}

var myNodeList = document.querySelectorAll(".container");
for (let i = 0; i < myNodeList.length; i++) {
  appendContainer(myNodeList[i]);
}

// Add Btns
function appendAddBtn(myNodeList) {
  var span = document.createElement("button");
  var txt = document.createTextNode("add");
  span.className = "add-inner";
  span.appendChild(txt);
  myNodeList.appendChild(span);

  span.addEventListener("click", (e) => {
    const inputValue = document.getElementById("myInput").value;
    const parent = e.target.parentElement.parentElement.parentElement;
    const innerList = parent.querySelector("ul");

    if (inputValue === "") {
      alert("You must write something!");
      return;
    }

    if (innerList.classList.contains("d-none")) {
      innerList.classList.remove("d-none");
    }

    const li = document.createElement("li");
    const t = document.createTextNode(inputValue);
    const ul = document.createElement("ul");
    const container = document.createElement("div");
    const titleEl = document.createElement("span");
    ul.className = "inner-list d-none";
    container.className = "container";
    titleEl.className = "title";

    titleEl.appendChild(t);
    container.appendChild(titleEl);
    appendContainer(container);
    li.appendChild(container);
    li.appendChild(ul);

    const btnsContainer = li.querySelector(".btns-container");

    // Add Btn
    appendAddBtn(btnsContainer);

    // Edit Btn
    appendEditBtn(btnsContainer);

    // Close Btn
    appendCloseBtn(btnsContainer);

    btnsContainer.addEventListener("click", (e) => e.stopPropagation());

    li.addEventListener("click", (e) => {
      if (e.currentTarget.tagName === "LI") {
        e.currentTarget.classList.toggle("checked");
      }
      e.stopPropagation();
    });

    innerList.appendChild(li);
    document.getElementById("myInput").value = "";
  });

  span.addEventListener("mousedown", (e) => e.stopPropagation());
}

var myNodeList = document.querySelectorAll(".btns-container");
for (let i = 0; i < myNodeList.length; i++) {
  appendAddBtn(myNodeList[i]);
}

// Edit Btns
function appendEditBtn(myNodeList) {
  var span = document.createElement("button");
  var txt = document.createTextNode("edit");
  span.className = "edit";
  span.appendChild(txt);

  span.addEventListener("click", (e) => {
    const parent = e.target.parentElement.parentElement;
    console.log(parent);
    const prompt = window.prompt("New Title");

    parent.querySelector(".title").innerText = prompt;

    // e.stopPropagation();
  });

  span.addEventListener("mousedown", (e) => e.stopPropagation());

  myNodeList.appendChild(span);
}

var myNodeList = document.querySelectorAll(".btns-container");
for (let i = 0; i < myNodeList.length; i++) {
  appendEditBtn(myNodeList[i]);
}

// Create a "close" button and append it to each list item
function appendCloseBtn(myNodeList) {
  var span = document.createElement("button");
  var txt = document.createTextNode("\u00D7");
  span.className = "close";
  span.appendChild(txt);

  span.onclick = function (e) {
    var div = this.parentElement.parentElement.parentElement;
    div.style.display = "none";

    // e.stopPropagation();
  };

  span.addEventListener("mousedown", (e) => e.stopPropagation());

  myNodeList.appendChild(span);
}

var myNodeList = document.querySelectorAll(".btns-container");
for (let i = 0; i < myNodeList.length; i++) {
  appendCloseBtn(myNodeList[i]);
}

// Add a "checked" symbol when clicking on a list item
for (let i = 0; i < myNodeList.length; i++) {
  myNodeList[i].addEventListener("click", (e) => e.stopPropagation());
}

var listItems = document.querySelectorAll("li");
for (let i = 0; i < listItems.length; i++) {
  listItems[i].addEventListener("click", (e) => {
    if (e.currentTarget.tagName === "LI") {
      console.log("ds");
      e.currentTarget.classList.toggle("checked");
    }
    e.stopPropagation();
  });
}

// Create a new list item when clicking on the "Add" button
function newElement() {
  var li = document.createElement("li");
  var inputValue = document.getElementById("myInput").value;
  var t = document.createTextNode(inputValue);
  const ul = document.createElement("ul");
  ul.className = "inner-list d-none";
  const container = document.createElement("div");
  container.className = "container";
  const titleEl = document.createElement("span");
  titleEl.className = "title";

  titleEl.appendChild(t);
  container.appendChild(titleEl);
  appendContainer(container);
  li.appendChild(container);
  li.appendChild(ul);

  const btnsContainer = li.querySelector(".btns-container");

  if (inputValue === "") {
    alert("You must write something!");
  } else {
    document.getElementById("myUL").appendChild(li);
  }
  document.getElementById("myInput").value = "";

  // Add Btn
  appendAddBtn(btnsContainer);

  // Edit Btn
  appendEditBtn(btnsContainer);

  // Close Btn
  appendCloseBtn(btnsContainer);

  btnsContainer.addEventListener("click", (e) => e.stopPropagation());

  li.addEventListener("click", (e) => {
    if (e.currentTarget.tagName === "LI") {
      e.currentTarget.classList.toggle("checked");
    }
  });
}

// Shortcuts
let selectedLi = null;
var listItems = document.querySelectorAll("li");

listItems.forEach((item) => {
  item.addEventListener("click", (e) => {
    selectedLi = e.currentTarget;
  });
});

document.addEventListener("keyup", (e) => {
  if (e.ctrlKey && e.key === "d") {
    if (selectedLi == null) {
      alert("No list item has been selected");
      return;
    }

    selectedLi.querySelector(".close").click();
    selectedLi = null;
  } else if (e.ctrlKey && e.key === "e") {
    if (selectedLi == null) {
      alert("No list item has been selected");
      return;
    }

    selectedLi.querySelector(".edit").click();
  }
});

// Drag & Drop
document.querySelectorAll("button").forEach((btn) => {
  btn.addEventListener("mousedown", (e) => e.stopPropagation());
});

var listItems = document.querySelectorAll("li");
listItems.forEach((item) => {
  item.onmousedown = function (event) {
    const listPickedUpFrom = item.parentElement;
    const nextItemSibling = item.nextSibling;

    function onMouseMove(event) {
      item.style.position = "absolute";
      item.style.zIndex = 1000;
      document.body.append(item);

      moveAt(event.pageX, event.pageY);

      function moveAt(pageX, pageY) {
        item.style.left = pageX - item.offsetWidth / 2 + "px";
        item.style.top = pageY - item.offsetHeight / 2 + "px";
      }
      moveAt(event.pageX, event.pageY);

      item.hidden = true;
      let elemBelow = document.elementFromPoint(event.clientX, event.clientY);
      item.hidden = false;

      if (!elemBelow) return;

      if (elemBelow.tagName === "LI") {
        const parent = elemBelow.parentElement;
        item.style.position = "relative";
        item.style.top = 0;
        item.style.left = 0;
        parent.insertBefore(item, elemBelow);
      } else if (elemBelow.className === "container") {
        const parent = elemBelow.parentElement.parentElement;
        item.style.position = "relative";
        item.style.top = 0;
        item.style.left = 0;
        parent.insertBefore(item, elemBelow.parentElement);
      }
    }

    document.addEventListener("mousemove", onMouseMove);

    item.onmouseup = function (event) {
      item.hidden = true;
      const currentElemBelow = document.elementFromPoint(
        event.clientX,
        event.clientY
      );
      item.hidden = false;

      if (
        currentElemBelow.className !== "container" &&
        currentElemBelow.tagName !== "LI"
      ) {
        item.style.position = "relative";
        item.style.top = 0;
        item.style.left = 0;

        if (nextItemSibling !== null) {
          listPickedUpFrom.insertBefore(item, nextItemSibling);
        } else {
          listPickedUpFrom.appendChild(item);
        }
      }

      document.removeEventListener("mousemove", onMouseMove);
      item.onmouseup = null;
    };
  };

  item.ondragstart = () => false;
});
