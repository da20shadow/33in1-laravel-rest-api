import {Link} from "react-router-dom";
import {useEffect, useState} from "react";
import {useStateContext} from "../../../context/ContextProvider";
import {tailwindClasses} from "../../../shared";
import {waterService} from "../../services";
import WaterIntake from "../common/WaterIntake";
import Alert from "../../../components/ui/Alert";

function Water() {

    const {logoutUser} = useStateContext();
    const [message, setMessage] = useState('');
    const [errorMsg, setErrorMsg] = useState('');

    const [todayWater, setTodayWater] = useState(0);
    const [todayWaterLoading, setTodayWaterLoading] = useState(true);

    const [waterIntakeList, setWaterIntakeList] = useState([]);
    useEffect(() => {
        console.log('useEffect')
        waterService.getTodays().then(r => {
            setTodayWater(r.totalIntakeWater);
            setTodayWaterLoading(false);
            setWaterIntakeList(r.waterIntakeList);
        }).catch(err => {
            console.log('Get Today Water Error: ', err)
            if (err.message === 'Unauthenticated') {
                logoutUser();
            }
        })
    }, [])

    const addWater = (e) => {
        e.preventDefault();
        const formData = new FormData(e.currentTarget);
        const water = Object.fromEntries(formData);
        waterService.add(water).then(r => {
            const dateTime = new Date(r.addedWater.time);
            const hours = dateTime.getHours().toString().padStart(2, '0');
            const minutes = dateTime.getMinutes().toString().padStart(2, '0');
            const time = `${hours}:${minutes}`;
            const theWater = {id: r.addedWater.id, time, amount: r.addedWater.amount};

            setTodayWater(Number(todayWater) + Number(r.addedWater.amount));
            setWaterIntakeList(oldList => [...oldList, theWater]);
            setMessage(r.message);
            setTimeout(() => {
                setMessage('');
            }, 4000);
        }).catch(err => {
            console.log(err)
            setErrorMsg(err.message)
            setTimeout(() => {
                setErrorMsg('');
            }, 4000);
        });
    }

    const setUpdatedWater = (changedWater, remove = false) => {
        // let newTotalIntake = 0;
        // let waterList;
        // if (remove) {
        //     waterList = waterIntakeList.filter(w => {
        //         newTotalIntake += Number(w.amount);
        //         return w.id !== changedWater.id;
        //     });
        // } else {
        //     waterList = waterIntakeList.map(w => {
        //         if (w.id === changedWater.id) {
        //             newTotalIntake += Number(changedWater.amount);
        //             const updatedTime = changedWater.time.substr(changedWater.time.length - 5, changedWater.time.length);
        //             return {...changedWater, time: updatedTime};
        //         }
        //         newTotalIntake += Number(w.amount);
        //         return w;
        //     });
        // }
        // setTodayWater(newTotalIntake);
        // setWaterIntakeList(waterList);
        waterService.getTodays().then(r => {
            setTodayWater(r.totalIntakeWater);
            setTodayWaterLoading(false);
            setWaterIntakeList(r.waterIntakeList);
        }).catch(err => {
            console.log('Get Today Water Error: ', err)
            if (err.message === 'Unauthenticated') {
                logoutUser();
            }
        })
    }

    return (
        <>
            {message ? <Alert message={message}/> : ''}
            {errorMsg ? <Alert message={errorMsg} isError={true}/> : ''}
            <main className={'bg-[#404955] w-11/12 mx-auto my-5 p-6 border rounded shadow relative'}>

                <h1 className={'text-center text-gray-300 font-semibold text-2xl'}>Здравей 😊</h1>

                <div className="flex flex-wrap justify-center gap-4 p-5">

                    <div>
                        <h3 className={'text-center text-gray-300 text-4xl font-semibold'}>
                            {todayWaterLoading
                                ? <span className={'text-yellow-300 text-lg'}>Зареждане...</span>
                                : todayWater + ' мл.'}
                        </h3>
                        <p className="text-gray-300 text-center">Дневна цел: 2700 мл</p>
                    </div>

                    <form onSubmit={addWater} method={'POST'}>
                        <select className={tailwindClasses.inputStyle}
                                name="amount" defaultValue={'100'} required>
                            <option value="50">50 мл</option>
                            <option value="100">100 мл</option>
                            <option value="250">250 мл</option>
                            <option value="500">500 мл</option>
                            <option value="1000">1000 мл</option>
                        </select>
                        <button className={tailwindClasses.btnFullLg}>+ Добави 🥛</button>
                    </form>

                    <Link className={tailwindClasses.btnFullLg} to={'/water/stat'}>Статистика</Link>

                </div>

                <div>
                    <h3 className="my-5 text-2xl text-gray-300 text-center border-t">Приета вода за деня:</h3>
                    {waterIntakeList.map(w => <WaterIntake getUpdatedWater={setUpdatedWater} key={w.id} id={w.id}
                                                           time={w.time} today_time={w.today_time}
                                                           amount={w.amount}/>)}
                </div>
            </main>

        </>
    )
}

export default Water;
