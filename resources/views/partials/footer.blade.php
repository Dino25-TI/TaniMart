<footer class="tm-footer">
    <div class="tm-footer-inner">
        <div class="tm-footer-brand">
            <span>🌱</span>
            <strong>TaniMart</strong>
            <p>Marketplace pertanian modern untuk petani dan pecinta tanaman Indonesia.</p>
        </div>
        <div class="tm-footer-links">
            <div>
                <h4>Belanja</h4>
                <a href="/#produk">Produk Pasar</a>
                <a href="/#kategori">Kategori</a>
                <a href="/keranjang">Keranjang</a>
            </div>
            <div>
                <h4>Layanan</h4>
                <a href="/konsultasi">Konsultasi AI</a>
                @auth
                <a href="{{ route('products.create') }}">Jual Produk</a>
                <a href="{{ route('chat.index') }}">Obrolan Saya</a>
                @endauth
            </div>
            <div>
                <h4>Akun</h4>
                @auth
                <a href="{{ route('profil') }}">Profil Saya</a>
                <a href="{{ route('products.my') }}">Produk Saya</a>
                <a href="{{ route('pesanan.riwayat') }}">Riwayat Pesanan</a>
                @else
                <a href="{{ route('login') }}">Masuk</a>
                <a href="{{ route('register') }}">Daftar Akun</a>
                @endauth
            </div>
        </div>
    </div>
    <div class="tm-footer-bottom">
        <p>© {{ date('Y') }} TaniMart. Tumbuh bersama, panen bersama. 🌾</p>
        <div class="tm-footer-socials">
            <span>🌱 Dibuat dengan cinta untuk petani Indonesia</span>
        </div>
    </div>
</footer>
