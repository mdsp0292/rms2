import React from 'react';
import Helmet from "react-helmet";
import Layout from '@/Shared/Layout';
import {InertiaLink} from "@inertiajs/inertia-react";
import CommonTableList from "@/Shared/Table/CommonTableList";
import SearchFilterSimple from "@/Shared/SearchFilterSimple";

function ProductsList() {
    return (
        <div>
            <Helmet title="Accounts"/>

            <div>
                <h1 className="mb-8 font-bold text-md text-indigo-600"> Products </h1>
                <div className="w-full mb-6 flex justify-between items-center">
                    <SearchFilterSimple/>

                    <InertiaLink
                        className="btn-indigo focus:outline-none"
                        href={route('products.create')}
                    >
                        <span>Create</span>
                        <span className="hidden md:inline"> Products</span>
                    </InertiaLink>
                </div>
                <div className="w-1/2">
                    <CommonTableList/>
                </div>

            </div>
        </div>
    )
}

ProductsList.layout = page => <Layout children={page}/>
export default ProductsList;
