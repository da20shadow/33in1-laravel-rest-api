function Header(){

    return (
        <header>
            <nav>
                <Link to={'/'}>Home</Link>
                <Link to={'/login'}>Login</Link>
                <Link to={'/register'}>Register</Link>
            </nav>
        </header>
    );
}
