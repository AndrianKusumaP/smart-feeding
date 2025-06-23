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
          <h3>Pemberian Pakan Otomatis</h3>
        </div>
      </div>
    </div>
    <section class="section">
      <div class="container">
        <div class="row" id="basic-table">

          {{-- Card Jadwal Pakan --}}
          <div class="col-12">
            <div class="card">
              <div class="card-content">
                <div class="card-body">
                  <div class="row mb-4 align-items-center">
                    <div class="col-6">
                      <h4 class="mb-0">Jadwal Pakan</h4>
                    </div>
                    <div class="col-6 text-end">
                      <a href="{{ route('jadwal-pakan.create') }}" class="btn btn-primary">Tambah Jadwal</a>
                    </div>
                  </div>
                  <div class="table-responsive">
                    <table class="table table-lg text-center">
                      <thead>
                        <tr>
                          <th style="width: 200px;">WAKTU</th>
                          <th style="width: 200px;">BERAT</th>
                          <th style="width: 150px;">AKSI</th>
                        </tr>
                      </thead>
                      <tbody>
                        @foreach (collect($data)->sortBy('waktu') as $id => $jadwal)
                          <tr>
                            <td>{{ $jadwal['waktu'] }}</td>
                            <td>{{ $jadwal['berat'] }} gram</td>
                            <td>
                              <a href="{{ route('jadwal-pakan.edit', $id) }}" class="btn btn-warning btn-sm">Edit</a>
                              <form action="{{ route('jadwal-pakan.destroy', $id) }}" method="POST"
                                style="display:inline;"
                                onsubmit="return confirm('Apakah Anda yakin ingin menghapus data ini?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm">Hapus</button>
                              </form>
                            </td>
                          </tr>
                        @endforeach
                      </tbody>
                    </table>
                  </div>
                </div>
              </div>
            </div>
          </div>
          
        </div>
      </div>
    </section>
  </div>
@endsection
