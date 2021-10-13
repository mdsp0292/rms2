import React from 'react';
import Helmet from "react-helmet";
import Layout from '@/Shared/Layout';
import {InertiaLink, usePage} from "@inertiajs/inertia-react";
import CommonTableList from "@/Shared/Table/CommonTableList";
import SearchFilterSimple from "@/Shared/SearchFilterSimple";

function OpportunitiesList () {
    const { is_owner } = usePage().props;
    return (
        <div>
            <Helmet title="Opportunities" />

            <div>
                <h1 className="mb-8 font-bold text-md text-indigo-600"> Opportunities </h1>
                <div className="w-full mb-6 flex justify-between items-center">
                    <SearchFilterSimple />

                    {is_owner && <InertiaLink
                        className="btn-indigo focus:outline-none"
                        href={route('opportunities.create')}
                    >
                    <span>Create</span>
                    <span className="hidden md:inline"> Opportunities</span>
                        </InertiaLink>}
                </div>
                <div className="w-full">
                    <CommonTableList />
                </div>

            </div>
        </div>
    )
}

OpportunitiesList.layout = page => <Layout children={page} />
export default OpportunitiesList;
