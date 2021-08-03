<div class="container bg-white shadow-sm rounded my-2">
  <div class="d-flex flex-wrap align-items-center justify-content-between">
    <a href="{{ route('welcome') }}" class="d-flex align-items-center lead text-dark text-decoration-none m-2">
      {{ config('app.name', 'Laravel') }}
    </a>
    @guest
      <ul class="nav">
          <li><a href="#" class="nav-link px-2 link-dark">О проекте</a></li>
          <li><a href="#" class="nav-link px-2 link-dark">Возможности</a></li>
          <li><a href="#" class="nav-link px-2 link-dark">Контакты</a></li>
      </ul>
      <ul class="nav">
        @if (Route::has('login'))
            <li>
                <a class="nav-link px-2 link-secondary" href="{{ route('login') }}">Войти <i class="bi bi-box-arrow-in-right"></i></a>
            </li>
        @endif

        @if (Route::has('register'))
            <li>
                <a class="nav-link px-2 link-secondary" href="{{ route('register') }}">Регистрация <i class="bi bi-person-plus"></i></a>
            </li>
        @endif
      </ul>
    @else
      <div class="btn-group m-2">
        <a href="{{ route('login')}}" role="button" class="btn btn-primary btn-sm text-white">
          <i class="bi bi-person-fill"></i> {{ Auth::user()->login }}
        </a>
        <button type="button" class="btn btn-primary btn-sm text-white dropdown-toggle dropdown-toggle-split position-relative" data-bs-toggle="dropdown" aria-expanded="false">
          <span class="visually-hidden"><font style="vertical-align: inherit;"><font style="vertical-align: inherit;">Переключить раскрывающийся список</font></font></span>
        </button>
        <ul class="dropdown-menu" style="">
          <li>
            <a class="dropdown-item" href="{{ route('login')}}">
              Панель управления <i class="bi bi-house-door-fill"></i>
            </a>
          </li>
          <li>
            <a class="dropdown-item" href="#">
              Управление аккаунтом <i class="bi bi-key-fill"></i>
            </a>
          </li>
          <li><hr class="dropdown-divider"></li>
          <li>
            <a class="dropdown-item" href="{{ route('logout') }}"
               onclick="event.preventDefault();
                             document.getElementById('logout-form').submit();">
              Выход <i class="bi bi-box-arrow-left"></i>
            </a>
            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                @csrf
            </form>
          </li>
        </ul>
      </div>
      @endif
  </div>
</div>
