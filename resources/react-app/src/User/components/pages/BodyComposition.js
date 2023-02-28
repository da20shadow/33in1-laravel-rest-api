import {Link, useNavigate} from "react-router-dom";
import tailwindClasses from "../../../shared/constants/tailwindClasses";
import {useEffect, useState} from "react";
import {useStateContext} from "../../../context/ContextProvider";
import {bodyCompositionService} from "../../services";

function BodyComposition() {
    const redirect = useNavigate();
    const {logoutUser} = useStateContext();
    const [body, setBody] = useState({loading: true});

    useEffect(() => {
        bodyCompositionService.get().then(r => {
            if (r.message) {
                setBody(undefined);
            } else {
                setBody(r);
            }
        }).catch(err => {
            console.log(err)
            if (err.message === 'Unauthenticated') {
                logoutUser();
            }
        })


    }, [])

    const noData = (
        <>
            <p className={'text-center text-xl'}>Все още не сте въвели данни за вашето тяло. 🙁</p>
            <p className={'text-center text-lg'}>Моля въведете ги за да ви дадем максимално точни анализи.</p>
            <p className={'text-center text-lg'}>Кликни на бутона:</p>

            <div className={'mt-5 flex'}>
                <Link className={tailwindClasses.btnFullLg} to={'/body-composition/add'}>+ Добавяне!</Link>
            </div>
        </>
    );

    const getGender = (gender) => {
        if (!gender) {
            return 'Зареждане..';
        } else if (gender === 'male') {
            return 'Мъж'
        } else {
            return 'Жена';
        }
    }

    function getAge(birthDateStr) {
        // Convert the birth date string to a Date object
        const birthDate = new Date(birthDateStr);

        // Calculate the difference between the birth date and current date
        const ageDiffMs = Date.now() - birthDate.getTime();

        // Convert the age difference to years
        const ageDate = new Date(ageDiffMs);
        return Math.abs(ageDate.getUTCFullYear() - 1970);
    }


    const bodyCompositionData = (
        <>
            <h1 className={'mb-5 text-center font-semibold text-2xl border-b'}>Моето Тяло 🧍</h1>
            <p className={'text-lg'}>Пол: <span
                className={'font-semibold'}>{body?.gender ? getGender(body.gender) : 'Зареждане..'}</span></p>
            <p className={'text-lg'}>Години: <span
                className={'font-semibold'}>{body?.birth_date ? getAge(body.birth_date) : 'Зареждане..'}</span></p>
            <p className={'text-lg'}>Тегло: <span className={'font-semibold'}>{body?.weight} кг</span></p>
            <p className={'text-lg'}>Височина: <span className={'font-semibold'}>{body?.height} см</span></p>
            <p className={'text-lg'}>Гръден кош: <span className={'font-semibold'}>{body?.chest} см</span></p>
            <p className={'text-lg'}>Талия: <span className={'font-semibold'}>{body?.waist} см</span></p>
            <p className={'text-lg'}>Ханш: <span className={'font-semibold'}>{body?.hips} см</span></p>
            <p className={'text-lg'}>Бедро: <span className={'font-semibold'}>{body?.upper_thigh} см</span></p>
            <p className={'text-lg'}>Ръка: <span className={'font-semibold'}>{body?.calves} см</span></p>
            <p className={'mb-5 text-lg'}>Прасец: <span className={'font-semibold'}>{body?.arm} см</span></p>

            <Link className={tailwindClasses.btnFullLg} to={'/body-composition/edit'}>Редактирай 🖊️</Link>
        </>
    );
    return (
        <main className={'bg-[#404955] w-11/12 mx-auto my-5 p-6 border rounded shadow'}>


            <div className="p-5">

                {body
                    ? bodyCompositionData
                    : body?.loading ? <p>Loading...</p> : noData
                }

            </div>

        </main>
    );
}

export default BodyComposition;
