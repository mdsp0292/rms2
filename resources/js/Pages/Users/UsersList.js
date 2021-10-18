import React from 'react';
import { InertiaLink } from '@inertiajs/inertia-react';
import Layout from "@/Shared/Layout";
import Helmet from "react-helmet";
import SearchFilterSimple from "@/Shared/SearchFilterSimple";
import CommonTableList from "@/Shared/Table/CommonTableList";


function UsersList () {
    return (
        <div>
            <Helmet title="Users" />

            <div>
                <h1 className="mb-8 font-bold text-md text-indigo-600"> Users </h1>
                <div className="w-full mb-6 flex justify-between items-center">
                    <SearchFilterSimple />

                    <InertiaLink
                        className="btn-indigo focus:outline-none"
                        href={route('users.create')}
                    >
                        <span>Create</span>
                        <span className="hidden md:inline"> user </span>
                    </InertiaLink>
                </div>
                <div className="w-full">
                    <CommonTableList />
                </div>

            </div>
        </div>
    )
}
UsersList.layout = page => <Layout children={page} />
export default UsersList;
