<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    @yield('css')
    <title>@yield('title')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-iYQeCzEYFbKjA/T2uDLTpkwGzCiq6soy8tYaI1GyVh/UjpbCx/TYkiZhlZB6+fzT" crossorigin="anonymous">
    <link rel="stylesheet" href="{{asset('css/main.css')}}">
    <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
    <script defer src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    @livewireStyles
  </head>
  <body onload="load()">
    <div class="spinner-grow text-primary" id="loading" role="status">
    </div>
<div id="app">

  <nav class="navbar navbar-expand-sm px-2">
    <a class="navbar-brand blue d-flex" href="/" title="home">
      <svg xmlns="http://www.w3.org/2000/svg" width="200" height="200" fill="currentColor" class="bi bi-shop" viewBox="0 0 16 16" id="IconChangeColor"> <path d="M2.97 1.35A1 1 0 0 1 3.73 1h8.54a1 1 0 0 1 .76.35l2.609 3.044A1.5 1.5 0 0 1 16 5.37v.255a2.375 2.375 0 0 1-4.25 1.458A2.371 2.371 0 0 1 9.875 8 2.37 2.37 0 0 1 8 7.083 2.37 2.37 0 0 1 6.125 8a2.37 2.37 0 0 1-1.875-.917A2.375 2.375 0 0 1 0 5.625V5.37a1.5 1.5 0 0 1 .361-.976l2.61-3.045zm1.78 4.275a1.375 1.375 0 0 0 2.75 0 .5.5 0 0 1 1 0 1.375 1.375 0 0 0 2.75 0 .5.5 0 0 1 1 0 1.375 1.375 0 1 0 2.75 0V5.37a.5.5 0 0 0-.12-.325L12.27 2H3.73L1.12 5.045A.5.5 0 0 0 1 5.37v.255a1.375 1.375 0 0 0 2.75 0 .5.5 0 0 1 1 0zM1.5 8.5A.5.5 0 0 1 2 9v6h1v-5a1 1 0 0 1 1-1h3a1 1 0 0 1 1 1v5h6V9a.5.5 0 0 1 1 0v6h.5a.5.5 0 0 1 0 1H.5a.5.5 0 0 1 0-1H1V9a.5.5 0 0 1 .5-.5zM4 15h3v-5H4v5zm5-5a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1v3a1 1 0 0 1-1 1h-2a1 1 0 0 1-1-1v-3zm3 0h-2v3h2v-3z" id="mainIconPathAttribute" fill="blue"></path> </svg>
    </a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
  
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
      <ul class="navbar-nav mr-auto w-100" style="justify-content: space-between">
        <span class="left">
          <li class="nav-item active">
            <a class="nav-link" href="#">Home <span class="sr-only">(current)</span></a>
          </li>

      {{-- dropdown  start  --}}
      <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          categories
        </a>
        <ul class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
         
          @foreach ($categoriesAll as $category)
              @if (!empty($category->brands))
              <li class="dropdown-submenu">
                <a class="dropdown-item dropdown-toggle" href="#">{{$category->name}}</a>
            <ul class="dropdown-menu">
              <li>
                <a href="{{route('user.category.detail',[$category->id])}}" class="dropdown-item">see all</a>
              </li>
              @foreach ($category->brands as $b)
                <li><a class="dropdown-item" href="{{route('user.brand.detail',[$b->id])}}">{{$b->name}}</a></li>
              @endforeach

            </ul>
          </li>     
              @endif
          @endforeach
        </ul>
      </li>
      {{-- dropdown end --}}
      </ul>
        </span>
        <span class="right">
          @auth
          <li class="nav-item dropdown" style="list-style: none">
            <a class="nav-link dropdown-toggle avatar" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
              <img style="width: 35px" src="https://ui-avatars.com/api/?name={{urlencode(auth()->user()->name)}}background=00ffff&rounded=true&bold=true" alt="">
            </a>
            <div class="dropdown-menu dropdown-right" aria-labelledby="navbarDropdown">
              <form action="{{route('user.logout')}}" method="post">
                @csrf
                <input class="dropdown-item" type="submit" value="logout">
                </form>
            </div>
          </li>
          @endauth
          @auth('admin')
          <li class="nav-item dropdown" style="list-style: none">
            <a class="nav-link dropdown-toggle avatar" href="#"
             id="navbarDropdown" role="button" 
             data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
             <img style="width: 35px" src="https://ui-avatars.com/api/?name={{urlencode(auth()->guard('admin')->user()->name)}}background=00ffff&rounded=true&bold=true" alt="">
            </a>
            <div class="dropdown-menu dropdown-right" aria-labelledby="navbarDropdown">
              <form action="{{route('admin.logout')}}" method="post">
                @csrf
                <input class="dropdown-item" type="submit" value="logout">
              </form>
              <a href="{{route('admin.')}}" class="dropdown-item">admin</a>
            </div>
          </li>
          @endauth
         
        </span>
      </ul>
    </div>
    @livewire('front.card-detail')
  </nav>
    {{-- end nav --}}
    <button class="back_to_top"> 
      <svg xmlns="http://www.w3.org/2000/svg" width="25" height="25"
       fill="#aaa" class="bi bi-arrow-up" viewBox="0 0 16 16">
        <path fill-rule="evenodd" d="M8 15a.5.5 0 0 0 .5-.5V2.707l3.146 3.147a.5.5 0 0 0 .708-.708l-4-4a.5.5 0 0 0-.708 0l-4 4a.5.5 0 1 0 .708.708L7.5 2.707V14.5a.5.5 0 0 0 .5.5z"/>
      </svg>
    </button>
    @if(auth()->guest() && auth()->guard('admin')->guest())
    <button  
    type="button" class="btn btn-outline-primary btn-sm login" data-toggle="modal" data-target="#loginModal">
      Login
    </button>
    
      
      <div class="modal fade" id="loginModal" tabindex="-1" role="dialog" aria-labelledby="loginModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="loginModalLabel">Login</h5>
              <button type="button" 
              class="close btn btn-outline-danger btn-sm" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <form action="{{route('user.login')}}" method="POST" autocomplete="off">
                @csrf
                <div class="modal-body">
                    <div class="form-group">
                        <label for="email">email<span style="color:red">*</span></label>
                        <input class="form-control" type="email" name="email" id="email">
                    </div>
                    <div class="form-group">
                        <label for="password">password<span style="color:red">*</span></label>                        
                        <input class="form-control" type="password" name="password" id="password">
                    </div>
                </div>
                  <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">login</button>
                  </div>
            </form>
          </div>
        </div>
      </div>
      @else      
    @endif

  @yield('content')
