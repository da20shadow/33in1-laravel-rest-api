import {ComingSoonBox} from "../../index";
import {useStateContext} from "../../../context/ContextProvider";

function Work() {
    const {logoutUser} = useStateContext();
    // if (err.message === 'Unauthenticated') {
    //     logoutUser();
    // }
    return (
        <ComingSoonBox emoji={'🧑💼'} message={'Искате да знаете колко калории изгаряте по време на чистене, ' +
        'готвене, миене на чинии, и всякаква друга работа с максимална точност? Скоро ще го имате...'} />
    );
}
export default Work;
