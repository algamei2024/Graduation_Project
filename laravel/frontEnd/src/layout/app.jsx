export default function Apptow(){
    return (
<div id="app">
  <nav classname="navbar navbar-expand-md navbar-light bg-white shadow-sm">
    <div classname="container">
      <a classname="navbar-brand" href="{{ url('/') }}">
        a link
      </a>
      <button classname="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
        <span classname="navbar-toggler-icon" />
      </button>
      <div classname="collapse navbar-collapse" id="navbarSupportedContent">
        <ul classname="navbar-nav mr-auto">
        </ul>
        <ul classname="navbar-nav ml-auto">
          <li classname="nav-item">
            <a classname="nav-link" href="{{ route('login') }}">
            </a>
          </li>
          <li classname="nav-item">
            <a classname="nav-link" href="{{ route('register') }}">
            </a>
          </li>
          <li classname="nav-item dropdown">
            <a id="navbarDropdown" classname="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
              <span classname="caret" />
            </a>
            <div classname="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
              <a classname="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault();
                                              document.getElementById('logout-form').submit();">
              </a>
              <form id="logout-form" action="{{ route('logout') }}" method="POST" style={{display: 'none'}}>
              </form>
            </div>
          </li>
        </ul>
      </div>
    </div>
  </nav>
</div>

    );
}




