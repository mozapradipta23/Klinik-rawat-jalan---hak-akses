@extends('layouts.app')

@section('title', 'Informasi Dokter dan Medis')
@section('lebar', 'lebar')

@section('content')
<style>
    /* Notifikasi (toast) */
    .toast-wrap {
        position: fixed; top: 16px; right: 16px; z-index: 2000;
        display: flex; flex-direction: column; gap: 10px;
    }
    .toast {
        display: flex; align-items: center; gap: 10px;
        min-width: 260px; max-width: 380px; padding: 12px 14px;
        background: #fff; border-left: 5px solid #1e6b34; border-radius: 6px;
        box-shadow: 0 4px 16px rgba(0,0,0,.2); font-size: 14px;
        animation: toast-masuk .25s ease-out;
    }
    .toast.error { border-left-color: #c0392b; }
    .toast-ikon {
        flex: none; width: 24px; height: 24px; line-height: 24px; text-align: center;
        border-radius: 50%; background: #e6f4ea; color: #1e6b34; font-weight: bold;
    }
    .toast.error .toast-ikon { background: #fde8e8; color: #c0392b; }
    .toast-teks { flex: 1; }
    .toast-tutup { border: 0; background: none; font-size: 18px; cursor: pointer; color: #888; }
    .toast.keluar { opacity: 0; transform: translateX(20px); transition: all .3s; }
    @keyframes toast-masuk { from { opacity: 0; transform: translateX(20px); } to { opacity: 1; transform: none; } }
</style>

{{-- NOTIFIKASI --}}
<div class="toast-wrap">
    @if (session('success'))
        <div class="toast">
            <span class="toast-ikon">&#10003;</span>
            <span class="toast-teks">{{ session('success') }}</span>
            <button type="button" class="toast-tutup" aria-label="Tutup">&times;</button>
        </div>
    @endif

    @if (session('error'))
        <div class="toast error">
            <span class="toast-ikon">!</span>
            <span class="toast-teks">{{ session('error') }}</span>
            <button type="button" class="toast-tutup" aria-label="Tutup">&times;</button>
        </div>
    @endif
</div>

<div class="header-halaman">
    <div>
        <h2>Informasi Dokter dan Medis</h2>
        <p class="teks-redup">Data master dokter Klinik Sehat</p>
    </div>

    @if (auth()->user()->isAdmin())
    <a href="{{ route('dokter.create') }}" class="btn btn-primary">+ Tambah Dokter</a>
    @endif
</div>

<div class="card">
    <div class="tabel-wrap">
        <table>
            <thead>
                <tr>
                    <th>No.</th>
                    <th>Nama Dokter</th>
                    <th>Nomor SIP</th>
                    <th>Spesialisasi</th>
                    <th>ID Poli</th>
                    <th>Kontak</th>
                    <th>Email</th>
                    <th>Aksi</th>
                </tr>
            </thead>

            <tbody>
            @forelse ($dokters as $dokter)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $dokter->nama_dokter }}</td>
                    <td>{{ $dokter->no_sip }}</td>
                    <td>{{ $dokter->spesialisasi }}</td>
                    <td>{{ $dokter->id_poli }}</td>
                    <td>{{ $dokter->kontak }}</td>
                    <td>{{ $dokter->email }}</td>
                    <td>
                        @if (auth()->user()->isAdmin())
                        <div class="aksi">
                            <a class="btn btn-sm btn-edit"
                               href="{{ route('dokter.edit', $dokter) }}">Edit</a>

                            <button type="button" class="btn btn-sm btn-hapus btn-buka-hapus"
                                    data-url="{{ route('dokter.destroy', $dokter) }}"
                                    data-nama="{{ $dokter->nama_dokter }}">
                                Hapus
                            </button>
                        </div>
                        @else
                            <span class="teks-redup">-</span>
                        @endif
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="8" class="tengah">Belum ada data dokter.</td>
                </tr>
            @endforelse
            </tbody>
        </table>
    </div>
</div>

@if (auth()->user()->isAdmin())
{{-- POPUP KONFIRMASI HAPUS (atribut hidden: tetap tersembunyi walau CSS belum termuat) --}}
<div class="modal-overlay" id="modalHapus" hidden>
    <div class="modal-box" role="dialog" aria-modal="true" aria-labelledby="judulHapus">
        <div class="modal-ikon">!</div>
        <h3 id="judulHapus">Hapus Data Dokter?</h3>
        <p>Data <strong id="namaHapus"></strong> akan dihapus permanen<br>dan tidak bisa dikembalikan.</p>

        <form method="POST" id="formHapus" class="modal-aksi">
            @csrf
            @method('DELETE')
            <button type="button" class="btn btn-secondary" id="batalHapus">Batal</button>
            <button type="submit" class="btn btn-hapus" id="yaHapus">Ya, Hapus</button>
        </form>
    </div>
</div>
@endif
@endsection

@push('scripts')
<script>
    // --- Notifikasi: hilang otomatis setelah 4 detik, atau klik x ---
    document.querySelectorAll(".toast").forEach(function (toast) {
        function tutup() {
            toast.classList.add("keluar");
            setTimeout(function () { toast.remove(); }, 300);
        }
        toast.querySelector(".toast-tutup").addEventListener("click", tutup);
        setTimeout(tutup, 4000);
    });

    // --- Popup konfirmasi hapus ---
    const modal     = document.getElementById("modalHapus");
    if (modal) {
        const formHapus = document.getElementById("formHapus");
        const namaTeks  = document.getElementById("namaHapus");
        const tombolYa  = document.getElementById("yaHapus");

        function bukaModal() {
            modal.hidden = false;
            modal.classList.add("tampil");
        }

        function tutupModal() {
            modal.classList.remove("tampil");
            modal.hidden = true;
        }

        document.querySelectorAll(".btn-buka-hapus").forEach(function (tombol) {
            tombol.addEventListener("click", function () {
                formHapus.action     = tombol.dataset.url;
                namaTeks.textContent = tombol.dataset.nama;
                tombolYa.disabled    = false;
                bukaModal();
            });
        });

        // Cegah klik ganda saat menghapus
        formHapus.addEventListener("submit", function () {
            tombolYa.disabled = true;
            tombolYa.textContent = "Menghapus...";
        });

        document.getElementById("batalHapus").addEventListener("click", tutupModal);
        modal.addEventListener("click", function (e) {
            if (e.target === modal) tutupModal();
        });
        document.addEventListener("keydown", function (e) {
            if (e.key === "Escape") tutupModal();
        });
    }
</script>
@endpush