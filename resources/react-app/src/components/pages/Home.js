import {Link} from "react-router-dom";
import tailwindClasses from "../../shared/constants/tailwindClasses";

function Home() {

    return (
        <>
            <main className={'bg-[#404955] w-11/12 mx-auto my-5 p-6 border rounded shadow'}>

                <h1 className="my-5 text-cyan-300 text-center text-7xl font-semibold">33 in 1 App</h1>
                <h2 className="text-center text-gray-300 text-xl">Приложението е посветено на здравословния начин на живот.</h2>

                <h3 className="my-5 text-gray-300 text-center text-3xl font-semibold">Какво ще намериш вътре?</h3>

                <h3 className="mb-5 text-gray-300 text-xl text-center">Дневници: Тяло, Прием и Разход на калории, вода, сън,
                    анализи за здравословното ви състояние и др.</h3>

                <p className={'text-center text-gray-300 text-xl'}>
                    Приложението е чудесен помощник за подържане на здраво и красиво тяло,
                    или просто ако искате да отслабнете на определени места.
                </p>
                <p className={'text-center text-gray-300 text-xl'}>
                    Графики и анализ за оптимален контрол на вашия хранителен и физически баланс.
                </p>

                <h3 className="my-5 text-gray-300 text-center text-7xl font-semibold">❤️</h3>

                <div className="mb-8 flex justify-center">
                    <Link className={tailwindClasses.btnLg} to={'/register'}>Започни сега</Link>
                </div>

            </main>
        </>
    )
}

export default Home;
