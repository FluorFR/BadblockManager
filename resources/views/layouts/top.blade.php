<body>

<!-- Navigation Bar-->
<header id="topnav">
    <div class="topbar-main">
        <div class="container-fluid">
            <div class="logo">

                <a href="/" class="logo">
                    <img src="https://cdn.badblock.fr/images/serveur-minecraft.png" alt="" height="40"
                         class="logo-small">
                    <img src="https://cdn.badblock.fr/images/serveur-minecraft.png" alt="" height="40"
                         class="logo-large">
                </a>
            </div>

            <div class="menu-extras topbar-custom">

                <ul class="list-unstyled topbar-right-menu float-right mb-0">

                    <li class="menu-item">
                        <!-- Mobile menu toggle-->
                        <a class="navbar-toggle nav-link">
                            <div class="lines">
                                <span></span>
                                <span></span>
                                <span></span>
                            </div>
                        </a>
                        <!-- End mobile menu toggle-->
                    </li>
                    <li class="hide-phone">
                        <form class="app-search" action="/players" method="get">
                            <input name="name" type="text" placeholder="Search..."
                                   class="form-control">
                            <button type="submit"><i class="fa fa-search"></i></button>
                        </form>
                    </li>
                    <li>
                        <!-- Notification -->
                        <div class="notification-box">
                            <ul class="list-inline mb-0">
                                <li>
                                    <a href="javascript:void(0);" class="right-bar-toggle">
                                        <i class="mdi mdi-bell-outline noti-icon"></i>
                                    </a>

                                    @if (DB::table('notifications')->where('user_id', "=", Auth::user()->id)->where('active', '=', '1')->count() != 0)
                                        <div class="noti-dot">
                                            <span class="dot"></span>
                                            <span class="pulse"></span>
                                        </div>
                                    @endif

                                </li>
                            </ul>
                        </div>
                        <!-- End Notification bar -->
                    </li>

                    <li class="dropdown notification-list">
                        <a class="nav-link dropdown-toggle waves-effect waves-light nav-user"
                           aria-haspopup="false" aria-expanded="false">
                            <img src="https://cdn.badblock.fr/head/{{ Auth::user()->name}}/48.png" alt="user"
                                 class="rounded-circle">
                        </a>
                        <div class="dropdown-menu dropdown-menu-right profile-dropdown ">

                            <!-- item-->
                            <a href="/profil" class="dropdown-item notify-item">
                                <i class="ti-user m-r-5"></i> Mot de passe
                            </a>

                            <!-- item-->
                            <a href="javascript:void(0);" class="dropdown-item notify-item">
                                <i class="ti-settings m-r-5"></i> Settings
                            </a>

                            <!-- item-->
                            <a href="javascript:void(0);" class="dropdown-item notify-item">
                                <i class="ti-lock m-r-5"></i> Lock screen
                            </a>

                            <!-- item-->
                            <a href="javascript:void(0);" class="dropdown-item notify-item">
                                <i class="ti-power-off m-r-5"></i> Logout
                            </a>

                        </div>
                    </li>

                </ul>
            </div>
            <!-- end menu-extras -->

            <div class="clearfix"></div>

        </div> <!-- end container -->
    </div>
    <!-- end topbar-main -->

    <div class="navbar-custom">
        <div class="container-fluid">
            <div id="navigation">
                <!-- Navigation Menu-->
                <ul class="navigation-menu">
                    <li class="has-submenu">
                        <a href="/players"><i class="fa fa-search"></i> <span> Rechercher </span> </a>
                    </li>
                    <li class="has-submenu">
                        <a href="#"><i class="fa fa-user"></i><span> Profile </span> </a>
                        <ul class="submenu">
                            <li><a href="/profil" class="waves-effect"><i class="fas fa-setting"></i> Password</a></li>
                            <li><a href="/settings/sharex" class="waves-effect"><i class="fas fa-camera-retro"></i> ShareX </a></li>
                            <li><a href="/screen" class="waves-effect"><i class="fas fa-images"></i> Ma galerie</a></li>
                            <li><a href="/profil/file-uploader" class="waves-effect"><i class="fa fa-file"></i> Transférer un fichier </a> </li>
                            <li><a href="/profil/todolists" class="waves-effect"><i class="fa fa-list-ol"></i> Mes todolists </a></li>
                        </ul>
                    </li>
                    @can('gestion_index')
                        <li class="has-submenu">
                            <a href="#"><i class="fa fa-project-diagram"></i><span> Gestion </span> </a>
                            <ul class="submenu">
                                @can('gestion_forum')
                                    <li><a href="/section/forum" class="waves-effect"><i class="fab fa-pied-piper"></i>
                                            Forum</a></li>
                                @endcan
                                <li><a href="/section/preuves" class="waves-effect"><i class="fas fa-camera-retro"></i>
                                        Preuves</a></li>
                                <li><a href="/section/mod" class="waves-effect"><i class="fas fa-shield-alt"></i>
                                        Modération</a></li>
                                <li><a href="/section/connection" class="waves-effect"><i class="fa fa-eyes"></i> Temps
                                        de connection</a></li>
                                @can('gestion_build')
                                    <li><a href="/section/build" class="waves-effect"><i class="fas fa-cube"></i>
                                            Builders</a></li>
                                @endcan
                                @can('gestion_redac')
                                    <li><a href="/section/blog" class="waves-effect"><i class="fas fa-chart-bar"></i>
                                            Stats Articles</a></li>
                                @endcan
                                <li><a href="/section/url-shortener" class="waves-effect"><i
                                                class="fab fa-shirtsinbulk"></i> Raccourcisseur d'URL</a></li>
                                @can('gestion_index')
                                    <li><a href="/section/notifications"><i class="fas fa-concierge-bell"></i>
                                            Notifications</a></li>
                                    <li><a href="/section/avertissement-list"><i
                                                    class="fas fa-exclamation-triangle"></i> Avertissements</a></li>
                                @endcan
                                <li><a href="/section/paid" class="waves-effect"><i class="fa fa-bank"></i> Paies
                                        Sections</a></li>
                                <li><a href="/section/tfacheck" class="waves-effect"><i class="fas fa-lock"></i>
                                        Controle TFA</a></li>
                                <li><a href="/section/allstaff" class="waves-effect"><i class="fa fa-address-book"></i>
                                        Liste Staff</a></li>
                                <li><a href="/user" class="waves-effect"><i class="fa fa-address-book"></i> Utilisateur</a>
                                </li>
                                @can('gestion_index')
                                    <li><a href="/section/youtubers" class="waves-effect"><i class="fab fa-youtube"></i> Youtubers</a> </li>
                                @endcan
                                <li><a href="/role" class="waves-effect"><i class="fa fa-list-ol"></i> Groupes</a></li>
                                @can('todo_list_all')
                                    <li><a href="/section/todo-management" class="wave-effect"><i
                                                    class="fa fa-list-ol"></i> Todo-List</a></li>
                                @endcan
                                <li><a href="/permission" class="waves-effect"><i class="fa fa-gear fa-spin"></i>
                                        Permissions</a></li>
                                <li><a href="/section/permission-serv" class="waves-effect"><i
                                                class="fas fa-terminal"></i> Permissions Serveur</a></li>
                            </ul>
                        </li>
                    @endcan

                    @can('mod_index')
                        <li class="has-submenu">
                            <a href="#"><i class="fa fa-briefcase"></i><span> Modération </span> </a>
                            <ul class="submenu">
                                <li><a disabled="" href="/ert" class="waves-effect"><i class="fa fa-legal"></i>
                                        Répartition</a></li>
                                @can("mod_center")
                                    <li><a href="/moderation" class="waves-effect"><i class="fa fa-bolt"></i> Mod Center</a>
                                    </li>
                                @endcan
                                @can('mod_ts')
                                    <li><a href="/teamspeak/banlist" class="waves-effect"><i class="fa fa-legal"></i>
                                            TeamSpeak BanList</a></li>
                                @endcan
                                @can('mod_dbaccount')
                                    <li><a disabled="" href="/moderation/seenaccount" class="waves-effect">
                                            <i class="fas fa-user-circle"></i> Account Seen</a></li>
                                @endcan
                                @can('mod_guardianer')
                                    <li><a disabled="" href="/moderation/guardian" class="waves-effect"><i
                                                    class="fa fa-legal"></i> Guardianer</a></li>
                                @endcan
                            </ul>
                        </li>
                    @endcan

                    @can('animation')
                        <li class="has-submenu">
                            <a href="#"><i class="fa fa-bomb"></i><span> Animation </span> </a>
                            <ul class="submenu">
                                @can('animation_give')
                                    <li><a href="/animation/item" class="waves-effect"><i class="fa fa-gift"></i>
                                            Récompense(s)</a></li>
                                @endcan
                                @can('animation_givepb')
                                    <li><a href="/animation/pb" class="waves-effect"><i class="fa fa-coins"></i> Give PB</a>
                                    </li>
                                @endcan
                            </ul>
                        </li>
                    @endcan

                    @can('website')
                        <li class="has-submenu">
                            <a href="#"><i class="fa fa-globe"></i> <span>Website </span> </a>
                            <ul class="submenu">
                                @can('website_prefix')
                                    <li><a href="/website/prefix" class="waves-effect"><i class="fa fa-eye"></i> Préfix
                                        </a></li>
                                @endcan
                                @can('website_vote')
                                    <li><a href="/website/vote" class="waves-effect"><i class="fa fa-envelope-open"></i>
                                            Votes </a></li>
                                @endcan
                                @can('website_admin')
                                    <li><a href="/website" class="waves-effect"><i class="fa fa-dollar"></i>
                                            Administration </a></li>
                                @endcan
                            </ul>
                        </li>
                    @endcan
                    @can('infra')
                        <li class="has-submenu">
                            <a href="#"><i class="fa fa-network-wired"></i> <span>Infrastructure </span> </a>
                            <ul class="submenu">
                                @can('vrack')
                                    <li><a href="/infra/vrack" class="waves-effect"><i
                                                    class="fa fa-project-diagram"></i> DDNS Vrack </a></li>
                                @endcan
                                @can('docker_index')
                                    <li><a href="/infra/docker" class="waves-effect"><i class="fab fa-docker"></i>
                                            Docker </a></li>
                                @endcan
                                @can('docker_index')
                                    <li><a href="/infra/console" class="waves-effect"><i class="fa fa-gear"></i> Console
                                        </a></li>
                                @endcan
                                @can('mongodb')
                                    <li><a href="/infra/mongodb" class="waves-effect"><i class="fas fa-database"></i>
                                            MongoDB </a></li>
                                @endcan
                            </ul>
                        </li>
                    @endcan
                </ul>
            </div>
        </div>
    </div>
</header>
