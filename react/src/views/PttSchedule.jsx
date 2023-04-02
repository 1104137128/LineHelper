import { useEffect, useState } from "react";
import { Link } from "react-router-dom";
import axiosClient from "../axios-client"

export default function Ptt() {
    const [ptt, setPtt] = useState([]);

    useEffect(() => {
        getPttSchedule();
    }, [])

    const getPttSchedule = () => {
        axiosClient.get('/ptt').then((res) => {
            setPtt(res.data);
        })
    }

    return (
        <div>
            <div style={{display: 'flex', justifyContent: 'space-between', alignItems: 'center'}}>
                <h1>PTT排程列表</h1>
                <Link to="/ptt/new" className="btn-add">Add New</Link>
            </div>
            <div className="card animated fadeInDown">
                <table>
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>看版</th>
                            <th>每小時幾分跑一次</th>
                            <th>創立時間</th>
                            <th>狀態</th>
                        </tr>
                    </thead>
                    <tbody>
                        {
                            ptt.map(i => (
                                <tr>
                                    <td>{i.id}</td>
                                    <td>{i.name}</td>
                                    <td>{i.schedule_time}</td>
                                    <td>{new Date(i.created_at).toLocaleString()}</td>
                                    <td>
                                        <Link to={'/ptt/' + i.id} className="btn-edit">Edit</Link> &nbsp;
                                        <button className="btn-delete">Stop</button>
                                    </td>
                                </tr>
                            ))
                        }
                    </tbody>
                </table>
            </div>
        </div>
    )
}
