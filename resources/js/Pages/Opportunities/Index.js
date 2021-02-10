import React from 'react';
import { InertiaLink, usePage } from '@inertiajs/inertia-react';
import Layout from '@/Shared/Layout';
import Icon from '@/Shared/Icon';
import Pagination from '@/Shared/Pagination';
import SearchFilter from '@/Shared/SearchFilter';

const Index = () => {
    const { opportunities, is_owner } = usePage().props;
    const {
        data,
        meta: { links }
    } = opportunities;
    return (
        <div>
            <h1 className="mb-8 text-3xl font-bold">Opportunities</h1>
            <div className="flex items-center justify-between mb-6">
                <SearchFilter />
                {is_owner && <InertiaLink
                    className="btn-indigo focus:outline-none"
                    href={route('opportunities.create')}
                >
                    <span>Create</span>
                    <span className="hidden md:inline"> Opportunities</span>
                </InertiaLink>}
            </div>
            <div className="overflow-x-auto bg-white rounded shadow">
                <table className="w-full whitespace-nowrap">
                    <thead>
                    <tr className="font-bold text-left">
                        <th className="px-6 pt-5 pb-4">Name</th>
                        <th className="px-6 pt-5 pb-4">Account</th>
                        <th className="px-6 pt-5 pb-4">Sales Stage</th>
                        {/*<th className="px-6 pt-5 pb-4">Amount</th>*/}
                        <th className="px-6 pt-5 pb-4">Referral Start date</th>
                        <th className="px-6 pt-5 pb-4">Referral Amount</th>
                        <th className="px-6 pt-5 pb-4">Sale Start</th>
                        <th className="px-6 pt-5 pb-4" colSpan="2">Created on</th>
                    </tr>
                    </thead>
                    <tbody>
                    {data.map(({ id, name, account, sales_stage_string, referral_start_date, referral_amount, sale_start, sale_end, created_at, deleted_at }) => (
                        <tr
                            key={id}
                            className="hover:bg-gray-100 focus-within:bg-gray-100"
                        >
                            <td className="border-t items-center px-6 py-2 focus:text-indigo focus:outline-none">
                                {name}
                                {deleted_at && (
                                    <Icon
                                        name="trash"
                                        className="flex-shrink-0 w-3 h-3 ml-2 text-gray-400 fill-current"
                                    />
                                )}
                            </td>
                            <td className="border-t items-center px-6 py-2 focus:text-indigo focus:outline-none">
                                    {account ? account.name : ''}
                            </td>
                            <td className="border-t items-center px-6 py-2 focus:text-indigo focus:outline-none">
                                {sales_stage_string}
                            </td>
                            <td className="border-t items-center px-6 py-2 focus:text-indigo focus:outline-none">
                                {referral_start_date}
                            </td>

                            <td className="border-t items-center px-6 py-2 focus:text-indigo focus:outline-none">
                                {referral_amount && '$' + referral_amount}
                            </td>

                            <td className="border-t items-center px-6 py-2 focus:text-indigo focus:outline-none">
                                {sale_start}
                            </td>

                            <td className="border-t items-center px-6 py-2 focus:text-indigo focus:outline-none">
                                {sale_end}
                            </td>

                            <td className="border-t items-center px-6 py-2 focus:text-indigo focus:outline-none">
                                {created_at}
                            </td>
                            <td className="w-px border-t">
                                {is_owner && <InertiaLink
                                    tabIndex="-1"
                                    href={route('opportunities.edit', id)}
                                    className="flex items-center px-4 focus:outline-none"
                                >
                                    <Icon
                                        name="cheveron-right"
                                        className="block w-6 h-6 text-gray-400 fill-current"
                                    />
                                </InertiaLink> }
                            </td>
                        </tr>
                    ))}
                    {data.length === 0 && (
                        <tr>
                            <td className="px-6 py-4 border-t" colSpan="4">
                                No opportunities found.
                            </td>
                        </tr>
                    )}
                    </tbody>
                </table>
            </div>
            <Pagination links={links} />
        </div>
    );
};

Index.layout = page => <Layout title="Opportunities" children={page} />;

export default Index;
