import React, {useEffect, useState} from 'react';
import {InertiaLink, usePage} from "@inertiajs/inertia-react";
import {BsFillCaretDownFill, BsFillCaretUpFill} from "react-icons/bs";
import {usePrevious} from "react-use";
import {Inertia} from "@inertiajs/inertia";
import pickBy from "lodash/pickBy";
import Pagination from "@/Shared/Pagination";


export default function CommonTableList () {
    const { filters, table_columns, table_rows } = usePage().props;

    const {
        data,
        meta: { links }
    } = table_rows;

    const [sortOrder, setSortOrder] = useState(filters)

    const prevSortOrder = usePrevious(sortOrder);


    const handleSort = (e, sort, column) => {
        e.preventDefault();

        setSortOrder(() => ({
            search: filters.search || '',
            [column]: sort
        }));

    }

    useEffect(() => {
        if(prevSortOrder){
            Inertia.get(route(route().current()), pickBy(sortOrder), {
                replace: true,
                preserveState: false,
            });
        }
    },[sortOrder]);

    useEffect(() => {
        setSortOrder(filters);

    },[filters]);

    const EditLink = ({ routeLink, link, label }) => {
        return<InertiaLink
            className="py-2 px-6 flex items-center text-indigo-600 focus:outline-none cursor-pointer"
            href={route(routeLink, link)}
        >
            { label }
        </InertiaLink>
    }

    return<>
        <div className="bg-white rounded shadow overflow-x-auto">
            <table className="w-full whitespace-nowrap table-auto">
                <thead>
                <tr className="text-left font-normal text-sm">
                    {table_columns.map(( column ) => {
                        return<th
                            key={column.label}
                            className={`px-6 pt-5 pb-4`}
                        >
                            <div className={`${column.sort ? 'inline-flex' : ''}`}>
                                {column.label}
                                {column.sort && <div className="ml-2">
                                    <BsFillCaretUpFill
                                        className={`cursor-pointer hover:text-indigo-500 ${sortOrder[column.value] === 'asc' ? 'text-indigo-500' : 'text-gray-400'}`}
                                        onClick={e => handleSort(e, 'asc', column.value)}
                                    />
                                    <BsFillCaretDownFill
                                        className={`cursor-pointer hover:text-indigo-500 ${sortOrder[column.value] === 'desc' ? 'text-indigo-500' : 'text-gray-400'}`}
                                        onClick={e => handleSort(e, 'desc', column.value)}
                                    />
                                </div>}
                            </div>
                        </th>
                    })}
                </tr>
                </thead>
                <tbody>
                {data.length > 0 && data.map((row, index) => {
                    return (
                        <tr key={index} className="hover:bg-gray-100 focus-within:bg-gray-100 text-sm">
                            {table_columns.map((column) => {
                                return <td key={column.value} className="border-t">
                                    {column.link
                                        ? <EditLink routeLink={column.link.route} link={row[column.link.value]} label={row[column.value]}/>
                                        : <span className="py-2 px-6 flex items-center"> {row[column.value]} </span>
                                    }
                                </td>
                            })}
                        </tr>
                    )
                })}
                {data.length === 0 && (
                    <tr>
                        <td className="border-t px-3 py-2" colSpan="7">
                            No records found.
                        </td>
                    </tr>
                )}
                </tbody>
            </table>
        </div>
        <Pagination links={links} />
    </>
}
