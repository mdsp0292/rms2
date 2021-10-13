import React from 'react';
import Helmet from "react-helmet";
import Layout from '@/Shared/Layout';
import {InertiaLink, usePage} from "@inertiajs/inertia-react";
import CommonTableList from "@/Shared/Table/CommonTableList";
import SearchFilterSimple from "@/Shared/SearchFilterSimple";

function AccountsList () {
    return (
        <div>
            <Helmet title="Accounts" />

            <div>
                <h1 className="mb-8 font-bold text-md text-indigo-600"> Accounts </h1>
                <div className="w-full mb-6 flex justify-between items-center">
                    <SearchFilterSimple />

                    <InertiaLink
                        className="btn-indigo focus:outline-none"
                        href={route('accounts.create')}
                    >
                        <span>Create</span>
                        <span className="hidden md:inline"> Accounts</span>
                    </InertiaLink>
                </div>
                <div className="w-full">
                    <CommonTableList />
                </div>

            </div>
        </div>
    )
}

AccountsList.layout = page => <Layout children={page} />
export default AccountsList;
