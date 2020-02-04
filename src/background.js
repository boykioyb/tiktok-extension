global.browser = require("webextension-polyfill");
import store from "./store";
// alert(`Hello ${store.getters.foo}!`)

chrome.webRequest.onBeforeSendHeaders.addListener(
  function(e) {
    for (
      var t = 0,
        o = 0,
        n = "https://" + new URL(e.url).hostname,
        a = 0,
        r = e.requestHeaders.length;
      a < r;
      ++a
    ) {
      var s = e.requestHeaders[a].name.toLowerCase();
      if (
        ("Referer" === s && (t = 1),
        "origin" === s && (o = 1),
        "origin" === s || "Referer" === s)
      ) {
        e.requestHeaders[a].value = n;
        break;
      }
    }
    return (
      0 === t &&
        e.requestHeaders.push({
          name: "Referer",
          value: n
        }),
      0 === o &&
        e.requestHeaders.push({
          name: "Origin",
          value: n
        }),
      {
        requestHeaders: e.requestHeaders
      }
    );
  },
  {
    urls: ["*://tiktok.com/*"]
  },
  ["blocking", "requestHeaders"]
);

// var requestFilter = {
//     urls: ["*://*/*"]
//   },
//   extraInfoSpec = ["requestHeaders", "blocking"],
//   handler = function(details) {
//     var isRefererSet = false;
//     var headers = details.requestHeaders,
//       blockingResponse = {};

//     for (var i = 0, l = headers.length; i < l; ++i) {
//       if (headers[i].name == "Referer") {
//         headers[i].value = "https://www.tiktok.com/trending/?lang=vi";
//         isRefererSet = true;
//         break;
//       }
//     }

//     if (!isRefererSet) {
//       headers.push({
//         name: "Referer",
//         value: "https://www.tiktok.com/trending/?lang=vi"
//       });
//     }

//     blockingResponse.requestHeaders = headers;
//     return blockingResponse;
//   };

// chrome.webRequest.onBeforeSendHeaders.addListener(
//   handler,
//   requestFilter,
//   extraInfoSpec
// );
