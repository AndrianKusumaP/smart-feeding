@extends('layouts.main')

@section('title', 'Edit Jarak Lontaran')

@section('content')
  <div class="page-heading">
    <div class="page-title">
      <div class="row align-items-center mx-3 mb-2">
        <div class="col-6">
          <h3>Edit Jarak Lontaran</h3>
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
                  <form action="{{ route('jarak-lontaran.update') }}" method="POST">
                    @csrf
                    <div class="mb-3">
                      <label for="jarak" class="form-label">Pilih Jarak Lontaran</label>
                      <select class="form-select" name="jarak" id="jarak" required>
                        <option value="180" {{ $jarakLontaran == 140 ? 'selected' : '' }}>1-1.5 meter</option>
                        <option value="220" {{ $jarakLontaran == 180 ? 'selected' : '' }}>1.5-2 meter</option>
                        <option value="255" {{ $jarakLontaran == 230 ? 'selected' : '' }}>2-2.5 meter</option>
                      </select>
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
