import {useNavigate} from "react-router-dom";
import {useEffect, useState} from "react";
import tailwindClasses from "../../../constants/tailwindClasses";
import {sleepService} from "../../../services";
import {useStateContext} from "../../../context/ContextProvider";

function Sleep() {
    const redirect = useNavigate();
    const {logoutUser} = useStateContext();
    const [errors, setErrors] = useState('');
    const [lastSleepLog, setLastSleepLog] = useState();
    const [todaySleepLog, setTodaySleepLog] = useState();
    const [isLoadingTodaySleepLog, setIsLoadingTodaySleepLog] = useState(true);

    useEffect(() => {
        //Checks and stop forgotten sleep session longer than 20 hours and make it 8 hours.
        sleepService.clearIfOldActive().then(() => {
        })
            .catch((err) => {
                console.log('Error During Clear Old Sleep In Progress', err);
                if (err.message === 'Unauthenticated') {
                    logoutUser();
                }
            });
        //Get the last sleep session that is still in progress.
        sleepService.getLastInProgress().then(r => {
            console.log('Get sleepService.getLastInProgress() r', r)
            if (r.sleepLog) {
                setLastSleepLog(r.sleepLog);
            }
        }).catch(err => {
            console.log('Error During Getting Last Sleep In Progress ', err);
        });
        //Get today sleep log
        sleepService.getTodaySleepLog().then(r => {
            setTodaySleepLog(r.sleepLog);
            setIsLoadingTodaySleepLog(false);
        }).catch(err => {
            setIsLoadingTodaySleepLog(false);
            console.log('Error During Getting Today Sleep Log ', err);
        });

    }, [])
    //Start a new sleep session if there is no one in progress
    const startSleepSession = (e) => {
        e.preventDefault();

        if (isTimeBetween5And18()) {
            startNapSession(e);
        } else {
            sleepService.start().then(r => {
                console.log(r);
                window.location.reload(false);
            }).catch(err => {
                console.log(err);
                setErrors(err.message);
                setInterval(() => {
                    setErrors('');
                }, 3000);
            })
        }
    }
    //Start a new nap session if there is no one in progress
    const startNapSession = (e) => {
        e.preventDefault();
        setErrors('Функцията за котешка дрямка все още не е налична 🙁');
        setTimeout(() => {
            setErrors('');
        }, 4500);
        //TODO:
        // sleepService.startNap().then(r => {
        //     console.log(r);
        // }).catch(err => {
        //     console.log(err);
        //     setErrors(err.message);
        //     setInterval(() => {
        //         setErrors('');
        //     },3000);
        // })
    }
    //Stop the current running sleep session
    const stopSleepSession = (e) => {
        e.preventDefault();
        sleepService.stop().then(r => {
            console.log(r);
            // Get the current date/time
            const now = new Date();
            // Format the date/time with the specified timezone
            const dateWithTimezone = now.toLocaleString('en-US', {timeZone: 'Europe/Sofia'});
            const stopSleepTime = new Date(dateWithTimezone);
            setLastSleepLog(prevState => {
                return {
                    ...prevState,
                    sleep_end_time: stopSleepTime
                }
            });
        }).catch(err => {
            console.log(err);
            setErrors(err.message);
            setTimeout(() => {
                setErrors('');
            }, 3000);
        })
    }
    //Calculate and return the duration of Hours: and Minutes between 2 dates
    //If second date is not provided will calculate duration to the current date time
    function durationBetweenDateTimes(startSleepTimeStr, endSleepTimeStr) {
        // Convert the date/time string to a Date object
        const dateTime = new Date(startSleepTimeStr);

        console.log('Sleep start: ', dateTime)

        // Get the current date/time
        const now = endSleepTimeStr ? new Date(endSleepTimeStr) : new Date();

        // Format the date/time with the specified timezone
        const dateWithTimezone = now.toLocaleString('en-US', {timeZone: 'Europe/Sofia'});

        const date = new Date(dateWithTimezone);

        // Calculate the time difference in milliseconds
        const timeDiffMs = date - dateTime.getTime();

        // Calculate the time difference in hours and minutes
        const timeDiffHours = Math.floor(timeDiffMs / (1000 * 60 * 60));
        const timeDiffMinutes = Math.floor((timeDiffMs / (1000 * 60)) % 60);

        console.log('Sleeping time: ', timeDiffMs)
        // Convert the time difference to hours
        return `${timeDiffHours} ч. и ${timeDiffMinutes} мин.`
    }

    //Display greeting message depending on the time
    function getGreeting() {
        // Get the current date/time
        const today = new Date();
        // Format the date/time with the specified timezone
        const dateWithTimezone = today.toLocaleString('en-US', {timeZone: 'Europe/Sofia'});

        const now = new Date(dateWithTimezone);
        const hour = now.getHours();
        const minutes = now.getMinutes();
        // Format the time as "HH:MM"
        const time = `${hour.toString().padStart(2, '0')}:${minutes.toString().padStart(2, '0')}`;

        let greeting;

        if (hour >= 5 && hour < 12) {
            greeting = (
                <>
                    <h1 className={'text-center text-gray-300 font-semibold text-2xl border-b mb-5'}>{time}</h1>
                    <h1 className={'text-center text-gray-300 font-semibold text-xl'}>🌄 Добро утро 😊</h1>
                </>
            );
        } else if (hour >= 12 && hour < 18) {
            greeting = (
                <>
                    <h1 className={'text-center text-gray-300 font-semibold text-2xl border-b mb-5'}>{time}</h1>
                    <h1 className={'text-center text-gray-300 font-semibold text-xl'}>☘️Добър ден 😊</h1>
                </>
            );
        } else if (hour >= 18 && hour < 22) {
            greeting = (
                <>
                    <h1 className={'text-center text-gray-300 font-semibold text-2xl border-b mb-5'}>{time}</h1>
                    <h1 className={'text-center text-gray-300 font-semibold text-xl'}>🌇 Добър вечер 😊</h1>
                </>
            );
        } else {
            greeting = (
                <>
                    <h1 className={'text-center text-gray-300 font-semibold text-2xl border-b mb-5'}>{time}</h1>
                    <h1 className={'text-center text-gray-300 font-semibold text-xl'}>Време е за лягане. Лека нощ 😴</h1>
                </>
            );
        }

        return greeting;
    }

    //Show the day and time when the user go to sleep
    function getDayAndTime(date) {
        console.log('get day name date: ', date)
        if (!date) {
            return 'Loading...';
        }
        date = new Date(date);
        // Get the abbreviated day name (e.g. "Sun")
        let dayName = date.toLocaleString('en-US', {weekday: 'short'});

        switch (dayName) {
            case 'Sun':
                dayName = 'Нед.';
                break;
            case 'Mon':
                dayName = 'Пон.';
                break;
            case 'Tue':
                dayName = 'Вт.';
                break;
            case 'Wed':
                dayName = 'Ср.';
                break;
            case 'Thu':
                dayName = 'Чет.';
                break;
            case 'Fri':
                dayName = 'Пет.';
                break;
            case 'Sat':
                dayName = 'Съб.';
                break;
            default:
                dayName = '';
                break;
        }

        // Get the hours and minutes
        const hours = date.getHours();
        const minutes = date.getMinutes();

        // Format the time as "HH:MM"
        const time = `${hours.toString().padStart(2, '0')}:${minutes.toString().padStart(2, '0')}`;

        return `${dayName} - ${time}`;
        // return { dayName, time };
    }

    function isTimeBetween5And18() {
        // Get the current date/time
        const today = new Date();
        // Format the date/time with the specified timezone
        const dateWithTimezone = today.toLocaleString('en-US', {timeZone: 'Europe/Sofia'});
        const now = new Date(dateWithTimezone);
        const hour = now.getHours();
        return hour >= 5 && hour < 18;
    }

    return (
        <>
            {errors ?
                <p className={'w-11/12 mx-auto py-2 bg-rose-50 text-center font-bold text-rose-900'}>{errors}</p> : ''}
            <main className={'bg-[#404955] w-11/12 mx-auto my-5 p-6 border rounded shadow'}>
                {/*<h1 className={'text-center font-semibold text-2xl'}>Моят сън 😴</h1>*/}
                {getGreeting()}

                <div className="flex flex-wrap justify-center gap-4 p-5">

                    {lastSleepLog?.sleep_end_time !== null
                        ? (
                            <>
                                {
                                    isLoadingTodaySleepLog
                                        ? <p>Зареждане...</p>
                                        : todaySleepLog
                                            ? (
                                                <>
                                                    <p>Днеска
                                                        спахте: {durationBetweenDateTimes(todaySleepLog.sleep_start_time, todaySleepLog.sleep_end_time)}</p>
                                                    <form onSubmit={startNapSession} method={'POST'}>
                                                        <p className="text-center">Котешка дрямква е допълнителен сън след
                                                            основния.
                                                            За да го стартираш просто натисни бутона по-долу.</p>
                                                        <p className={'text-center'}>👇</p>
                                                        <button className={tailwindClasses.btnFullLg}
                                                                type={'submit'}>Котешка Дрямка 😴
                                                        </button>
                                                    </form>
                                                </>
                                            )
                                            : isTimeBetween5And18()
                                                ? (
                                                    <form onSubmit={startNapSession} method={'POST'}>
                                                        <p className="text-center text-gray-300">Котешка дрямква е
                                                            допълнителен сън след основния.
                                                            За да го стартираш просто натисни бутона по-долу.</p>
                                                        <p className={'text-center mb-3'}>👇</p>
                                                        <button className={tailwindClasses.btnFullLg}
                                                                type={'submit'}>Котешка Дрямка 😴
                                                        </button>
                                                    </form>
                                                )
                                                : (
                                                    <form onSubmit={startSleepSession} method={'POST'}>
                                                        <button className={tailwindClasses.btnFullLg}
                                                                type={'submit'}>Заспивам 😴
                                                        </button>
                                                    </form>
                                                )
                                }
                            </>
                        )
                        : (
                            <>
                                <div>
                                    <p className={'text-center'}>Сънят ви е още в прогрес. 😴</p>
                                    <p className={'text-center'}>Легнохте си в {getDayAndTime(lastSleepLog?.sleep_start_time)}</p>
                                    <p className={'text-center'}>Спахте {durationBetweenDateTimes(lastSleepLog?.sleep_start_time)}</p>

                                    <form className={'my-5'} onSubmit={stopSleepSession} method={'POST'}>
                                        <button className={tailwindClasses.btnFullLg} type={'submit'}>Събудих се 🥱</button>
                                    </form>
                                </div>
                            </>
                        )
                    }

                    {/*<Link className={tailwindClasses.btnFullLg} to={'/sleep'}>Сън 😴</Link>*/}
                </div>
            </main>

        </>
    )
}

export default Sleep;
