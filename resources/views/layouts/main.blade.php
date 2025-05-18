<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>@yield('title')</title>

  <link rel="preconnect" href="https://fonts.gstatic.com">
  <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@300;400;600;700;800&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="{{ asset('assets/css/bootstrap.css') }}">
  <link rel="stylesheet" href="{{ asset('assets/vendors/iconly/bold.css') }}">
  <link rel="stylesheet" href="{{ asset('assets/vendors/simple-datatables/style.css') }}">

  <link rel="stylesheet" href="{{ asset('assets/vendors/perfect-scrollbar/perfect-scrollbar.css') }}">
  <link rel="stylesheet" href="{{ asset('assets/vendors/bootstrap-icons/bootstrap-icons.css') }}">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
  <link rel="stylesheet" href="{{ asset('assets/css/app.css') }}">
  <link rel="shortcut icon" href="{{ asset('assets/images/favicon.ico') }}" type="image/x-icon">
  <meta name="csrf-token" content="{{ csrf_token() }}">
</head>

<body>
  <div id="app">

    @auth

      @include('partials.sidebar')

      <div id="main" class='layout-navbar'>

        @include('partials.topbar')

      @endauth

      <div id="main-content">

        @yield('content')

        @auth

          @include('partials.footer')

        @endauth

      </div>

    </div>


  </div>
  <script src="{{ asset('assets/vendors/perfect-scrollbar/perfect-scrollbar.min.js') }}"></script>
  <script src="{{ asset('assets/js/bootstrap.bundle.min.js') }}"></script>
  <script src="{{ asset('assets/vendors/simple-datatables/simple-datatables.js') }}"></script>

  <script>
    let table1 = document.querySelector('#table1');
    let dataTable = new simpleDatatables.DataTable(table1);
  </script>

  <script src="{{ asset('assets/js/main.js') }}"></script>

  <script type="module">
    import {
      initializeApp
    } from "https://www.gstatic.com/firebasejs/10.11.0/firebase-app.js";
    import {
      getMessaging,
      getToken
    } from "https://www.gstatic.com/firebasejs/10.11.0/firebase-messaging.js";

    const firebaseConfig = {
      apiKey: "AIzaSyBO_OlI8cu6VpE6hiQABczE8HusOZuVRfU",
      authDomain: "smartfeeding-7dca8.firebaseapp.com",
      projectId: "smartfeeding-7dca8",
      messagingSenderId: "694432260282",
      appId: "1:694432260282:web:ff9b790bad9d7a6d0fe283"
    };

    const app = initializeApp(firebaseConfig);
    const messaging = getMessaging(app);

    if ('serviceWorker' in navigator) {
      navigator.serviceWorker.register('/firebase-messaging-sw.js')
        .then((registration) => {
          console.log('✅ Service Worker registered');

          Notification.requestPermission().then((permission) => {
            if (permission === 'granted') {
              console.log('✅ Izin notifikasi diberikan');

              getToken(messaging, {
                vapidKey: "BESBBYW8vduzc5Etfk1wJRy2VHRzr8oAv8sYzKEB5xi8s4v9NhKn6Kl2e2mI8Ih_hxVfTT8dBsBED0ybpukPrts",
                serviceWorkerRegistration: registration
              }).then((token) => {
                if (token) {
                  console.log('🎯 Device Token:', token);

                  fetch('/simpan-device-token', {
                      method: 'POST',
                      headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute(
                          'content')
                      },
                      body: JSON.stringify({
                        token
                      })
                    })
                    .then(res => res.json())
                    .then(res => {
                      console.log('📦 Token disimpan:', res);
                    })
                    .catch(err => {
                      console.error('❌ Gagal simpan token:', err);
                    });

                } else {
                  console.warn('⚠️ Token tidak tersedia.');
                }
              }).catch((err) => {
                console.error('❌ Gagal ambil token:', err);
              });

            } else {
              console.log('❌ Izin notifikasi ditolak');
            }
          });

        }).catch((err) => {
          console.error('❌ Gagal register service worker:', err);
        });
    }

    // import {
    //   onMessage
    // } from 'https://…/firebase-messaging.js';

    // onMessage(messaging, (payload) => {
    //   new Notification(payload.notification.title, {
    //     body: payload.notification.body,
    //     icon: '/assets/images/favicon.ico'
    //   });
    // });
  </script>
</body>

</html>
