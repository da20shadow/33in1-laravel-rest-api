import {ComingSoonBox} from "../../index";
import {useStateContext} from "../../../context/ContextProvider";

function Workout() {
    const {logoutUser} = useStateContext();
    // if (err.message === 'Unauthenticated') {
    //     logoutUser();
    // }
    return (
        <ComingSoonBox emoji={'💪'} message={'Обичате да спортувате? Ако отговора ви "ДА" ' +
        'тогава ще заобичате и секцията с тренировки, анализи за това как да постигнете желаните резултати...'} />
    );
}
export default Workout;
