
<ul>

    <li>
        <a href="{{ route('home') }}">Home</a>
    </li>

    <li>
        <a href="{{ route('about') }}">About</a>
    </li>

    <li>
        <a href="{{ route('post.index') }}">Posts</a>
    </li>


    @auth

        {{-- ==================================================
             MY PROFILE
             Navigation principale del profilo utente
             ================================================== --}}

        <li>

            <span>My Profile</span>

            <ul>

                {{-- ==================================================
                     CURRENT USER INFORMATION
                     ================================================== --}}

                <li>
                    <strong>{{ auth()->user()->name }}</strong>
                </li>

                <li>
                    {{ auth()->user()->email }}
                </li>


                {{-- ==================================================
                     PROFILE NAVIGATION
                     ================================================== --}}

                <li>
                    <a href="{{ route('profile') }}">
                        Dashboard
                    </a>
                </li>

                <li>
                    <a href="{{ route('profile.posts') }}">
                        My Posts
                    </a>
                </li>

                <li>
                    <a href="{{ route('profile.information') }}">
                        Personal Information
                    </a>
                </li>

            </ul>

        </li>


        {{-- ==================================================
             LOGOUT
             ================================================== --}}

        <li>

            <form action="{{ route('logoutUser') }}" method="POST">

                @csrf

                <button type="submit">
                    Logout
                </button>

            </form>

        </li>


    @else

        <li>
            <a href="{{ route('login') }}">
                Login
            </a>
        </li>

        <li>
            <a href="{{ route('register') }}">
                Registration
            </a>
        </li>

    @endauth

</ul>

