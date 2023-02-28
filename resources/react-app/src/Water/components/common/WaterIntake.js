import {BsTrash} from "react-icons/bs";
import PropTypes from 'prop-types';
import Modal from "../../../components/ui/Modal/Modal";
import {useState} from "react";
import {Select} from "../../../components";
import {hoursInDay, minutesInHour, waterMlList} from "../../constants";
import {waterService} from "../../services";
import Alert from "../../../components/ui/Alert";
import {GrClose} from "react-icons/gr";


function WaterIntake({id,time,amount,getUpdatedWater}){

    const [showConfirmDelete, setShowConfirmDelete] = useState(false);
    const [showModal, setShowModal] = useState(false);
    const [errors, setErrors] = useState('');
    const [success, setSuccess] = useState('');


    const editAmountOfWaterIntake = (e) => {
        const updatedAmount = e.currentTarget.value;
        if (updatedAmount && updatedAmount >= 50) {
            waterService.update(id, {amount: updatedAmount}).then(r => {
                setSuccess(`Успешно променихте количеството вода в ${time} часа на ${updatedAmount} мл.`)
                getUpdatedWater(r);
                setTimeout(() => {
                    setSuccess('');
                },3000);
            }).catch(err => {
                getUpdatedWater(err);
            });
        }else {
            setErrors('Въвели сте невалидно количество вода!');
            setTimeout(() => {
                setErrors('');
            },3000);
        }
    }

    const deleteWatterIntake = () => {
        const waterIdToRemove = id;
        waterService.remove(id).then(r => {
            setSuccess(`Успешно изтрихте записа в ${time} часа.`)
            setTimeout(() => {
                setSuccess('');
                getUpdatedWater({id:waterIdToRemove},true);
            },3000);
        }).catch(err => {
            console.log('Error during deleting!')
            setErrors('Възникна грешка, моля презареди страницата и опитай пак.');
            setTimeout(() => {
                setErrors('');
            },3000);
        });
    }

    const editHourOfWaterIntake = (e) => {
        console.log('Edit Hour',e.currentTarget.value)
    }
    const editMinutesOfWaterIntake = (e) => {
        console.log('Edit Minute',e.currentTarget.value)
    }

    const openDeleteWaterIntakeModal = (waterData) => {
        console.log('DELETE: ', waterData);
        handleOpenModal();
    }

    const handleOpenModal = () => {setShowModal(true);};

    const handleCloseModal = () => {setShowModal(false);};

    return (
        <>
            <div  className="flex gpa-3 justify-between my-1 px-1 py-2 border">
                <p>
                    <span className={'font-bold text-gray-300'}>{time} - </span>
                    🥛
                    <strong className={'text-blue-200'}>{amount} мл.</strong>
                </p>
                <div className="flex gap-2 items-center">
                    <button className={'text-sm bg-gray-300 px-2 rounded border'}
                            onClick={() => handleOpenModal()}> Промяна 🖊️
                    </button>
                </div>
            </div>

            {errors ? <Alert message={errors} isError={true}/> : ''}
            {success ? <Alert message={success} /> : ''}

            <Modal isOpen={showModal} onClose={handleCloseModal}>

                {
                    showConfirmDelete
                        ? (
                            <div>
                                <h1 className="text-xl text-gray-700 text-center">
                                    Сигурни ли сте че искате да изтриете приетата вода в {time}?
                                </h1>
                                <div className="flex gap-2">

                                    <button className={'mt-5 w-full flex gap-3 items-center justify-center text-lg text-rose-900 bg-rose-50 px-4 py-2 border border-rose-900 rounded-lg'}
                                            onClick={deleteWatterIntake}>ДА! <BsTrash /></button>
                                    <button className={'mt-5 w-full flex gap-3 items-center justify-center text-lg text-cyan-900 bg-cyan-50 px-4 py-2 border border-cyan-900 rounded-lg'}
                                        onClick={() =>setShowConfirmDelete(false)}>Отмяна <GrClose /></button>
                                </div>
                            </div>
                        )
                        : (
                            <div>
                                <h1 className="text-xl text-gray-700 text-center">Редактиране на изпита вода</h1>
                                <h2 className="text-xl text-gray-700 text-center">в <span className={'text-cyan-900 font-semibold'}>{time}</span> часа.</h2>
                                <h2 className="mb-3 text-lg text-gray-700 text-center">Изпитото количество вода (мл)</h2>

                                <Select onChange={editAmountOfWaterIntake} defaultValue={amount} options={waterMlList} />

                                <div className="grid grid-cols-2 gap-1 justify-items-stretch">
                                    <div>
                                        <label className={'block text-center text-[13px]'}>Час</label>
                                        <Select onChange={editHourOfWaterIntake} defaultValue={time} options={hoursInDay} />
                                    </div>
                                    <div>
                                        <label className={'block text-center text-[13px]'}>Минути</label>
                                        <Select onChange={editMinutesOfWaterIntake} defaultValue={time} options={minutesInHour} />
                                    </div>
                                </div>

                                <button className={'mt-5 w-full flex gap-3 items-center justify-center text-lg text-rose-900 bg-rose-50 px-4 py-2 border border-rose-900 rounded-lg'}
                                        onClick={() =>setShowConfirmDelete(true)}>Изтрий <BsTrash /></button>

                            </div>
                        )
                }


            </Modal>
        </>
    );
}

WaterIntake.propTypes = {
    id: PropTypes.number.isRequired,
    time: PropTypes.string.isRequired,
    amount: PropTypes.number.isRequired,
}
export default WaterIntake;
