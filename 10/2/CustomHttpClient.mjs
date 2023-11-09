export class Response {
  constructor(msg, status = null, statusText = null) {
    this.msg = msg;
    if (status !== null && statusText !== null) {
      this.status = status;
      this.statusText = statusText;
    }
  }
}

export class CustomHttpClient {
  constructor() {
    this.client = new XMLHttpRequest();
    this.readyState = 0;

    this.client.addEventListener("readystatechange", (e) => {
      this.handleStateChange.bind(this);
      this.handleStateChange(e);
    });
    this.client.addEventListener("progress", this.handleProgress);
    this.client.addEventListener("abort", this.handleAbort);
    this.client.addEventListener("timeout", this.handleTimeout);
  }

  // params
  async sendRequest(method, url, params = null, headers = null, body = null) {
    return new Promise((resolve, reject) => {
      const newUrl = new URL(url);

      if (params !== null) {
        for (const arr of params) {
          newUrl.searchParams.set(arr[0], arr[1]);
        }
      }

      this.client.open(method, newUrl, true);

      if (headers !== null) {
        for (const header in headers) {
          this.client.setRequestHeader(header, headers[header]);
          console.log(header, headers[header]);
        }
      }

      this.client.onload = function () {
        if (this.status >= 100 && this.status < 200) {
          resolve(
            new Response("Informational Request", this.status, this.statusText)
          );
        } else if (this.status >= 200 && this.status < 300) {
          resolve(new Response(this.response, this.status, this.statusText));
        } else if (this.status >= 300 && this.status < 400) {
          resolve(
            new Response("Redirectional Request", this.status, this.statusText)
          );
        } else if (this.status >= 400 && this.status < 500) {
          reject(new Response("Client Error", this.status, this.statusText));
        } else if (this.status >= 500 && this.status < 600) {
          reject(new Response("Server Error", this.status, this.statusText));
        } else {
          reject(new Response("Unknown response status"));
        }
      };

      this.client.onerror = function () {
        reject(new Response("Network error occured 😕"));
      };

      this.client.send(body);
    });
  }

  abort() {
    this.client.abort();
  }

  handleStateChange(e) {
    const newState = e.target.readyState;

    if (newState !== this.readyState) {
      switch (newState) {
        case 1:
          console.log(`${newState} - Open called`);
          break;
        case 2:
          console.log(`${newState} - Response headers received`);
          break;
        case 3:
          console.log(`${newState} - Response is loading...`);
          break;
        case 4:
          console.log(`${newState} - Request Complete`);
          break;
        default:
          console.log("Unknown state");
      }
    }

    this.readyState = e.target.readyState;
  }

  handleAbort() {
    console.log("Request Aborted");
  }

  handleTimeout() {
    console.log("Request Timeout");
  }

  handleProgress(e) {
    console.log(`Progress: ${e.loaded} of ${e.total}`);
  }
}
