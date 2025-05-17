@extends('layouts.main')

@section('title', 'Edit Jadwal Pakan')

@section('content')
  <div class="page-heading">
    <div class="page-title">
      <div class="row align-items-center mx-3 mb-2">
        <div class="col-6">
          <h3>Edit Jadwal Pakan</h3>
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
                  <form action="{{ route('jadwal-pakan.update', $id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="mb-3">
                      <label for="waktu" class="form-label">Waktu</label>
                      <input type="time" class="form-control" id="waktu" name="waktu" value="{{ $data['waktu'] }}" required>
                    </div>
                    <div class="mb-3">
                      <label for="berat" class="form-label">Berat</label>
                      <input type="number" class="form-control" id="berat" name="berat" value="{{ $data['berat'] }}" placeholder="Masukkan berat dalam gram" required>
                    </div>
                    <a href="{{ route('jadwal-pakan.index') }}" class="btn btn-danger">Kembali</a>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                  </form>
                </div>
              </div>
            </div>
          </div>
        </div>
    </section>
  </div>
@endsection
