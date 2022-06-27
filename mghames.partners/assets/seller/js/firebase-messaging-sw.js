
/*
Give the service worker access to Firebase Messaging.
Note that you can only use Firebase Messaging here, other Firebase libraries are not available in the service worker.
*/
importScripts('https://www.gstatic.com/firebasejs/7.23.0/firebase-app.js');
importScripts('https://www.gstatic.com/firebasejs/7.23.0/firebase-messaging.js');

/*
Initialize the Firebase app in the service worker by passing in the messagingSenderId.
* New configuration for app@pulseservice.com
*/
//  const apiKey= document.getElementById("apiKey").value;
//  const authDomain= document.getElementById("authDomain").value;
//  const projectId= document.getElementById("projectId").value;
//  const storageBucket= document.getElementById("storageBucket").value;
//  const messagingSenderId= document.getElementById("messagingSender").value;
//  const appId= document.getElementById("appId").value;
//  const measurementId= document.getElementById("measurementId").value;

// alert(apiKey);
firebase.initializeApp({
    apiKey: "AIzaSyD4hRoY3gG6q7G_M3jfXszUhvkpo0YzIIY",
    authDomain: "shopifire-89775.firebaseapp.com",
    projectId: "shopifire-89775",
    storageBucket: "shopifire-89775.appspot.com",
    messagingSenderId: "179264744648",
    appId: "1:179264744648:web:577b8b8ff06ab2c348c9fd",
    measurementId: "G-MBEKFCZLFE"
});

/*
Retrieve an instance of Firebase Messaging so that it can handle background messages.
*/
const messaging = firebase.messaging();
messaging.setBackgroundMessageHandler(function(payload) {
  console.log(
    "[firebase-messaging-sw.js] Received background message ",
    payload,
  );
  /* Customize notification here */
  const notificationTitle = "Background Message Title";
  const notificationOptions = {
    body: "Background Message body.",
    icon: "/itwonders-web-logo.png",
  };

  return self.registration.showNotification(
    notificationTitle,
    notificationOptions,
  );
});


