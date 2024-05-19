<div id="m_ver_menu" class="m-aside-menu  m-aside-menu--skin-dark m-aside-menu--submenu-skin-dark " m-menu-vertical="1" m-menu-scrollable="1" m-menu-dropdown-timeout="500" style="position: relative;">
    <ul class="m-menu__nav  m-menu__nav--dropdown-submenu-arrow ">
        <li class="m-menu__item" aria-haspopup="true">
            <a href="{{route('dashboard.index')}}" class="m-menu__link ">
                <i class="m-menu__link-icon flaticon-line-graph"></i>
                <span class="m-menu__link-title">
                    <span class="m-menu__link-wrap">
                        <span class="m-menu__link-text">Dashboard</span>
                        <span class="m-menu__link-badge">
                        </span>
                    </span>
                </span>
            </a>
        </li>
        <li class="m-menu__section ">
            <h4 class="m-menu__section-text">Koperasi</h4>
            <i class="m-menu__section-icon flaticon-more-v2"></i>
        </li>
        <li class="m-menu__item  m-menu__item--submenu" aria-haspopup="true">
            <a href="{{route('sewa.index')}}" class="m-menu__link m-menu__toggle">
                <i class="m-menu__link-icon flaticon-layers"></i>
                <span class="m-menu__link-text">Sewa</span>
            </a>
        </li>
        <li class="m-menu__item  m-menu__item--submenu" aria-haspopup="true">
            <a href="{{route('histori_sewa.index')}}" class="m-menu__link m-menu__toggle">
                <i class="m-menu__link-icon flaticon-share"></i>
                <span class="m-menu__link-text">Histori Sewa</span>
            </a>
        </li>
        <li class="m-menu__item  m-menu__item--submenu" aria-haspopup="true">
            <a href="{{route('karyawan.index')}}" class="m-menu__link m-menu__toggle">
                <i class="m-menu__link-icon flaticon-user-settings"></i>
                <span class="m-menu__link-text">Karyawan</span>
            </a>
        </li>
        <!-- <li class="m-menu__item  m-menu__item--submenu" aria-haspopup="true">
            <a href="{{route('gaji.index')}}" class="m-menu__link m-menu__toggle">
                <i class="m-menu__link-icon flaticon-interface-1"></i>
                <span class="m-menu__link-text">Gaji Karyawan</span>
            </a>
        </li> -->
        <li class="m-menu__item  m-menu__item--submenu" aria-haspopup="true">
            <a href="{{route('stok_barang.index')}}" class="m-menu__link m-menu__toggle">
                <i class="m-menu__link-icon flaticon-interface-6"></i>
                <span class="m-menu__link-text">Barang</span>
            </a>
        </li>
        <li class="m-menu__item  m-menu__item--submenu" aria-haspopup="true">
            <a href="{{route('inventori.index')}}" class="m-menu__link m-menu__toggle">
                <i class="m-menu__link-icon flaticon-truck"></i>
                <span class="m-menu__link-text">Pembelian</span>
            </a>
        </li>
        <li class="m-menu__item  m-menu__item--submenu" aria-haspopup="true">
            <a href="{{route('penjualan.index')}}" class="m-menu__link m-menu__toggle">
                <i class="m-menu__link-icon flaticon-paper-plane"></i>
                <span class="m-menu__link-text">Transaksi</span>
            </a>
        </li>
        <li class="m-menu__item  m-menu__item--submenu" aria-haspopup="true">
            <a href="{{route('piutang.index')}}" class="m-menu__link m-menu__toggle">
                <i class="m-menu__link-icon flaticon-interface-1"></i>
                <span class="m-menu__link-text">Piutang</span>
            </a>
        </li>
        <li class="m-menu__item  m-menu__item--submenu" aria-haspopup="true">
            <a href="{{route('penjualan.detail')}}" class="m-menu__link m-menu__toggle">
                <i class="m-menu__link-icon flaticon-list-3"></i>
                <span class="m-menu__link-text">Penjualan</span>
            </a>
        </li>
        <li class="m-menu__section ">
            <h4 class="m-menu__section-text">Kantin</h4>
            <i class="m-menu__section-icon flaticon-more-v2"></i>
        </li>
        <li class="m-menu__item  m-menu__item--submenu" aria-haspopup="true">
            <a href="{{route('tenant.index')}}" class="m-menu__link m-menu__toggle">
                <i class="m-menu__link-icon flaticon-interface-7"></i>
                <span class="m-menu__link-text">Tenant</span>
            </a>
        </li>
        <li class="m-menu__item  m-menu__item--submenu" aria-haspopup="true">
            <a href="{{route('barcode.index')}}" class="m-menu__link m-menu__toggle">
                <i class="m-menu__link-icon flaticon-interface-8"></i>
                <span class="m-menu__link-text">Generate Barcode</span>
            </a>
        </li>
    </ul>
</div>
<script type="text/javascript">
var activeMenuItemURL = sessionStorage.getItem('activeMenuItemURL');
var menuItems = document.querySelectorAll('.m-menu__item');

    menuItems.forEach(function(menuItem) {
        menuItem.addEventListener('click', function(event) {
            event.preventDefault(); 
            menuItems.forEach(function(item) {
                item.classList.remove('m-menu__item--active');
            });
            this.classList.add('m-menu__item--active');
            var url = this.querySelector('a').getAttribute('href');
            
            sessionStorage.setItem('activeMenuItemURL', url);
            window.location.href = url;
        });
    });

    if (activeMenuItemURL) {
        var activeMenuItem = document.querySelector('.m-menu__item a[href="' + activeMenuItemURL + '"]').closest('.m-menu__item');
        if (activeMenuItem) {
            activeMenuItem.classList.add('m-menu__item--active');
        }
    }
</script>