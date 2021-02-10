import React from 'react';
import { InertiaLink, usePage } from '@inertiajs/inertia-react';
import Layout from '@/Shared/Layout';
import Icon from '@/Shared/Icon';
import Pagination from '@/Shared/Pagination';
import SearchFilter from '@/Shared/SearchFilter';

const Index = () => {
    const { accounts } = usePage().props;
    const {
        data,
        meta: { links }
    } = accounts;
    return (
        <div>
            <h1 className="mb-8 text-3xl font-bold">Accounts</h1>
            <div className="flex items-center justify-between mb-6">
                <SearchFilter />
                <InertiaLink
                    className="btn-indigo focus:outline-none"
                    href={route('accounts.create')}
                >
                    <span>Create</span>
                    <span className="hidden md:inline"> Account</span>
                </InertiaLink>
            </div>
            <div className="overflow-x-auto bg-white rounded shadow">
                <table className="w-full whitespace-nowrap">
                    <thead>
                    <tr className="font-bold text-left">
                        <th className="px-6 pt-5 pb-4">Name</th>
                        <th className="px-6 pt-5 pb-4">Email</th>
                        <th className="px-6 pt-5 pb-4">Phone</th>
                        <th className="px-6 pt-5 pb-4">Address</th>
                        <th className="px-6 pt-5 pb-4">Created on</th>
                    </tr>
                    </thead>
                    <tbody>
                    {data.map(({ id, name, email, phone, full_address, created_at, deleted_at }) => (
                        <tr
                            key={id}
                            className="hover:bg-gray-100 focus-within:bg-gray-100"
                        >
                            <td className="border-t">
                                <InertiaLink
                                    href={route('accounts.edit', id)}
                                    className="flex items-center px-6 py-4 focus:text-indigo-700 focus:outline-none"
                                >
                                    {name}
                                    {deleted_at && (
                                        <Icon
                                            name="trash"
                                            className="flex-shrink-0 w-3 h-3 ml-2 text-gray-400 fill-current"
                                        />
                                    )}
                                </InertiaLink>
                            </td>

                            <td className="border-t">
                                <InertiaLink
                                    tabIndex="-1"
                                    href={route('accounts.edit', id)}
                                    className="flex items-center px-6 py-4 focus:text-indigo focus:outline-none"
                                >
                                    {email}
                                </InertiaLink>
                            </td>

                            <td className="border-t">
                                <InertiaLink
                                    tabIndex="-1"
                                    href={route('accounts.edit', id)}
                                    className="flex items-center px-6 py-4 focus:text-indigo focus:outline-none"
                                >
                                    {phone}
                                </InertiaLink>
                            </td>

                            <td className="border-t">
                                <InertiaLink
                                    tabIndex="-1"
                                    href={route('accounts.edit', id)}
                                    className="flex items-center px-6 py-4 focus:text-indigo focus:outline-none"
                                >
                                    {full_address}
                                </InertiaLink>
                            </td>

                            <td className="border-t">
                                <InertiaLink
                                    tabIndex="-1"
                                    href={route('accounts.edit', id)}
                                    className="flex items-center px-6 py-4 focus:text-indigo focus:outline-none"
                                >
                                    {created_at}
                                </InertiaLink>
                            </td>
                        </tr>
                    ))}
                    {data.length === 0 && (
                        <tr>
                            <td className="px-6 py-4 border-t" colSpan="4">
                                No accounts found.
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

Index.layout = page => <Layout title="Accounts" children={page} />;

export default Index;
