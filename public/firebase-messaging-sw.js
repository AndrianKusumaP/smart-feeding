// firebase-messaging-sw.js
importScripts(
    "https://www.gstatic.com/firebasejs/10.11.0/firebase-app-compat.js"
);
importScripts(
    "https://www.gstatic.com/firebasejs/10.11.0/firebase-messaging-compat.js"
);

firebase.initializeApp({
    apiKey: "AIzaSyBO_OlI8cu6VpE6hiQABczE8HusOZuVRfU",
    authDomain: "smartfeeding-7dca8.firebaseapp.com",
    projectId: "smartfeeding-7dca8",
    messagingSenderId: "694432260282",
    appId: "1:694432260282:web:ff9b790bad9d7a6d0fe283",
});

const messaging = firebase.messaging();

messaging.onBackgroundMessage((payload) => {
    console.log('[SW] bg message:', payload);
  
    const title = payload.data.title;
    const options = {
      body: payload.data.body,
      icon: '/assets/images/favicon.ico',
    };
  
    self.registration.showNotification(title, options);
  });
  