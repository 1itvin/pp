import { CustomHttpClient, Response } from "./CustomHttpClient.mjs";

const form = document.querySelector("form");
const btn = document.querySelector("#btn");
const urlInput = document.querySelector("#url-input");
const contentBlock = document.querySelector("#content-block");
const httpClient = new CustomHttpClient();

form.addEventListener("submit", (e) => {
  e.preventDefault();
  btn.click();
});

btn.addEventListener("click", async () => {
  try {
    const input = urlInput.value;

    if (input.search(/^https?:\/\/.(\w)*/) === -1) {
      throw new Error("Invalid URL value 😕");
    }

    const res = await httpClient.sendRequest("GET", input);

    contentBlock.innerHTML = res.msg;
  } catch (e) {
    if (e instanceof Response) {
      contentBlock.innerHTML = `Message: ${e.msg}; Status: ${e.status}; StatusText: ${e.statusText}`;
    } else if (e instanceof Error) {
      contentBlock.innerHTML = e.message;
    } else {
      contentBlock.innerHTML = "Failed to get the resource ☹️";
    }
  }
});
