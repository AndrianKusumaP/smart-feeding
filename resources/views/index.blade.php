@extends('layouts.main')

@section('title', 'Dashboard')

@section('content')
  <div class="page-heading">
    <div class="page-title">
      <div class="row">
        <div class="col-12 col-md-6 order-md-1 mb-2 order-last">
          <h3>Dashboard</h3>
        </div>
      </div>
    </div>
    <section class="section">
      <div class="container">

        <!-- Card Waktu & Tanggal -->
        <div class="row">
          <div class="col-12">
            <div class="card p-4">
              <div class="card-body d-flex flex-column align-items-center text-center">
                <div class="stats-icon orange mb-3" style="width: 5rem; height: 5rem;">
                  <i class="fas fa-clock" style="font-size: 4rem;"></i>
                </div>
                <h5 class="text-muted font-weight-semibold">Waktu & Tanggal</h5>
                <h4 class="font-weight-bold mb-0" id="datetime"></h4>
              </div>
            </div>
          </div>
        </div>

        <!-- Tombol Restart dan Beri Pakan -->
        <div class="row">
          <div class="col-12">
            <div class="card p-4">
              <div class="card-body d-flex justify-content-center flex-column align-items-center text-center">
                <div class="d-flex gap-3 mb-3">
                  <button id="restartBtn" class="btn btn-success btn-lg"
                    style="padding: 0.75rem 1.5rem; font-size: 1.5rem;">
                    <i class="fas fa-sync-alt me-2"></i> Restart
                  </button>
                  <button id="feedBtn" class="btn btn-primary btn-lg"
                    style="padding: 0.75rem 1.5rem; font-size: 1.5rem;">
                    <i class="fas fa-fish me-2"></i> Beri Pakan
                  </button>
                </div>
                <h5 class="text-muted font-weight-semibold">Tekan tombol untuk restart atau beri pakan secara manual</h5>
              </div>
            </div>
          </div>
        </div>

        <!-- Data Realtime -->
        <div class="row">
          <div class="col-12 col-sm-6 col-lg-6 col-md-6">
            <div class="card p-4">
              <div class="card-body d-flex flex-column align-items-center text-center">
                <div class="stats-icon purple mb-3" style="width: 5rem; height: 5rem;">
                  <i class="fas fa-water" style="font-size: 4rem;"></i>
                </div>
                <h5 class="text-muted font-weight-semibold">Kekeruhan Air</h5>
                <h4 class="font-weight-bold mb-0" id="kekeruhan">{{ $data['kekeruhan'] ?? 'N/A' }}</h4>
              </div>
            </div>
          </div>

          <div class="col-12 col-sm-6 col-lg-6 col-md-6">
            <div class="card p-4">
              <div class="card-body d-flex flex-column align-items-center text-center">
                <div class="stats-icon blue mb-3" style="width: 5rem; height: 5rem;">
                  <i class="fas fa-fish" style="font-size: 4rem;"></i>
                </div>
                <h5 class="text-muted font-weight-semibold">Sisa Pakan</h5>
                <h4 class="font-weight-bold mb-0" id="pakan">{{ $data['pakan'] ?? 'N/A' }}</h4>
              </div>
            </div>
          </div>
        </div>

        <div class="row">
          <div class="col-12 col-sm-6 col-lg-6 col-md-6">
            <div class="card p-4">
              <div class="card-body d-flex flex-column align-items-center text-center">
                <div class="stats-icon green mb-3" style="width: 5rem; height: 5rem;">
                  <i class="fas fa-flask" style="font-size: 4rem;"></i>
                </div>
                <h5 class="text-muted font-weight-semibold">pH</h5>
                <h4 class="font-weight-bold mb-0" id="ph">{{ $data['ph'] ?? 'N/A' }}</h4>
              </div>
            </div>
          </div>

          <div class="col-12 col-sm-6 col-lg-6 col-md-6">
            <div class="card p-4">
              <div class="card-body d-flex flex-column align-items-center text-center">
                <div class="stats-icon red mb-3" style="width: 5rem; height: 5rem;">
                  <i class="fas fa-thermometer-half" style="font-size: 4rem;"></i>
                </div>
                <h5 class="text-muted font-weight-semibold">Suhu</h5>
                <h4 class="font-weight-bold mb-0" id="suhu">{{ $data['suhu'] ?? 'N/A' }}</h4>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>
  </div>

  <!-- Firebase JS -->
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

    // Realtime data
    const dataRef = ref(database, 'MonitoringKolam/realtime');
    onValue(dataRef, (snapshot) => {
      const data = snapshot.val();
      if (data) {
        document.getElementById('kekeruhan').textContent = data.kekeruhan ?? 'N/A';
        document.getElementById('pakan').textContent = data.pakan ? `${data.pakan}%` : 'N/A';
        document.getElementById('ph').textContent = data.ph ?? 'N/A';
        document.getElementById('suhu').textContent = data.suhu ? `${data.suhu}°C` : 'N/A';
      }
    });

    // Waktu berjalan
    function updateDateTime() {
      const now = new Date();
      const datetimeString = now.toLocaleTimeString() + ' | ' + now.toLocaleDateString('id-ID');
      document.getElementById('datetime').textContent = datetimeString;
    }
    setInterval(updateDateTime, 1000);
    updateDateTime();

    // Tombol restart logic
    const restartBtn = document.getElementById('restartBtn');
    const restartRef = ref(database, 'ControlSystem/restart');

    restartBtn.addEventListener('click', async () => {
      await set(restartRef, true);

      restartBtn.classList.remove('btn-success');
      restartBtn.classList.add('btn-danger');
      restartBtn.innerHTML = '<i class="fas fa-sync-alt me-2"></i> Restarting...';
      restartBtn.disabled = true;
    });

    onValue(restartRef, (snapshot) => {
      const status = snapshot.val();
      if (status === true) {
        // Kalau sedang restart
        restartBtn.classList.remove('btn-success');
        restartBtn.classList.add('btn-danger');
        restartBtn.innerHTML = '<i class="fas fa-sync-alt me-2"></i> Restarting...';
        restartBtn.disabled = true;
      } else {
        // Kalau tidak sedang restart
        restartBtn.classList.remove('btn-danger');
        restartBtn.classList.add('btn-success');
        restartBtn.innerHTML = '<i class="fas fa-sync-alt me-2"></i> Restart';
        restartBtn.disabled = false;
      }
    });

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

    onValue(dataRef, (snapshot) => {
      const data = snapshot.val();
      if (data) {
        // Kekeruhan
        const kekeruhan = data.kekeruhan ?? 'N/A';
        const kekeruhanElem = document.getElementById('kekeruhan');
        kekeruhanElem.textContent = kekeruhan;
        kekeruhanElem.className = 'font-weight-bold mb-0';
        kekeruhanElem.style.color = 'black';

        if (kekeruhan !== 'N/A') {
          switch (kekeruhan.toLowerCase()) {
            case 'sangat keruh':
              kekeruhanElem.style.color = 'red';
              break;
            case 'agak keruh':
              kekeruhanElem.style.color = 'blue';
              break;
            case 'jernih':
              kekeruhanElem.style.color = 'green';
              break;
            default:
              kekeruhanElem.style.color = 'black';
          }
        }

        // Sisa Pakan
        const pakan = data.pakan ?? 'N/A';
        const pakanElem = document.getElementById('pakan');
        pakanElem.textContent = pakan !== 'N/A' ? `${pakan}%` : 'N/A';
        pakanElem.className = 'font-weight-bold mb-0';
        pakanElem.nextElementSibling?.remove?.(); // Hapus info sebelumnya jika ada
        if (pakan !== 'N/A') {
          if (pakan <= 30) {
            pakanElem.style.color = 'red';
          } else if (pakan <= 70) {
            pakanElem.style.color = 'blue';
          } else {
            pakanElem.style.color = 'green';
          }
        }

        // pH
        const ph = data.ph ?? 'N/A';
        const phElem = document.getElementById('ph');
        phElem.textContent = ph;
        phElem.className = 'font-weight-bold mb-0';
        phElem.style.color = 'black';

        // Hapus keterangan sebelumnya (kalau ada)
        const oldPhDesc = document.getElementById('ph-desc');
        if (oldPhDesc) oldPhDesc.remove();

        if (ph !== 'N/A') {
          const desc = document.createElement('small');
          desc.id = 'ph-desc'; // agar bisa dihapus nanti
          desc.style.display = 'block';
          desc.style.marginTop = '0.25rem';

          if (ph < 6) {
            phElem.style.color = 'red';
            desc.textContent = 'Air terlalu asam';
            desc.style.color = 'red';
          } else if (ph > 9) {
            phElem.style.color = 'blue';
            desc.textContent = 'Air terlalu basa';
            desc.style.color = 'blue';
          } else {
            phElem.style.color = 'green';
            desc.textContent = 'pH air normal';
            desc.style.color = 'green';
          }

          phElem.parentNode.appendChild(desc);
        }

        // Suhu
        const suhu = data.suhu ?? 'N/A';
        const suhuElem = document.getElementById('suhu');
        suhuElem.textContent = suhu !== 'N/A' ? `${suhu}°C` : 'N/A';
        suhuElem.className = 'font-weight-bold mb-0';
        suhuElem.style.color = 'black';

        const oldSuhuDesc = document.getElementById('suhu-desc');
        if (oldSuhuDesc) oldSuhuDesc.remove();

        if (suhu !== 'N/A') {
          const desc = document.createElement('small');
          desc.id = 'suhu-desc';
          desc.style.display = 'block';
          desc.style.marginTop = '0.25rem';

          if (suhu < 25) {
            suhuElem.style.color = 'blue';
            desc.textContent = 'Air terlalu dingin';
            desc.style.color = 'blue';
          } else if (suhu > 30) {
            suhuElem.style.color = 'red';
            desc.textContent = 'Air terlalu panas';
            desc.style.color = 'red';
          } else {
            suhuElem.style.color = 'green';
            desc.textContent = 'Suhu air normal';
            desc.style.color = 'green';
          }

          suhuElem.parentNode.appendChild(desc);
        }
      }
    });
  </script>
@endsection
