@extends('layouts.app')

@section('content')

    <div class="d-flex align-items-center mb-4 border-bottom-line">
        <h3 class="me-auto">
            <a href="{{ route('admin') }}"> <i class="fas fa-home me-3"></i>Home</a> /
            <a href="{{ route('daftar_request') }}">Daftar Request</a>
        </h3>
        <a href="#" onclick="confirmLogout()">
            <i class="fas fa-sign-out-alt fs-5 cursor-pointer" title="Logout"></i>
        </a>
    </div>
     

    {{-- Alert Notifikasi --}}
    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    @if (session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    

    <div class="card">
        <div class="card-body">
            <table class="table table-bordered">
                <thead class="table-secondary">
                    <tr>
                        <th>No</th>
                        <th>NIM Mahasiswa</th>
                        <th>Nama Mahasiswa</th>
                        <th>Alasan Konseling</th>
                        <th>Waktu</th>
                        <th>Approve</th>
                    </tr>
                </thead>
                
                <tbody>
                    @foreach ($requests as $key => $request)
                        <tr>
                            <td>{{ $requests->firstItem() + $key }}</td>
                            <td>{{ $request->nim }}</td>
                            <td>{{ $request->nama_mahasiswa }}</td>
                            <td>{{ $request->deskripsi_pengajuan }}</td>
                            <td>{{ $request->tanggal_pengajuan }}</td>
                            <td>
                                <form action="{{ route('approve_konseling', $request->id) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('PUT')
                                    <button class="btn btn-success btn-sm">
                                        <i class="fas fa-check"></i>
                                    </button>
                                </form>
                                <form action="{{ route('reject_konseling', $request->id) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('PUT')
                                    <button class="btn btn-danger btn-sm">
                                        <i class="fas fa-times"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
      
            </table>

            {{-- Pagination --}}
            <div class="d-flex content-center mt-3">
                {{ $requests->links('pagination::bootstrap-5') }}
            </div>
        </div>
    </div>
@endsection
