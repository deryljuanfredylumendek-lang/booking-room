<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Room Booking</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap" rel="stylesheet">
<!-- Core CSS -->
<link rel="stylesheet" href="{{ asset('/') }}assets/vendor/css/core.css" class="template-customizer-core-css" />
<link rel="stylesheet" href="{{ asset('/') }}assets/vendor/css/theme-default.css" class="template-customizer-theme-css" />
{{-- <link rel="stylesheet" href="{{ asset('/') }}assets/css/demo.css" /> --}}

<!-- Vendors CSS -->
<link rel="stylesheet" href="{{ asset('/') }}assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.css" />

    <!-- Page CSS -->
    <link rel="stylesheet" href="{{ asset('/') }}assets/vendor/css/pages/page-auth.css" />
        <!-- Styles -->
        {{-- <style>
            /*! normalize.css v8.0.1 | MIT License | github.com/necolas/normalize.css */html{line-height:1.15;-webkit-text-size-adjust:100%}body{margin:0}a{background-color:white}[hidden]{display:none}html{font-family:system-ui,-apple-system,BlinkMacSystemFont,Segoe UI,Roboto,Helvetica Neue,Arial,Noto Sans,sans-serif,Apple Color Emoji,Segoe UI Emoji,Segoe UI Symbol,Noto Color Emoji;line-height:1.5}*,:after,:before{box-sizing:border-box;border:0 solid #e2e8f0}a{color:inherit;text-decoration:inherit}svg,video{display:block;vertical-align:middle}video{max-width:100%;height:auto}.bg-white{--bg-opacity:1;background-color:#fff;background-color:rgba(255,255,255,var(--bg-opacity))}.bg-gray-100{--bg-opacity:1;background-color:#f7fafc;background-color:rgba(247,250,252,var(--bg-opacity))}.border-gray-200{--border-opacity:1;border-color:#edf2f7;border-color:rgba(237,242,247,var(--border-opacity))}.border-t{border-top-width:1px}.flex{display:flex}.grid{display:grid}.hidden{display:none}.items-center{align-items:center}.justify-center{justify-content:center}.font-semibold{font-weight:600}.h-5{height:1.25rem}.h-8{height:2rem}.h-16{height:4rem}.text-sm{font-size:.875rem}.text-lg{font-size:1.125rem}.leading-7{line-height:1.75rem}.mx-auto{margin-left:auto;margin-right:auto}.ml-1{margin-left:.25rem}.mt-2{margin-top:.5rem}.mr-2{margin-right:.5rem}.ml-2{margin-left:.5rem}.mt-4{margin-top:1rem}.ml-4{margin-left:1rem}.mt-8{margin-top:2rem}.ml-12{margin-left:3rem}.-mt-px{margin-top:-1px}.max-w-6xl{max-width:72rem}.min-h-screen{min-height:100vh}.overflow-hidden{overflow:hidden}.p-6{padding:1.5rem}.py-4{padding-top:1rem;padding-bottom:1rem}.px-6{padding-left:1.5rem;padding-right:1.5rem}.pt-8{padding-top:2rem}.fixed{position:fixed}.relative{position:relative}.top-0{top:0}.right-0{right:0}.shadow{box-shadow:0 1px 3px 0 rgba(0,0,0,.1),0 1px 2px 0 rgba(0,0,0,.06)}.text-center{text-align:center}.text-gray-200{--text-opacity:1;color:#edf2f7;color:rgba(237,242,247,var(--text-opacity))}.text-gray-300{--text-opacity:1;color:#e2e8f0;color:rgba(226,232,240,var(--text-opacity))}.text-gray-400{--text-opacity:1;color:#cbd5e0;color:rgba(203,213,224,var(--text-opacity))}.text-gray-500{--text-opacity:1;color:#a0aec0;color:rgba(160,174,192,var(--text-opacity))}.text-gray-600{--text-opacity:1;color:#718096;color:rgba(113,128,150,var(--text-opacity))}.text-gray-700{--text-opacity:1;color:#4a5568;color:rgba(74,85,104,var(--text-opacity))}.text-gray-900{--text-opacity:1;color:#1a202c;color:rgba(26,32,44,var(--text-opacity))}.underline{text-decoration:underline}.antialiased{-webkit-font-smoothing:antialiased;-moz-osx-font-smoothing:grayscale}.w-5{width:1.25rem}.w-8{width:2rem}.w-auto{width:auto}.grid-cols-1{grid-template-columns:repeat(1,minmax(0,1fr))}@media (min-width:640px){.sm\:rounded-lg{border-radius:.5rem}.sm\:block{display:block}.sm\:items-center{align-items:center}.sm\:justify-start{justify-content:flex-start}.sm\:justify-between{justify-content:space-between}.sm\:h-20{height:5rem}.sm\:ml-0{margin-left:0}.sm\:px-6{padding-left:1.5rem;padding-right:1.5rem}.sm\:pt-0{padding-top:0}.sm\:text-left{text-align:left}.sm\:text-right{text-align:right}}@media (min-width:768px){.md\:border-t-0{border-top-width:0}.md\:border-l{border-left-width:1px}.md\:grid-cols-2{grid-template-columns:repeat(2,minmax(0,1fr))}}@media (min-width:1024px){.lg\:px-8{padding-left:2rem;padding-right:2rem}}@media (prefers-color-scheme:dark){.dark\:bg-gray-800{--bg-opacity:1;background-color:#2d3748;background-color:rgba(45,55,72,var(--bg-opacity))}.dark\:bg-gray-900{--bg-opacity:1;background-color:#1a202c;background-color:rgba(26,32,44,var(--bg-opacity))}.dark\:border-gray-700{--border-opacity:1;border-color:#4a5568;border-color:rgba(74,85,104,var(--border-opacity))}.dark\:text-white{--text-opacity:1;color:#fff;color:rgba(255,255,255,var(--text-opacity))}.dark\:text-gray-400{--text-opacity:1;color:#cbd5e0;color:rgba(203,213,224,var(--text-opacity))}.dark\:text-gray-500{--tw-text-opacity:1;color:#6b7280;color:rgba(107,114,128,var(--tw-text-opacity))}}
        </style> --}}

        <style>
            body {
                font-family: 'Nunito', sans-serif;
            }
            .hero-card-img {
                min-height: 260px;
                background: linear-gradient(135deg, rgba(105,108,255,0.9), rgba(107,208,255,0.7));
                border-radius: 24px;
            }
            .hero-card {
                min-height: 100%;
            }
            .info-box {
                background: #f8f9ff;
            }
            .room-card {
                min-height: 180px;
                background-size: cover;
                background-position: center;
                border-radius: 24px 24px 0 0;
            }
            .room-card-1 {
                background: linear-gradient(135deg, rgba(105,108,255,0.9), rgba(107,208,255,0.75));
            }
            .room-card-2 {
                background: linear-gradient(135deg, rgba(255,128,0,0.85), rgba(255,204,128,0.75));
            }
            .room-card-3 {
                background: linear-gradient(135deg, rgba(0,150,136,0.85), rgba(128,216,208,0.75));
            }
            @media (max-width: 767px) {
                .hero-card-img {
                    min-height: 220px;
                }
            }
        </style>
    </head>
    <body class="antialiased">
        <div class="container-xxl py-5">
            <div class="row align-items-center mb-5">
                <div class="col-md-6">
                    <span class="badge bg-primary mb-3">Sistem Pemesanan Ruangan</span>
                    <h1 class="display-5 fw-bold">Kelola Pemesanan Ruang dengan Cepat</h1>
                    <p class="lead text-muted">Aplikasi ini membantu mahasiswa, dosen, dan staf untuk memesan ruang rapat, presentasi, atau studi secara online. Pilih ruang, jadwalkan, lalu pantau pemesanan dari satu tempat.</p>
                    <div class="d-flex gap-3 flex-wrap">
                        @guest
                        <a href="{{ route('login') }}" class="btn btn-primary btn-lg">Login</a>
                        <a href="{{ route('register') }}" class="btn btn-outline-primary btn-lg">Register</a>
                        @else
                        <a href="{{ route('dashboard') }}" class="btn btn-primary btn-lg">Dashboard</a>
                        <a href="{{ route('view-room') }}" class="btn btn-outline-primary btn-lg">Daftar Ruangan</a>
                        @endguest
                    </div>
                    <div class="mt-4">
                        <div class="d-flex gap-4 flex-wrap">
                            <div>
                                <h5 class="mb-1">{{ $rooms->count() }}</h5>
                                <p class="text-muted mb-0">Ruang tersedia</p>
                            </div>
                            <div>
                                <h5 class="mb-1">{{ $rooms->where('capacity', '>=', 10)->count() }}</h5>
                                <p class="text-muted mb-0">Ruang besar</p>
                            </div>
                            <div>
                                <h5 class="mb-1">{{ $rooms->where('status', 'able')->count() }}</h5>
                                <p class="text-muted mb-0">Ruang aktif</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    @php
                        $heroRoom = $rooms->first();
                        $heroPhoto = null;
                        if ($heroRoom && !empty($heroRoom->photo)) {
                            $heroPhoto = str_starts_with($heroRoom->photo, 'storage/') ? asset($heroRoom->photo) : asset('storage/' . $heroRoom->photo);
                        }
                    @endphp
                    <div class="hero-card p-4 rounded-4 shadow-sm bg-white">
                        <div class="hero-card-img rounded-4 mb-4" style="{{ $heroPhoto ? 'background-image: url(' . $heroPhoto . ');' : '' }}"></div>
                        <div class="row gy-3">
                            @foreach($rooms->take(4) as $room)
                                <div class="col-6">
                                    <div class="info-box p-3 rounded-3 border">
                                        <h6 class="mb-1">{{ $room->name }}</h6>
                                        <small class="text-muted">{{ $room->capacity }} kapasitas</small>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>

            <div class="row mb-4">
                <div class="col-12 text-center">
                    <h2 class="fw-bold">Daftar Ruangan Terpopuler</h2>
                    <p class="text-muted">Pilih ruang yang sesuai dengan kebutuhan acara, presentasi, atau diskusi tim.</p>
                </div>
            </div>

            <div class="row g-4">
                @forelse($rooms as $room)
                    <div class="col-md-4">
                        <div class="card h-100 shadow-sm overflow-hidden border-0">
                            @if(!empty($room->photo))
                                @php
                                    $photoUrl = str_starts_with($room->photo, 'storage/') ? asset($room->photo) : asset('storage/' . $room->photo);
                                @endphp
                                <img src="{{ $photoUrl }}" class="card-img-top" style="height: 180px; object-fit: cover;" alt="Foto {{ $room->name }}">
                            @else
                                <div class="card-img-top room-card bg-secondary"></div>
                            @endif
                            <div class="card-body">
                                <span class="badge {{ $room->status == 'able' ? 'bg-success' : 'bg-secondary' }} mb-2">{{ $room->status == 'able' ? 'Tersedia' : 'Tidak tersedia' }}</span>
                                <h5 class="card-title">{{ $room->name }}</h5>
                                <p class="card-text text-muted">{{ strlen($room->description) > 100 ? substr($room->description, 0, 100) . '...' : $room->description }}</p>
                            </div>
                            <div class="card-footer bg-white border-top-0">
                                <a href="{{ route('view-room') }}" class="btn btn-sm btn-primary">Lihat Daftar Ruangan</a>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-12">
                        <div class="alert alert-warning">Belum ada ruangan tersedia saat ini.</div>
                    </div>
                @endforelse
            </div>
        </div>
    </body>
</html>
