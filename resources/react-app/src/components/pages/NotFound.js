import {Link} from "react-router-dom";
import tailwindClasses from "../../shared/constants/tailwindClasses";

function NotFound() {
    return (
        <main className={'bg-rose-50 w-11/12 mx-auto my-5 p-6 border rounded shadow'}>

            <h1 className="my-5 text-rose-900 text-center text-7xl font-semibold">Грешка 404</h1>

            <h3 className="my-5 text-center text-3xl font-semibold">Страницата която търсите не е намерена.</h3>

            <h3 className="my-10 text-center text-7xl font-semibold">🙁</h3>

            <div className="mb-20 flex justify-center">
                <Link className={tailwindClasses.btnLg} to={'/register'}>Към Начална Страница</Link>
            </div>

        </main>
    )
}
export default NotFound;
