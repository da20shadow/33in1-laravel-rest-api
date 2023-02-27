import {useNavigate, useParams} from "react-router-dom";
import {authService, bodyCompositionService} from "../../../services";
import {useState} from "react";
import tailwindClasses from "../../../constants/tailwindClasses";

function AddBodyComposition() {

    const [response,setResponse] = useState('');
    const inputStyle = 'w-full p-2 mb-3 rounded bg-[#c6c6c6]';
    const redirect = useNavigate();
    const processBodyComposition = (e) => {
        e.preventDefault();
        const regData = new FormData(e.currentTarget);
        const {birth_date,gender,weight,height,chest,waist,hips,upper_thigh,calves,arm} = Object.fromEntries(regData);

        bodyCompositionService.add({birth_date,gender,weight,height,chest,waist,hips,upper_thigh,calves,arm})
            .then(r => {
                console.log(r)
                setResponse(r.message);
                redirect('/body-composition');
            }).catch(err => {
            setResponse(err.message);
        })
    }

    return (
        <>
            <h1 className={'text-center text-3xl font-semibold mt-5'}>Моето тяло 🧍</h1>

            {response ? <p className={'w-11/12 mx-auto py-2 bg-rose-50 text-center font-bold text-rose-900'}>{response}</p> : ''}

            <form onSubmit={processBodyComposition} method={'POST'} className={'my-8 w-11/12 md:w-1/2 mx-auto shadow rounded'}>
                <label className={'text-lg mb-1'}>Дата на раждане:</label>
                <input className={inputStyle}
                       name={'birth_date'} type="date"
                       required/>

                <label className={'text-lg mb-1'}>Пол:</label>
                <select className={inputStyle} name="gender" required>
                    <option value="">Избери Пол</option>
                    <option value="male">Мъж</option>
                    <option value="female">Жена</option>
                </select>

                <label className={'text-lg mb-1'}>Тегло:</label>
                <input className={inputStyle}
                       name={'weight'} type="number" step={'0.1'}
                       placeholder={'76kg'} />

                <label className={'text-lg mb-1'}>Височина:</label>
                <input className={inputStyle}
                       name={'height'} type="number" step={'0.1'}
                       placeholder={'76 см'} />

                <label className={'text-lg mb-1'}>Гръден кош:</label>
                <input className={inputStyle}
                       name={'chest'} type="number" step={'0.1'}
                       placeholder={'105 см'} />

                <label className={'text-lg mb-1'}>Талия:</label>
                <input className={inputStyle}
                       name={'waist'} type="number" step={'0.1'}
                       placeholder={'75 см'} />

                <label className={'text-lg mb-1'}>Ханш:</label>
                <input className={inputStyle}
                       name={'hips'} type="number" step={'0.1'}
                       placeholder={'95 см'} />

                <label className={'text-lg mb-1'}>Бедро:</label>
                <input className={inputStyle}
                       name={'thigh'} type="number" step={'0.1'}
                       placeholder={'55 см'} />

                <label className={'text-lg mb-1'}>Прасец:</label>
                <input className={inputStyle}
                       name={'calf'} type="number" step={'0.1'}
                       placeholder={'35 см'} />

                <label className={'text-lg mb-1'}>Ръка:</label>
                <input className={inputStyle}
                       name={'arm'} type="number" step={'0.1'}
                       placeholder={'55 см'} />

                <button className={tailwindClasses.btnFullLg} type={'submit'}>Запази</button>

            </form>
        </>
    )
}

export default AddBodyComposition;
