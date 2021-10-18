import React, { useState } from 'react';
import Layout from "@/Shared/Layout";
import {InertiaLink, usePage} from "@inertiajs/inertia-react";
import {Helmet} from "react-helmet/es/Helmet";
import classNames from "classnames";

function DetailsLine ({ title, isBgGray, children}){

    const divClass = (isBgGray) => classNames(
        [
            'px-4 py-2 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6',
        ],
        {
            'bg-gray-50' : isBgGray === true,
            'bg-white' : isBgGray === false
        });

    return<div className={divClass(isBgGray)}>
        <dt className="text-sm font-medium text-gray-500">
            {title}
        </dt>
        <dd className="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
            {children}
        </dd>
    </div>
}

function HeaderAndBreadCrumbs ({ title }){
    return<>
        <Helmet title={title} />
        <div>
            <h1 className="mb-8 font-bold text-md">
                <InertiaLink href={route('opportunities')} className="text-indigo-600 hover:text-indigo-700">
                    Opportunities
                </InertiaLink>

                <span className="text-indigo-600 font-medium"> /</span> {title}
            </h1>
        </div>
    </>
}


function OpportunityView () {
    const {opportunity, invoice_status} = usePage().props;

    return<div>
        <HeaderAndBreadCrumbs title={opportunity.name} />

        <div className="grid grid-cols-1 gap-4 lg:grid-cols-2">
            <div className="max-w-3xl lg:my-4 lg:px-4">
                <div className="rounded bg-white">
                    <div className="px-4 py-5 sm:px-6">
                        <h3 className="text-lg leading-6 font-medium text-gray-900">
                            {opportunity.name}
                        </h3>
                    </div>
                    <div className="border-t border-gray-200">
                        <dl>
                            <DetailsLine title="Account" isBgGray={true}>
                                {opportunity.account_name || ''}
                            </DetailsLine>
                            <DetailsLine title="Product" isBgGray={false}>
                                {opportunity.product_name || ''}
                            </DetailsLine>
                            <DetailsLine title="Amount" isBgGray={true}>
                                {'$'+opportunity.amount}
                            </DetailsLine>
                            <DetailsLine title="Referral amount" isBgGray={false}>
                                {'$'+opportunity.referral_amount}
                            </DetailsLine>
                            <DetailsLine title="Status" isBgGray={true}>
                                {opportunity.sales_stage_string || ''}
                            </DetailsLine>
                            <DetailsLine title="Invoice paid" isBgGray={false}>
                                {invoice_status ? 'Yes' : 'No'}
                            </DetailsLine>
                        </dl>
                    </div>
                </div>
            </div>
        </div>
    </div>
}

OpportunityView.layout = page => <Layout children={page} />
export default OpportunityView;
