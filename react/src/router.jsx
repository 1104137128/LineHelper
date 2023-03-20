import {createBrowserRouter, Navigate} from 'react-router-dom';
import Login from './views/Login.jsx';
import Users from './views/Users.jsx';
import NotFound from './views/NotFound.jsx';
import Dashboard from './views/Dashboard.jsx';
import GuestLayout from './components/GuestLayout.jsx';
import DefaultLayout from './components/DefaultLayout.jsx';

const router = createBrowserRouter([
    {
        path: '/',
        element: <Navigate to="/users" />
    },
    {
        path: '/',
        element: <DefaultLayout />,
        children: [
            {
                path: '/dashboard',
                element: <Dashboard />
            },
            {
                path: '/users',
                element: <Users />
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
