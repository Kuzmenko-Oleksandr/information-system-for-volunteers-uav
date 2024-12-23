<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <div class="sidebar">
        <ul class="pt-3 nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu"
            data-accordion="false">
            <li>
                <a href="{{ route('volunteer.main.index') }}" class="nav-link">
                    <i class="nav-icon fas fa-home"></i>
                    <p>Головна</p>
                </a>
            </li>
            <li>
                <a href="{{ route('volunteer.post.index') }}" class="nav-link">
                    <i class="nav-icon far fa-clipboard"></i>
                    <p>Мої Пости</p>
                </a>
            </li>
            <li>
                <a href="{{ route('volunteer.marker.index') }}" class="nav-link">
                    <i class="nav-icon fa fa-map"></i>
                    <p>Мої маркери</p>
                </a>
            </li>
            <li>
                <a href="{{ route('personal.like.index') }}" class="nav-link">
                    <i class="nav-icon far fa-heart"></i>
                    <p>
                        Мої лайки
                    </p>
                </a>
            </li>
            <li>
                <a href="{{ route('personal.comment.index') }}" class="nav-link">
                    <i class="nav-icon far fa-comment"></i>
                    <p>
                        Мої коментарі
                    </p>
                </a>
            </li>
            <li>
                <a href="{{ route('messages.index') }}" class="nav-link">
                    <i class="nav-icon fas fa-comments"></i>
                    <p>
                        Мої повідомлення
                    </p>
                </a>
            </li>
        </ul>
    </div>
</aside>
