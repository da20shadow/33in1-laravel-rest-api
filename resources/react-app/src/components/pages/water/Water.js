import {Link} from "react-router-dom";
import tailwindClasses from "../../../constants/tailwindClasses";
import {useEffect, useState} from "react";
import {waterService} from "../../../services";
import {useStateContext} from "../../../context/ContextProvider";

function Water(){

    const {logoutUser} = useStateContext();
    const [message, setMessage] = useState('');
    const [errorMsg, setErrorMsg] = useState('');

    const [todayWater,setTodayWater] = useState(0);
    const [todayWaterLoading,setTodayWaterLoading] = useState(true);
    const [showEditWaterModal,setShowEditWaterModal] = useState(false);
    const [waterIdAndaMountToEdit, setWaterIdAndaMountToEdit] = useState({});

    const [waterIntakeList, setWaterIntakeList] = useState([]);
    useEffect(()=> {
        waterService.getTodays().then(r => {
            setTodayWater(r.totalIntakeWater);
            setTodayWaterLoading(false);
            setWaterIntakeList(r.waterIntakeList);
        }).catch(err => {
            console.log('Get Today Water Error: ',err)
            if (err.message === 'Unauthenticated') {
                logoutUser();
            }
        })
    },[])

    const addWater = (e) => {
        e.preventDefault();
        const formData = new FormData(e.currentTarget);
        const water = Object.fromEntries(formData);
        waterService.add(water).then(r => {
            const dateTime = new Date(r.addedWater.time);
            const hours = dateTime.getHours().toString().padStart(2, '0');
            const minutes = dateTime.getMinutes().toString().padStart(2, '0');
            const time = `${hours}:${minutes}`;
            const theWater = {time, amount: r.addedWater.amount};

            setTodayWater(Number(todayWater) + Number(r.addedWater.amount));
            setWaterIntakeList(oldList => [...oldList,theWater]);
            setMessage(r.message);
            setTimeout(() => {
                setMessage('');
            },4000);
        }).catch(err => {
            console.log(err)
            setErrorMsg(err.message)
            setTimeout(() => {
                setErrorMsg('');
            },4000);
        });
    }

    const editWaterIntake = (e) => {
        e.preventDefault();
        const formData = new FormData(e.currentTarget);
        const {amount,hour,minute} = Object.fromEntries(formData);
        let water = {amount};

        let time = '06:30';
        let isTimeChanged = false;
        if (hour && minute) {
            const today = new Date();
            // Format the date/time with the specified timezone
            const dateWithTimezone = today.toLocaleString('en-US', {timeZone: 'Europe/Sofia'});
            const now = new Date(dateWithTimezone);
            time = `${now.getFullYear()}-${now.getMonth()+1}-${now.getDate()} ${hour}:${minute}`;
            water = {...water,time}
            isTimeChanged = true;
        }
        waterService.update(waterIdAndaMountToEdit.id,water).then(r => {

            const changedWater = waterIdAndaMountToEdit;
            let newTotalIntake = 0;
            const waterList = waterIntakeList.map(w => {
                if (w.id === Number(changedWater.id)){
                    newTotalIntake += Number(amount);
                    const updatedTime = time.length === 5 ? time : time.substr(time.length - 5, time.length);
                    return {...changedWater,amount,time: updatedTime};
                }
                newTotalIntake += Number(w.amount);
                return w;
            });
            setTodayWater(newTotalIntake);
            setWaterIntakeList(waterList);

            console.log(r)
            closeEditWaterIntakeModal();
            setMessage(r.message);
            setInterval(() => {
                setMessage('');
            },4000);
        }).catch(err => {
            console.log(err)
            setErrorMsg(err.message)
            setTimeout(() => {
                setErrorMsg('');
            },4000);
        });
    }

    const openEditWaterIntakeModal = (waterId,amount,time) => {
        setWaterIdAndaMountToEdit({id: waterId,amount,time});
        console.log(time.substr(0,2) + ':' +time.substr(3,5))
        setShowEditWaterModal(true);
    }
    const closeEditWaterIntakeModal = () => {
        setWaterIdAndaMountToEdit({});
        setShowEditWaterModal(false);
    }

    const editWaterIntakeModal = (
        <div className="bg-gray-800 p-10 absolute top-20 rounded shadow-lg">
            <span className={'px-2 pb-1 font-semibold bg-rose-50 text-rose-900 absolute top-2 right-2'}
                  onClick={closeEditWaterIntakeModal}>x</span>

            <form onSubmit={editWaterIntake} method={'POST'}>
                <p className="text-lg text-gray-300 text-center my-5">Редактиране на приета вода в {waterIdAndaMountToEdit?.time}.</p>
                <input name={'id'} type="text" defaultValue={waterIdAndaMountToEdit?.id} hidden/>
                <select className={tailwindClasses.inputStyle}
                        name="amount" defaultValue={waterIdAndaMountToEdit?.amount ? waterIdAndaMountToEdit?.amount : '100'} required>
                    <option value="50">50 мл</option>
                    <option value="100" >100 мл</option>
                    <option value="250">250 мл</option>
                    <option value="500">500 мл</option>
                    <option value="1000">1000 мл</option>
                </select>
                <div className="flex gap-1">
                    <select className={tailwindClasses.inputStyle + ' text-center'} name="hour"
                            defaultValue={waterIdAndaMountToEdit?.time?.substr(0,2)}>
                        <option value="">час</option>
                        <option value="00">00</option>
                        <option value="01">01</option>
                        <option value="02">02</option>
                        <option value="03">03</option>
                        <option value="04">04</option>
                        <option value="05">05</option>
                        <option value="06">06</option>
                        <option value="07">07</option>
                        <option value="08">08</option>
                        <option value="09">09</option>
                        <option value="10">10</option>
                        <option value="11">11</option>
                        <option value="12">12</option>
                        <option value="13">13</option>
                        <option value="14">14</option>
                        <option value="15">15</option>
                        <option value="16">16</option>
                        <option value="17">17</option>
                        <option value="18">18</option>
                        <option value="19">19</option>
                        <option value="20">20</option>
                        <option value="21">21</option>
                        <option value="22">22</option>
                        <option value="23">23</option>
                    </select>
                    <select className={tailwindClasses.inputStyle + ' text-center'} name="minute"
                            defaultValue={waterIdAndaMountToEdit?.time?.substr(3,5)}>
                        <option value="">мин</option>
                        <option value="00">00</option>
                        <option value="01">01</option>
                        <option value="02">02</option>
                        <option value="03">03</option>
                        <option value="04">04</option>
                        <option value="05">05</option>
                        <option value="06">06</option>
                        <option value="07">07</option>
                        <option value="08">08</option>
                        <option value="09">09</option>
                        <option value="10">10</option>
                        <option value="11">11</option>
                        <option value="12">12</option>
                        <option value="13">13</option>
                        <option value="14">14</option>
                        <option value="15">15</option>
                        <option value="16">16</option>
                        <option value="17">17</option>
                        <option value="18">18</option>
                        <option value="19">19</option>
                        <option value="20">20</option>
                        <option value="21">21</option>
                        <option value="22">22</option>
                        <option value="23">23</option>
                        <option value="24">24</option>
                        <option value="25">25</option>
                        <option value="26">26</option>
                        <option value="27">27</option>
                        <option value="28">28</option>
                        <option value="29">29</option>
                        <option value="30">30</option>
                        <option value="31">31</option>
                        <option value="32">32</option>
                        <option value="33">33</option>
                        <option value="34">34</option>
                        <option value="35">35</option>
                        <option value="36">36</option>
                        <option value="37">37</option>
                        <option value="38">38</option>
                        <option value="39">39</option>
                        <option value="40">40</option>
                        <option value="41">41</option>
                        <option value="42">42</option>
                        <option value="43">43</option>
                        <option value="44">44</option>
                        <option value="45">45</option>
                        <option value="46">46</option>
                        <option value="47">47</option>
                        <option value="48">48</option>
                        <option value="49">49</option>
                        <option value="50">50</option>
                        <option value="51">51</option>
                        <option value="52">52</option>
                        <option value="52">52</option>
                        <option value="54">54</option>
                        <option value="55">55</option>
                        <option value="56">56</option>
                        <option value="57">57</option>
                        <option value="58">58</option>
                        <option value="59">59</option>
                    </select>
                </div>
                <button type={'submit'} className={tailwindClasses.btnFullLg}>Запази 🥛</button>
            </form>
        </div>
    );

    return (
        <>
            {message ? <p className={'w-11/12 mx-auto py-2 bg-green-50 text-center font-bold text-green-900'}>{message}</p> : ''}
            {errorMsg ? <p className={'w-11/12 mx-auto py-2 bg-rose-50 text-center font-bold text-rose-900'}>{errorMsg}</p> : ''}
            <main className={'bg-[#404955] w-11/12 mx-auto my-5 p-6 border rounded shadow relative'}>
                {showEditWaterModal ? editWaterIntakeModal : ''}
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
                            <option value="100" >100 мл</option>
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
                    {waterIntakeList.map(w => {
                        return (
                            <div key={w.id} className="flex gpa-3 justify-between my-1 px-1 py-2 border">
                                <p>
                                    <span className={'font-bold text-gray-300'}>{w.time} - </span>
                                     🥛
                                    <strong className={'text-blue-200'}>{w.amount} мл.</strong>
                                </p>
                                <button className={'text-sm bg-gray-300 px-2 rounded border'}
                                        onClick={() => openEditWaterIntakeModal(w.id,w.amount,w.time)}> Промяна 🖊️
                                </button>
                            </div>
                            )
                    })}
                </div>
            </main>

        </>
    )
}

export default Water;
