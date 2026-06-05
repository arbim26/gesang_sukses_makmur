<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Sistem Invoice') — InvoiceApp</title>
    <link href="https://fonts.googleapis.com/css2?family=Instrument+Serif:ital@0;1&family=DM+Sans:wght@300;400;500;600&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/dist/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <style>
        :root {
            --sidebar-w: 240px;
            --brand:     #1a1a2e;
            --accent:    #4f46e5;
            --accent-lt: #eef2ff;
            --surface:   #f8f7f4;
            --border:    #e5e3dc;
            --text-muted:#6b7280;
        }
        * { box-sizing: border-box; }
        body {
            font-family: 'DM Sans', sans-serif;
            background: var(--surface);
            color: #1a1a2e;
            min-height: 100vh;
        }
        /* ── Sidebar ── */
        .sidebar {
            width: var(--sidebar-w);
            background: var(--brand);
            min-height: 100vh;
            position: fixed;
            top: 0; left: 0;
            display: flex;
            flex-direction: column;
            z-index: 100;
        }
        .sidebar-brand {
            padding: 1.5rem 1.25rem 1rem;
            border-bottom: 1px solid rgba(255,255,255,.08);
        }
        .sidebar-brand span {
            font-family: 'Instrument Serif', serif;
            font-size: 1.35rem;
            color: #fff;
            letter-spacing: -.3px;
        }
        .sidebar-brand small {
            display: block;
            font-size: .7rem;
            color: rgba(255,255,255,.4);
            text-transform: uppercase;
            letter-spacing: 1.5px;
            margin-top: 2px;
        }
        .nav-section {
            padding: .75rem 1rem .25rem;
            font-size: .65rem;
            text-transform: uppercase;
            letter-spacing: 1.5px;
            color: rgba(255,255,255,.3);
        }
        .sidebar .nav-link {
            color: rgba(255,255,255,.65);
            border-radius: 8px;
            margin: 1px 8px;
            padding: .5rem .85rem;
            font-size: .875rem;
            font-weight: 400;
            display: flex;
            align-items: center;
            gap: 10px;
            transition: background .15s, color .15s;
        }
        .sidebar .nav-link:hover,
        .sidebar .nav-link.active {
            background: rgba(255,255,255,.1);
            color: #fff;
        }
        .sidebar .nav-link.active {
            background: var(--accent);
            color: #fff;
        }
        .sidebar .nav-link i { font-size: 1rem; flex-shrink: 0; }
        /* ── Main ── */
        .main-wrap {
            margin-left: var(--sidebar-w);
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }
        .topbar {
            background: #fff;
            border-bottom: 1px solid var(--border);
            padding: .75rem 1.75rem;
            display: flex;
            align-items: center;
            justify-content: space-between;
            position: sticky;
            top: 0;
            z-index: 50;
        }
        .topbar-title {
            font-family: 'Instrument Serif', serif;
            font-size: 1.15rem;
            color: var(--brand);
        }
        .topbar-actions { display: flex; gap: 8px; align-items: center; }
        
        /* ── SINGLE PAGE CONTENT (GAP TERHAPUS) ── */
        .page-content {
            padding: 1.75rem;
            flex: 1;
            background: var(--surface);
        }
        
        /* Tidak ada lagi duplikasi .page-content, hanya SATU wadah utama untuk flash + konten */
        
        /* ── Cards ── */
        .card {
            border: 1px solid var(--border);
            border-radius: 12px;
            background: #fff;
            box-shadow: none;
        }
        .card-header {
            background: transparent;
            border-bottom: 1px solid var(--border);
            padding: 1rem 1.25rem;
            font-weight: 500;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }
        /* ── Table ── */
        .table thead th {
            background: var(--surface);
            font-size: .75rem;
            text-transform: uppercase;
            letter-spacing: .8px;
            color: var(--text-muted);
            border-bottom: 1px solid var(--border);
            font-weight: 500;
            padding: .65rem 1rem;
        }
        .table td { padding: .65rem 1rem; vertical-align: middle; font-size: .875rem; }
        .table tbody tr:hover { background: #fafaf9; }
        /* ── Buttons ── */
        .btn-accent {
            background: var(--accent);
            color: #fff;
            border: none;
            border-radius: 8px;
            font-size: .8rem;
            font-weight: 500;
            padding: .45rem 1rem;
        }
        .btn-accent:hover { background: #4338ca; color: #fff; }
        .btn-sm { font-size: .75rem; padding: .3rem .7rem; border-radius: 6px; }
        /* ── Badge status ── */
        .badge-pill {
            font-size: .7rem;
            font-weight: 500;
            padding: .3em .75em;
            border-radius: 999px;
        }
        /* ── Form ── */
        .form-label { font-size: .8rem; font-weight: 500; color: var(--brand); margin-bottom: .3rem; }
        .form-control, .form-select {
            border: 1px solid var(--border);
            border-radius: 8px;
            font-size: .875rem;
            padding: .5rem .85rem;
        }
        .form-control:focus, .form-select:focus {
            border-color: var(--accent);
            box-shadow: 0 0 0 3px rgba(79,70,229,.12);
        }
        /* ── Alert styling (mulus, tanpa margin berlebih) ── */
        .alert {
            border-radius: 10px;
            font-size: .875rem;
            border: none;
            margin-bottom: 1rem;
            box-shadow: 0 1px 2px rgba(0,0,0,0.03);
            transition: opacity 0.25s ease;
        }
        /* Animasi fade-out untuk alert yang akan dihapus */
        .alert-fade-out {
            opacity: 0 !important;
            transition: opacity 0.25s ease !important;
        }
        /* ── Responsive ── */
        @media (max-width: 768px) {
            .sidebar { transform: translateX(-100%); }
            .main-wrap { margin-left: 0; }
        }
    </style>
</head>
<body>

{{-- ──── SIDEBAR (TIDAK BERUBAH) ──────────────────────────────── --}}
<nav class="sidebar">
    <div class="sidebar-brand">
        <span>InvoiceApp</span>
        <small>Sistem Manajemen Invoice</small>
    </div>

    <div class="mt-2">
        <p class="nav-section">Menu Utama</p>
        <a href="{{ route('dashboard') }}"
           class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}">
            <i class="bi bi-speedometer2"></i> Dashboard
        </a>

        <p class="nav-section">Master Data</p>
        <a href="{{ route('pegawai.index') }}"
           class="nav-link {{ request()->routeIs('pegawai.*') ? 'active' : '' }}">
            <i class="bi bi-person-badge"></i> Pegawai
        </a>
        <a href="{{ route('customer.index') }}"
           class="nav-link {{ request()->routeIs('customer.*') ? 'active' : '' }}">
            <i class="bi bi-people"></i> Customer
        </a>
        <a href="{{ route('barang.index') }}"
           class="nav-link {{ request()->routeIs('barang.*') ? 'active' : '' }}">
            <i class="bi bi-box-seam"></i> Barang
        </a>
        <a href="{{ route('rekening.index') }}"
           class="nav-link {{ request()->routeIs('rekening.*') ? 'active' : '' }}">
            <i class="bi bi-bank"></i> Rekening
        </a>

        <p class="nav-section">Transaksi</p>
        <a href="{{ route('purchase-order.index') }}"
           class="nav-link {{ request()->routeIs('purchase-order.*') ? 'active' : '' }}">
            <i class="bi bi-file-earmark-text"></i> Purchase Order
        </a>
        <a href="{{ route('invoice.index') }}"
           class="nav-link {{ request()->routeIs('invoice.*') ? 'active' : '' }}">
            <i class="bi bi-receipt"></i> Invoice
        </a>
        <!-- <a href="{{ route('detail-invoice.index') }}" class="nav-link"> ... </a> -->
        <a href="{{ route('surat-jalan.index') }}"
           class="nav-link {{ request()->routeIs('surat-jalan.*') ? 'active' : '' }}">
            <i class="bi bi-truck"></i> Surat Jalan
        </a>
    </div>
</nav>

{{-- ──── MAIN WRAPPER ──────────────────────────── --}}
<div class="main-wrap">
    {{-- Topbar --}}
    <header class="topbar">
        <span class="topbar-title">@yield('page-title', 'Dashboard')</span>
        <div class="topbar-actions">
            <span style="font-size:.8rem; color:var(--text-muted);">
                <i class="bi bi-person-circle me-1"></i>
                {{ auth('pegawai')->user()->Nama_Pegawai ?? 'Admin' }}
            </span>
            <form action="{{ route('logout') }}" method="POST" class="d-inline">
                @csrf
                <button type="submit"
                        class="btn btn-sm btn-outline-secondary"
                        style="font-size:.75rem;border-color:var(--border);color:var(--text-muted);">
                    <i class="bi bi-box-arrow-right me-1"></i> Keluar
                </button>
            </form>
        </div>
    </header>

    {{-- 
        ============================================================
        GAP DIHAPUSKAN: Sebelumnya ada DIV terpisah untuk flash + 
        <main class="page-content"> yang menyebabkan padding ganda 
        dan gap tak perlu. Sekarang SEMUA (alert + konten halaman)
        disatukan dalam SATU wadah utama .page-content.
        Tidak ada lagi duplikasi atau elemen kosong.
        ============================================================
    --}}
    <main class="page-content">
        {{-- Alert Messages (success, error, validation) akan otomatis hilang setelah 5 detik --}}
        @if(session('success'))
            <div class="alert alert-success d-flex align-items-center gap-2 alert-dismissible-auto" role="alert">
                <i class="bi bi-check-circle-fill"></i>
                {{ session('success') }}
            </div>
        @endif

        @if(session('error'))
            <div class="alert alert-danger d-flex align-items-center gap-2 alert-dismissible-auto" role="alert">
                <i class="bi bi-x-circle-fill"></i>
                {{ session('error') }}
            </div>
        @endif

        @if($errors->any())
            <div class="alert alert-danger alert-dismissible-auto" role="alert">
                <ul class="mb-0 ps-3" style="font-size:.85rem;">
                    @foreach($errors->all() as $err)
                        <li>{{ $err }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        {{-- Dynamic content setiap halaman --}}
        @yield('content')
    </main>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/4.4.0/chart.umd.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>    

<script>
    // ─────────────────────────────────────────────────────────────────
    // FITUR ALERT MUNCUL 5 DETIK LALU MENGHILANG (OTOMATIS)
    // Semua alert dengan class .alert-dismissible-auto akan dihapus setelah 5 detik
    // Disertai efek fade-out halus, gap hilang sempurna karena elemen benar2 dihapus dari DOM.
    // ─────────────────────────────────────────────────────────────────
    (function() {
        // Fungsi untuk menghapus alert dengan transisi
        function dismissAlertWithDelay(alertElement, delayMs = 5000) {
            if (!alertElement) return;
            // Simpan timer ID untuk menghindari duplikasi jika sudah ada timeout sebelumnya
            if (alertElement._autoDismissTimer) return;
            
            alertElement._autoDismissTimer = setTimeout(() => {
                // Tambahkan kelas fade-out (biar halus)
                alertElement.classList.add('alert-fade-out');
                // Setelah transisi selesai, hapus dari DOM
                const removeHandler = () => {
                    if (alertElement && alertElement.remove) {
                        alertElement.remove();
                    }
                    alertElement.removeEventListener('transitionend', removeHandler);
                };
                alertElement.addEventListener('transitionend', removeHandler, { once: true });
                // Fallback jika transitionend tidak terpicu (misal tidak ada transition)
                setTimeout(() => {
                    if (alertElement && alertElement.isConnected) {
                        alertElement.remove();
                    }
                }, 300);
            }, delayMs);
        }

        // Jalankan saat DOM siap, dan juga jika ada konten yang di-render setelahnya (mutation observer opsional, tapi untuk halaman standar cukup DOMContentLoaded)
        document.addEventListener('DOMContentLoaded', function() {
            const autoAlerts = document.querySelectorAll('.alert-dismissible-auto');
            autoAlerts.forEach(alert => {
                dismissAlertWithDelay(alert, 5000);
            });
        });

        // Jika ada alert yang ditambahkan secara dinamis setelah load (misal dari partial atau komponen livewire? 
        // tapi framework hanya laravel biasa. Tetap aman: gunakan MutationObserver untuk menangkap alert baru 
        // yang mungkin dihasilkan oleh javascript lain? (tidak wajib tapi sangat clean untuk jaga-jaga)
        // Ini membuat setiap alert dengan class .alert-dismissible-auto otomatis hilang meskipun ditambahkan setelah halaman siap.
        // Pastikan tidak double timers.
        const observer = new MutationObserver((mutations) => {
            mutations.forEach((mutation) => {
                mutation.addedNodes.forEach((node) => {
                    if (node.nodeType === 1) { // element node
                        // Jika node itu sendiri memiliki class alert-dismissible-auto
                        if (node.classList && node.classList.contains('alert-dismissible-auto')) {
                            if (!node._autoDismissTimer) dismissAlertWithDelay(node, 5000);
                        }
                        // Cari di dalam node yang ditambahkan jika ada alert di dalamnya
                        if (node.querySelectorAll) {
                            const innerAlerts = node.querySelectorAll('.alert-dismissible-auto');
                            innerAlerts.forEach(alert => {
                                if (!alert._autoDismissTimer) dismissAlertWithDelay(alert, 5000);
                            });
                        }
                    }
                });
            });
        });
        observer.observe(document.body, { childList: true, subtree: true });
    })();
</script>


@stack('scripts')
</body>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</html>