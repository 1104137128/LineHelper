import { useEffect, useState } from "react";
import { Link } from "react-router-dom";
import axiosClient from "../axios-client"

export default function Stock() {
    const [stock, setStock] = useState([]);

    useEffect(() => {
        getStockSchedule();
    }, [])

    const getStockSchedule = () => {
        axiosClient.get('/stock').then((res) => {
            setStock(res.data);
        })
    }

    return (
        <div>
            <div style={{display: 'flex', justifyContent: 'space-between', alignItems: 'center'}}>
                <h1>股票排程列表</h1>
                <Link to="/stock/new" className="btn-add">Add New</Link>
            </div>
            <div className="card animated fadeInDown">
                <table>
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>股票代碼</th>
                            <th>創立時間</th>
                            <th>狀態</th>
                        </tr>
                    </thead>
                    <tbody>
                        {
                            stock.map(i => (
                                <tr>
                                    <td>{i.id}</td>
                                    <td>{i.name}</td>
                                    <td>{new Date(i.created_at).toLocaleString()}</td>
                                    <td>
                                        <Link to={'/stock/' + i.id} className="btn-edit">Edit</Link> &nbsp;
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
