@extends('layouts.main')

@section('title', 'Pemberian Pakan Otomatis')

@section('content')
  <div class="page-heading">
    @if (session('success'))
      <div class="alert alert-success alert-dismissible fade show" role="alert">
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
      </div>
    @endif

    <div class="page-title">
      <div class="row align-items-center mx-3 mb-2">
        <div class="col-6">
          <h3>Pemberian Pakan Manual</h3>
        </div>
      </div>
    </div>

    <section class="section">
      <div class="container">
        <div class="row" id="basic-table">
          <div class="col-12">
            <div class="card">
              <div class="card-content">
                <div class="card-body">
                  <h4 class="text-start mb-4">Berat Pakan Manual</h4>
                  <div class="table-responsive">
                    <table class="table table-lg text-center">
                      <thead>
                        <tr>
                          <th style="width: 200px;">BERAT</th>
                          <th style="width: 150px;">AKSI</th>
                        </tr>
                      </thead>
                      <tbody>
                        <tr>
                          <td>{{ $beratPakanManual ?? '-' }} gram</td>
                          <td>
                            <a href="{{ route('pakan-manual.edit') }}" class="btn btn-warning btn-sm">Edit</a>
                          </td>
                        </tr>
                      </tbody>
                    </table>
                  </div>
                </div>
              </div>
            </div>
          </div>

          <!-- Tombol Beri Pakan -->
          <div class="row">
            <div class="col-12">
              <div class="card p-4">
                <div class="card-body d-flex justify-content-center flex-column align-items-center text-center">
                  <button id="feedBtn" class="btn btn-primary btn-lg"
                    style="padding: 0.75rem 1.5rem; font-size: 1.5rem;">
                    <i class="fas fa-fish me-2"></i> Beri Pakan
                  </button>
                  <h5 class="text-muted font-weight-semibold mt-3">Tekan tombol untuk memberi pakan secara manual</h5>
                </div>
              </div>
            </div>
          </div>

        </div>
      </div>
    </section>
  </div>
  <script type="module">
    import {
      initializeApp
    } from "https://www.gstatic.com/firebasejs/9.6.1/firebase-app.js";
    import {
      getDatabase,
      ref,
      onValue,
      set
    } from "https://www.gstatic.com/firebasejs/9.6.1/firebase-database.js";

    const firebaseConfig = {
      apiKey: "AIzaSyBO_OlI8cu6VpE6hiQABczE8HusOZuVRfU",
      authDomain: "smartfeeding-7dca8.firebaseapp.com",
      databaseURL: "https://smartfeeding-7dca8-default-rtdb.asia-southeast1.firebasedatabase.app",
      projectId: "smartfeeding-7dca8",
      storageBucket: "smartfeeding-7dca8.appspot.com",
      messagingSenderId: "694432260282",
      appId: "1:694432260282:web:ff9b790bad9d7a6d0fe283"
    };

    const app = initializeApp(firebaseConfig);
    const database = getDatabase(app);
    
    // Tombol beri pakan logic
    const feedBtn = document.getElementById('feedBtn');
    const feedRef = ref(database, 'ControlSystem/beriPakan');

    feedBtn.addEventListener('click', async () => {
      await set(feedRef, true); // ESP32 akan mendeteksi ini lalu memberi makan

      feedBtn.classList.remove('btn-primary');
      feedBtn.classList.add('btn-warning');
      feedBtn.innerHTML = '<i class="fas fa-fish me-2"></i> Memberi Pakan...';
      feedBtn.disabled = true;
    });

    // Dengarkan perubahan status beriPakan
    onValue(feedRef, (snapshot) => {
      const status = snapshot.val();
      if (status === true) {
        // Kalau sedang memberi pakan
        feedBtn.classList.remove('btn-primary');
        feedBtn.classList.add('btn-warning');
        feedBtn.innerHTML = '<i class="fas fa-fish me-2"></i> Memberi Pakan...';
        feedBtn.disabled = true;
      } else {
        // Kalau tidak sedang memberi pakan
        feedBtn.classList.remove('btn-warning');
        feedBtn.classList.add('btn-primary');
        feedBtn.innerHTML = '<i class="fas fa-fish me-2"></i> Beri Pakan';
        feedBtn.disabled = false;
      }
    });
  </script>
@endsection
