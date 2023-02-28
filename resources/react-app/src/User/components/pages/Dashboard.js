import tailwindClasses from "../../../shared/constants/tailwindClasses";
import {Link,useNavigate} from "react-router-dom";
import {useEffect} from "react";

function Dashboard() {
    const redirect = useNavigate();
    // useEffect(() => {
    //
    // },[])

    return (
        <>
            <main className={'bg-[#404955] w-11/12 mx-auto my-5 p-6 border rounded shadow'}>
                <h1 className={'text-center font-semibold text-2xl'}>Здравей 😊</h1>

                <div className="flex flex-wrap justify-center gap-4 p-5">
                    <Link className={tailwindClasses.btnFullLg} to={'/sleep'}>Сън 😴</Link>
                    <Link className={tailwindClasses.btnFullLg} to={'/water/add'}>Вода 🥛</Link>
                    <Link className={tailwindClasses.btnFullLg} to={'/food'}>Храна 🍽️</Link>
                    <Link className={tailwindClasses.btnFullLg} to={'/work'}>Работа 🧑💼</Link>
                    <Link className={tailwindClasses.btnFullLg} to={'/workout'}>Тренировка 💪</Link>
                    <Link className={tailwindClasses.btnFullLg} to={'/body-composition'}>Моето Тяло 🧍</Link>
                </div>
            </main>

        </>
    )
}

export default Dashboard;
