"use strict";

const apiKey= $('#apiKey').val();
const authDomain= $('#authDomain').val();
const projectId= $('#projectId').val();
const storageBucket= $('#storageBucket').val();
const messagingSenderId= $('#messagingSenderId').val();
const appId= $('#appId').val();
const measurementId= $('#measurementId').val();


var firebaseConfig = {
   apiKey: apiKey,
   authDomain: authDomain,
   projectId: projectId,
   storageBucket: storageBucket,
   messagingSenderId: messagingSenderId,
   appId: appId,
   measurementId: measurementId
};

firebase.initializeApp(firebaseConfig);
const messaging = firebase.messaging();


function initFirebaseMessagingRegistration() {
        messaging
        .requestPermission()
        .then(function () {
            return messaging.getToken()
        })
        .then(function(token) {

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                url: $('#save_token').val(),
                type: 'POST',
                data: {
                    token: token
                },
                dataType: 'JSON',
                beforeSend: function(response){
                  $('#btn-nft-enable').html('Please Wait....');
                  $('#btn-nft-enable').attr('disabled','');
              },
              success: function (response) {
                $('#btn-nft-enable').remove();
                localStorage.setItem('tokenStatus','enabled');
                Sweet('success','Successfully notification enabled')
            },
            error: function (err) {

            },
        });
        }).catch(function (err) {

        });
}

messaging.onMessage(function(payload) {
        var noteTitle =  payload.notification.title;
        var noteOptions = {
            body: payload.notification.body,
            icon: payload.notification.icon,
            click_action: payload.notification.click_action
        };
        new Notification(noteTitle, noteOptions);

       if (typeof getCurrentOrders == 'function') { 
          var notification_class=document.getElementsByClassName('notification-toggle');
         if (notification_class) {
            getCurrentOrders();
       }

   }
});


var token=localStorage.getItem('tokenStatus');
if (token != null) {
    $('.notification_button').remove();
}


$('#btn-nft-enable').on('click',function(){

    initFirebaseMessagingRegistration();
});