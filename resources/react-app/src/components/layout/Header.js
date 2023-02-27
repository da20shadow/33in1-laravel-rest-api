import {Link, NavLink,useNavigate} from "react-router-dom";
import tailwindClasses from "../../constants/tailwindClasses";
import {authService} from "../../services";
import {useStateContext} from "../../context/ContextProvider";

function Header() {

    const {isLogged,logoutUser} = useStateContext();

    const redirect = useNavigate();
    const logout = (e) => {
        e.preventDefault();
        authService.logout().then(r => {
            logoutUser();
            setTimeout(()=>{
                redirect('/login');
            },200)
        }).catch(err => {
            alert(err.message);
        });
    }

    const publicNav = (
        <>
            <NavLink className={tailwindClasses.navLink} to={'/login'}>Влизане</NavLink>
            <NavLink className={tailwindClasses.navLink} to={'/register'}>Регистрация</NavLink>
        </>
    );
    const privateNav = (
        <>
            <NavLink className={tailwindClasses.navLink} to={'/dashboard'}>Акаунт</NavLink>
            <NavLink onClick={logout} to="#" className={tailwindClasses.navLink}>Излизане</NavLink>
        </>
    );

    return (
        <header className={'w-11/12 mx-auto py-3 border-b'}>
            <nav className={'flex justify-center justify-items-stretch items-center gap-4'}>
                <NavLink className={tailwindClasses.navLink} to={'/'}>Начало</NavLink>
                {isLogged ? privateNav : publicNav}
            </nav>
        </header>
    );
}

export default Header;
