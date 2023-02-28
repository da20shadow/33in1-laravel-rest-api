import {FormLayout, Select} from "../../../components";
import {hoursInDay, minutesInHour} from "../../constants";

function EditWaterIntakeForm({id,amount,time}){

    const editWaterIntakeHandler = (e) => {
        e.preventDefault();
        console.log(e.currentTarget)
    }

    return (
        <FormLayout onSubmitHandler={editWaterIntakeHandler} >

            <Select name={'amount'} options={hoursInDay} defaultValue={amount} />

            <div className="flex gap-1">
                <Select name={'hour'} options={hoursInDay} defaultValue={time.substr(0,2)} />
                <Select name={'minute'} options={minutesInHour} defaultValue={time.substr(3,5)} />
            </div>

        </FormLayout>
    )
}

export default EditWaterIntakeForm;
