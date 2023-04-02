import {createBrowserRouter, Navigate} from 'react-router-dom';
import Login from './views/Login.jsx';
import NotFound from './views/NotFound.jsx';
import Stock from './views/StockSchedule.jsx';
import GuestLayout from './components/GuestLayout.jsx';
import DefaultLayout from './components/DefaultLayout.jsx';
import Ptt from './views/PttSchedule.jsx';
import PttScheduleForm from './views/PttScheduleForm.jsx';
import StockScheduleForm from './views/StockScheduleForm.jsx';

const router = createBrowserRouter([
    {
        path: '/',
        element: <Navigate to="/ptt" />
    },
    {
        path: '/',
        element: <DefaultLayout />,
        children: [
            {
                path: '/ptt',
                element: <Ptt />
            },
            {
                path: '/ptt/new',
                element: <PttScheduleForm key="pttScheduleCreate" />
            },
            {
                path: '/ptt/:id',
                element: <PttScheduleForm key="pttScheduleUpdate" />
            },
            {
                path: '/stock',
                element: <Stock />
            },
            {
                path: '/stock/new',
                element: <StockScheduleForm key="stockScheduleCreate" />
            },
            {
                path: '/stock/:id',
                element: <StockScheduleForm key="stockScheduleUpdate" />
            },
            {
                path: '/ecpay',
                element: <StockScheduleForm key="stockScheduleUpdate" />
            },
        ]
    },
    {
        path: '/',
        element: <GuestLayout />,
        children: [
            {
                path: '/login',
                element: <Login />
            },
        ]
    },
    {
        path: '*',
        element: <NotFound />
    }
])

export default router;
