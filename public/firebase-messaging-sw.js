// Give the service worker access to Firebase Messaging.
// Note that you can only use Firebase Messaging here. Other Firebase libraries
// are not available in the service worker.importScripts('https://www.gstatic.com/firebasejs/7.23.0/firebase-app.js');
importScripts('https://www.gstatic.com/firebasejs/8.3.2/firebase-app.js');
importScripts('https://www.gstatic.com/firebasejs/8.3.2/firebase-messaging.js');
/*
Initialize the Firebase app in the service worker by passing in the messagingSenderId.
*/
firebase.initializeApp({
    apiKey: "AIzaSyDOc-nOqWxiY78qxmSfp3QoYsXhsQxqkH0",
    authDomain: "kamao-paisa-2c0a4.firebaseapp.com",
    projectId: "kamao-paisa-2c0a4",
    storageBucket: "kamao-paisa-2c0a4.appspot.com",
    messagingSenderId: "933802149068",
    appId: "1:933802149068:web:d26f8d88931659161aee69",
    measurementId: "G-TLB7QS8VF7"
});

// Retrieve an instance of Firebase Messaging so that it can handle background
// messages.
const messaging = firebase.messaging();
messaging.setBackgroundMessageHandler(function(payload) {
    console.log("Message received.", payload);
    const title = "Hello world is awesome";
    const options = {
        body: "Your notificaiton message .",
        icon: "/firebase-logo.png",
    };
    return self.registration.showNotification(
        title,
        options,
    );
});