</div>
    <script>
      window.addEventListener('alert', event => { 
  Swal.fire({
icon: event.detail.type,
text: event.detail.message,
})
});
let scroll_to_top = document.querySelector('.back_to_top');
document.addEventListener('scroll', e => {
if (document.body.scrollTop > 400 || document.documentElement.scrollTop > 400) {
scroll_to_top.style.display = "flex";
} else {
scroll_to_top.style.display = "none";
}
})
scroll_to_top.addEventListener('click', e => {
document.body.scrollTop = 0; // For Safari
document.documentElement.scrollTop = 0; 
})
  </script>

<script>
          document.addEventListener('DOMContentLoaded', function() {
   document.querySelectorAll('.notification').forEach(not => {
    setTimeout(() => {
      not.classList.add('close_notification')
      setTimeout(() => {
        not.remove()
      }, 2000);
    },  2000);
   });
}, true);
    function load()
    {
         document.getElementById("app").style.display = "block";
         document.getElementById("loading").style.display = "none";
    }
    
</script>
<script>
  // ---------------------------------------------------------
// Bootstrap 4 : Responsive Dropdown Multi Submenu
// ---------------------------------------------------------
$(function(){
  $('.dropdown-menu a.dropdown-toggle').on('click', function(e) {
    if (!$(this).next().hasClass('show')) {
      $(this).parents('.dropdown-menu').first().find('.show').removeClass("show");
    }
    var $subMenu = $(this).next(".dropdown-menu");
    $subMenu.toggleClass('show'); 			// appliqué au ul
    $(this).parent().toggleClass('show'); 	// appliqué au li parent

    $(this).parents('li.nav-item.dropdown.show').on('hidden.bs.dropdown', function(e) {
      $('.dropdown-submenu .show').removeClass('show'); 	// appliqué au ul
      $('.dropdown-submenu.show').removeClass('show'); 		// appliqué au li parent
    });
    return false;
  });
});
window.livewire.on('openLoginModal', () => {
    $('#loginModal').modal('show')
  });
window.livewire.on('closeLoginModal', () => {
  $('#loginModal').modal('hide')
});
</script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.4.1/dist/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
<!-- JavaScript Bundle with Popper -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-OERcA2EqjJCMA+/3y+gxIOqMEjwtxJY7qPCqsdltbNJuaOe923+mo//f6V8Qbsw3" crossorigin="anonymous"></script>
@livewireScripts  
@yield('js')
</body>
</html>