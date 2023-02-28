import {Routes,Route,Navigate} from "react-router-dom";
import {useEffect, useState} from "react";
import {useStateContext} from "./context/ContextProvider";
import {Header, Home, NotFound} from "./components";
import {AddBodyComposition, BodyComposition, Dashboard, EditBodyComposition, Login, Register} from "./User/components";
import {Sleep} from "./Sleep/components";
import {Water, WaterStat} from "./Water/components";
import {Food} from "./Food/components";
import {Work} from "./Work/components";
import {Workout} from "./Workout/components";
import {userService} from "./User/services";

function App() {
    const {user,isLogged,loginUser,logoutUser} = useStateContext();
    useEffect(() => {
        let localStoreUser = localStorage.getItem('user');
        if (!isLogged || !localStoreUser) {
            userService.get().then(r => {
                loginUser(r.token)
                console.log(r)
            }).catch(err => {
                if (err.message === 'Unauthenticated.') {
                    logoutUser()
                }
            });
        }
    },[])
    return (
        <>
            <Header />

            <Routes>
                <Route path={'/'} element={<Home/>} />
                <Route path={'/login'} element={isLogged ? <Navigate to="/dashboard" replace={true} /> : <Login/>} />
                <Route path={'/register'} element={isLogged ? <Navigate to="/dashboard" replace={true} /> : <Register/>} />
                <Route path={'/dashboard'} element={isLogged ?  <Dashboard/> : <Navigate to="/login" replace={true} />} />
                <Route path={'/body-composition'} element={isLogged ?  <BodyComposition/> : <Navigate to="/login" replace={true} />} />
                <Route path={'/body-composition/add'} element={isLogged ?  <AddBodyComposition/> : <Navigate to="/login" replace={true} />} />
                <Route path={'/body-composition/edit'} element={isLogged ?  <EditBodyComposition/> : <Navigate to="/login" replace={true} />} />
                <Route path={'/sleep'} element={isLogged ?  <Sleep/> : <Navigate to="/login" replace={true} />} />
                <Route path={'/water/add'} element={isLogged ?  <Water/> : <Navigate to="/login" replace={true} />} />
                <Route path={'/water/stat'} element={isLogged ?  <WaterStat/> : <Navigate to="/login" replace={true} />} />
                <Route path={'/food'} element={isLogged ?  <Food/> : <Navigate to="/login" replace={true} />} />
                <Route path={'/work'} element={isLogged ?  <Work/> : <Navigate to="/login" replace={true} />} />
                <Route path={'/workout'} element={isLogged ?  <Workout/> : <Navigate to="/login" replace={true} />} />
                <Route path={'/*'} element={<NotFound/> } />
            </Routes>

        </>
    );
}

export default App;
