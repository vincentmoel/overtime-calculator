<nav id="sidebar" class="img" style="background-image: url(/assets/sidebar/images/bg_1.jpg);">
    <div class="p-4">
        <h1><a href="/" class="logo">GIA <span>Hi, {{ auth()->user()->name }}</span></a></h1>
        <ul class="list-unstyled components mb-5">
            <li class="{{ (request()->segment(1) == '') ? 'active' : '' }}">
                <a href="#"><span class="fa fa-home mr-3"></span> Home</a>
            </li>
            
            {{-- <li>
                <a href="#"><span class="fa fa-plane mr-3"></span> Destination</a>
            </li> --}}
            <li class="{{ (request()->segment(1) == 'overtimes') ? 'active' : '' }}">
                <a href="/overtimes"><span class="fa fa-sticky-note mr-3"></span> Overtimes</a>
            </li>
            {{-- <li>
                <a href="#"><span class="fa fa-paper-plane mr-3"></span> Contacts</a>
            </li> --}}
            <li class="{{ (request()->segment(1) == 'profile') ? 'active' : '' }}">
                <a href="#"><span class="fa fa-user mr-3"></span> Profile</a>
            </li>
            <li class="{{ (request()->segment(1) == 'config') ? 'active' : '' }}">
                <a href="#"><span class="fa fa-cogs mr-3"></span>Config</a>
            </li>
        </ul>


    </div>
</nav>