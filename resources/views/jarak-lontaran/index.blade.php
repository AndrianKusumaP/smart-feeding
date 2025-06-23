@extends('layouts.main')

@section('title', 'Jarak Lontaran')

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
          <h3>Jarak Lontaran</h3>
        </div>
      </div>
    </div>

    {{-- Card Jarak Lontaran --}}
    <div class="col-12">
      <div class="card">
        <div class="card-content">
          <div class="card-body">
            <h4 class="text-start mb-4">Jarak Lontaran</h4>
            <div class="table-responsive">
              <table class="table table-lg text-center">
                <thead>
                  <tr>
                    <th style="width: 200px;">JARAK</th>
                    <th style="width: 150px;">AKSI</th>
                  </tr>
                </thead>
                <tbody>
                  <tr>
                    @php
                      $label = match ((int) $jarakLontaran) {
                          180 => '1-1.5 meter',
                          220 => '1.5-2 meter',
                          255 => '2-2.5 meter',
                          default => '-',
                      };
                    @endphp

                    <td>{{ $label }}</td>
                    <td>
                      <a href="{{ route('jarak-lontaran.edit') }}" class="btn btn-warning btn-sm">Edit</a>
                    </td>
                  </tr>
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>
    </div>
@endsection