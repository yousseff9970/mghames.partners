
importScripts('https://www.gstatic.com/firebasejs/7.23.0/firebase-app.js');
importScripts('https://www.gstatic.com/firebasejs/7.23.0/firebase-messaging.js');

firebase.initializeApp({
    apiKey: 'AIzaSyAeGVyQxqvtRgWWm2FJoIixJ9ztlyfcFks',
    authDomain: 'mghames-partners.firebaseapp.com',
    projectId: 'mghames-partners',
    storageBucket: 'mghames-partners.appspot.com',
    messagingSenderId: '744296408044',
    appId: '1:744296408044:web:8018df403f701922c156c9',
    measurementId: 'G-4NY27PQCR3'
});
const messaging = firebase.messaging();
