import tailwindClasses from "../../../constants/tailwindClasses";
import {Link} from "react-router-dom";
import {useEffect, useState} from "react";
import {waterService} from "../../../services";
import {ComingSoonBox} from "../../index";
import {useStateContext} from "../../../context/ContextProvider";

function WaterStat() {

    const {logoutUser} = useStateContext();
    const [water,setWater] = useState([]);
    useEffect(()=> {
        waterService.getAll().then(r => {
            console.log(r)
            setWater(r);
        }).catch(err =>{
            console.log(err)
            if (err.message === 'Unauthenticated') {
                logoutUser();
            }
        })
    },[])

    return (
        <>
            <ComingSoonBox emoji={'🥛'} message={'30 дневна статистика за приема ви на вода и анализ на хидратацията на тялото ви.'} />
            {/*<main className={'bg-[#404955] w-11/12 mx-auto my-5 p-6 border rounded shadow'}>*/}

                {/*<h1 className={'text-center font-semibold text-2xl'}>30 дневна статистика</h1>*/}
                {/*<p className="text-lg font-bold text-center">Прием на вода</p>*/}

                {/*<div className="flex flex-wrap justify-center gap-4 p-5">*/}

                {/*    <h3 className={'text-center text-2xl font-semibold'}>24-ти Феб 2023</h3>*/}
                {/*    <p>Час: 06:30 - 100 мл.</p>*/}
                {/*    <p>Час: 09:00 - 500 мл.</p>*/}
                {/*    <p>Час: 11:00 - 500 мл.</p>*/}
                {/*    <p>Час: 14:00 - 500 мл.</p>*/}
                {/*    <p>Час: 17:00 - 500 мл.</p>*/}
                {/*    <p>Час: 19:00 - 250 мл.</p>*/}

                {/*    <h3 className={'text-center text-2xl font-semibold'}>24-ти Феб 2023</h3>*/}
                {/*    <p>Час: 06:30 - 100 мл.</p>*/}
                {/*    <p>Час: 09:00 - 500 мл.</p>*/}
                {/*    <p>Час: 11:00 - 500 мл.</p>*/}
                {/*    <p>Час: 14:00 - 500 мл.</p>*/}
                {/*    <p>Час: 17:00 - 500 мл.</p>*/}
                {/*    <p>Час: 19:00 - 250 мл.</p>*/}


                {/*    <Link className={tailwindClasses.btnFullLg} to={'/water'}>Статистика</Link>*/}

                {/*</div>*/}
            {/*</main>*/}

        </>
    )
}

export default WaterStat;
