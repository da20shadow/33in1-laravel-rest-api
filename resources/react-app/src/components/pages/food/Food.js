import {ComingSoonBox} from "../../index";
import {useStateContext} from "../../../context/ContextProvider";

function Food() {
    const {logoutUser} = useStateContext();
    // if (err.message === 'Unauthenticated') {
    //     logoutUser();
    // }
    return (
        <ComingSoonBox emoji={'🍽️'} message={'Добавяне и анализ на храната която консумирате, ' +
        'съвети как да се храните за да постигнете желания от вас резултат + много други...'} />
    );
}

export default Food;
