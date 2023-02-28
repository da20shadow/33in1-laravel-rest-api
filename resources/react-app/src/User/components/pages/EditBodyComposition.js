import {useNavigate} from "react-router-dom";
import {useEffect, useState} from "react";
import tailwindClasses from "../../../shared/constants/tailwindClasses";
import bodyComposition from './bodyComposition.png';
import {useStateContext} from "../../../context/ContextProvider";
import {bodyCompositionService} from "../../services";

function EditBodyComposition() {

    const {logoutUser} = useStateContext();
    const [response, setResponse] = useState('');
    const [body, setBody] = useState({loading: true});

    useEffect(() => {
        bodyCompositionService.get().then(r => {
            if (r.message) {
                console.log(r)
                setBody(undefined);
            } else {
                console.log(r)
                setBody(r);

            }
        }).catch(err => {
            console.log(err)
            if (err.status === 401) {
                logoutUser();
            }
        })
    }, [])


    const inputStyle = 'w-full p-2 mb-3 rounded bg-[#c6c6c6]';
    const redirect = useNavigate();
    const processUpdateBodyComposition = (e) => {
        e.preventDefault();
        const bodyData = new FormData(e.currentTarget);
        const bodyComposition = Object.fromEntries(bodyData);

        bodyCompositionService.update(bodyComposition)
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
            <h1 className={'text-center text-gray-300 text-3xl font-semibold my-5'}>Моето тяло 🧍</h1>

            <div className="flex justify-center justify-items-stretch mx-auto">
                <div className={'mt-5'}>
                    <label className={'text-[#d0edff] text-[11px]'}>Рамене</label>
                    <input name={'shoulders'} className={'mb-2 block w-[50px] '} type="number" step={'0.1'} placeholder={'125 см'} />

                    <label className={'text-[#d0edff] text-[11px]'}>Гърди</label>
                    <input name={'chest'} className={'mb-14 block w-[50px] '} type="number" step={'0.1'} placeholder={'114 см'} />

                    <label className={'text-[#d0edff] text-[11px]'}>Талия</label>
                    <input name={'waist'} className={'mb-1 block w-[50px] '} type="number" step={'0.1'} placeholder={'81 см'} />

                    <label className={'text-[#d0edff] text-[11px]'}>Ханш</label>
                    <input name={'hips'} className={'mb-2 block w-[50px] '} type="number" step={'0.1'} placeholder={'94 см'} />

                    <label className={'text-[#d0edff] text-[11px]'}>Бедро</label>
                    <input name={'thigh'} className={'mb-2 block w-[50px] '} type="number" step={'0.1'} placeholder={'65 см'} />

                    <label className={'text-[#d0edff] text-[11px]'}>Прасец</label>
                    <input name={'calf'} className={'block w-[50px] '} type="number" step={'0.1'} placeholder={'47 см'} />
                </div>
                <div id={'body-image'}>
                    <img src={bodyComposition} alt="Body Composition" width={'210px'} />
                </div>
                <div className={'mt-5'}>
                    <label className={'text-[#d0edff] text-[11px]'}>Врат</label>
                    <input name={'neck'} className={'mb-2 block w-[50px] '} type="number" step={'0.1'} placeholder={'49 см'} />

                    <label className={'text-[#d0edff] text-[11px]'}>Бицепс</label>
                    <input name={'arm'} className={'mb-1 block w-[50px] '} type="number" step={'0.1'} placeholder={'38 см'} />

                    <label className={'text-[#d0edff] text-[11px]'}>Предмишн</label>
                    <input name={'forearm'} className={'mb-24 block w-[50px] '} type="number" step={'0.1'} placeholder={'33 см'} />

                    <label className={'text-[#d0edff] text-[11px]'}>Височина</label>
                    <input name={'height'} className={'block w-[50px] '} type="number" step={'0.1'} placeholder={'183 см'} />

                    <label className={'text-[#d0edff] text-[11px]'}>Тегло</label>
                    <input name={'weight'} className={'mb-1 block w-[50px] '} type="number" step={'0.1'} placeholder={'67 кг'} />
                </div>
            </div>


            {response ?
                <p className={'w-11/12 mx-auto py-2 bg-rose-50 text-center font-bold text-rose-900'}>{response}</p> : ''}

            <form onSubmit={processUpdateBodyComposition} method={'POST'}
                  className={'my-8 w-11/12 md:w-1/2 mx-auto shadow rounded'}>
                <label className={'text-[#d0edff] mb-1'}>Дата на раждане:</label>
                <input className={inputStyle}
                       defaultValue={body?.birth_date}
                       name={'birth_date'} type="date"
                />

                <label className={'text-[#d0edff] text mb-1'}>Пол:</label>
                <select className={inputStyle} name="gender" value={body?.gender}>
                    <option value="">Избери Пол</option>
                    <option value="male">Мъж</option>
                    <option value="female">Жена</option>
                </select>

                <label className={'text-lg mb-1'}>Тегло:</label>
                <input className={inputStyle}
                       defaultValue={body?.weight}
                       name={'weight'} type="number" step={'0.1'}
                       placeholder={'76kg'}/>

                <label className={'text-lg mb-1'}>Височина:</label>
                <input className={inputStyle}
                       defaultValue={body?.height}
                       name={'height'} type="number" step={'0.1'}
                       placeholder={'76 см'}/>

                <label className={'text-lg mb-1'}>Гръден кош:</label>
                <input className={inputStyle}
                       defaultValue={body?.chest}
                       name={'chest'} type="number" step={'0.1'}
                       placeholder={'105 см'}/>

                <label className={'text-lg mb-1'}>Талия:</label>
                <input className={inputStyle}
                       defaultValue={body?.waist}
                       name={'waist'} type="number" step={'0.1'}
                       placeholder={'75 см'}/>

                <label className={'text-lg mb-1'}>Ханш:</label>
                <input className={inputStyle}
                       defaultValue={body?.hips}
                       name={'hips'} type="number" step={'0.1'}
                       placeholder={'95 см'}/>

                <label className={'text-lg mb-1'}>Бедро:</label>
                <input className={inputStyle}
                       defaultValue={body?.upper_thigh}
                       name={'upper_thigh'} type="number" step={'0.1'}
                       placeholder={'55 см'}/>

                <label className={'text-lg mb-1'}>Прасец:</label>
                <input className={inputStyle}
                       defaultValue={body?.calves}
                       name={'calves'} type="number" step={'0.1'}
                       placeholder={'35 см'}/>

                <label className={'text-lg mb-1'}>Ръка:</label>
                <input className={inputStyle}
                       defaultValue={body?.arm}
                       name={'arm'} type="number" step={'0.1'}
                       placeholder={'55 см'}/>

                <button className={tailwindClasses.btnFullLg} type={'submit'}>Запази</button>

            </form>
        </>
    )
}

export default EditBodyComposition;
