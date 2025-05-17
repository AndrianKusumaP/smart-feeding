@extends('layouts.main')

@section('title', 'History')

@section('content')
  <div class="page-heading">
    <div class="page-title">
      <div class="row align-items-center mx-3 mb-2">
        <div class="col-6">
          <h3>Histroy</h3>
        </div>
      </div>
    </div>
    <section class="section">
      <div class="card">
        <div class="card-body">
          <table class="table table-striped" id="table1">
            <thead>
              <tr>
                <th style="width: 250px;">WAKTU</th>
                <th>BERAT PAKAN</th>
                <th>SUHU</th>
                <th>KEKERUHAN</th>
                <th>PH</th>
              </tr>
            </thead>
            <tbody>
              @if ($data)
                @foreach ($data as $tanggal => $jamData)
                  @foreach ($jamData as $jam => $detail)
                    <tr>
                      <td>{{ $tanggal }} {{ $jam }}</td>
                      <td>{{ $detail['berat'] ?? 'N/A' }}</td>
                      <td>{{ $detail['suhu'] ?? 'N/A' }}°C</td>
                      <td>{{ $detail['kekeruhan'] ?? 'N/A' }}</td>
                      <td>{{ $detail['ph'] ?? 'N/A' }}</td>
                    </tr>
                  @endforeach
                @endforeach
              @else
                <tr>
                  <td colspan="5">Belum ada data</td>
                </tr>
              @endif
            </tbody>
          </table>
        </div>
      </div>
    </section>
  </div>

@endsection
