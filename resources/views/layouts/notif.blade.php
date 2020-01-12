<footer class="footer text-right">
    2018 - 2019 © BadBlock.
</footer>
    <div class="side-bar right-bar">
      <a href="javascript:void(0);" class="right-bar-toggle">
                  <i class="mdi mdi-close-circle-outline"></i>
              </a>
        <h4 class="">Notifications</h4>
        <div class="notification-list nicescroll">
            <ul class="list-group list-no-border user-list">
                @foreach( \App\Models\Notifications::where('user_id', '=', Auth::user()->id)->orderBy('created_at', 'DESC')->take(30)->get() as $row)
                    <li class="list-group-item">
                        <a href="/notif-link/{{ $row->id }}" class="user-list-item">
                            <div class="avatar">
                                <img src="{{ $row->icon }}" alt="">
                            </div>
                            <div class="user-desc">
                                <span class="name">{{ $row->title }}</span>
                                <span class="desc">{{ $row->text }}</span>
                                <span class="time">{{ $row->created_at }}</span>
                            </div>
                        </a>
                    </li>
                @endforeach
            </ul>
        </div>
    </div>
</div>
