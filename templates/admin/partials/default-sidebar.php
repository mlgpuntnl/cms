
<aside class="sidebar">
    <div class="logo">
        LOGO
    </div>
    <nav id="sidebar-menu">
        <ul>
            <li class="<?= ($currentPage === 'page') ? 'active' : '' ?>">
                <a href="/admin/">
                    <ion-icon name="document-text" class="icon"></ion-icon>
                    <span class="label">
                        Pages
                    </span>
                </a>
            </li>
            <li class="<?= ($currentPage === 'news') ? 'active' : '' ?>">
                <a href="/admin/">
                    <ion-icon name="newspaper" class="icon"></ion-icon>
                    <span class="label">
                        News
                    </span>
                </a>
            </li>
            <li class="<?= ($currentPage === 'shop') ? 'active' : '' ?>">
                <a href="/admin/">
                    <ion-icon name="cart" class="icon"></ion-icon>
                    <span class="label">
                        Shop
                    </span>
                </a>
            </li>
            <li class="<?= ($currentPage === 'users') ? 'active' : '' ?>">
                <a href="/admin/">
                    <ion-icon name="people" class="icon"></ion-icon>
                    <span class="label">
                        Users
                    </span>
                </a>
            </li>
            <li class="<?= ($currentPage === 'settings') ? 'active' : '' ?>">
                <a href="/admin/">
                    <ion-icon name="settings" class="icon"></ion-icon>
                    <span class="label">
                        Settings
                    </span>
                </a>
            </li>
        </ul>
    </nav>
</aside>