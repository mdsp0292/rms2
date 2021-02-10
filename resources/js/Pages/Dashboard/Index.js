import React from 'react';
import Layout from '@/Shared/Layout';
import { FaBusinessTime, FaMoneyBill, FaDollarSign, FaRegCalendarCheck } from 'react-icons/fa';
import {usePage} from "@inertiajs/inertia-react";

function CardData({cardTitle, cardIcon, cardStats}) {
    return<div className="flex flex-col w-full p-6 sm:w-1/2 xl:w-1/4">
        <div className="shadow-sm rounded-md bg-white">
            <div className="text-gray-500 pt-3 pl-3"> {cardTitle}</div>
            <div className="flex flex-1 items-center px-5 py-6 ">
                <div className="p-3 rounded-full bg-mirage-300">
                    <div className="text-white">
                        {cardIcon}
                    </div>
                </div>
                <div className="mx-5">
                    <h4 className="text-2xl font-semibold text-gray-700">{cardStats}</h4>
                </div>
            </div>
        </div>
    </div>
}

const Dashboard = () => {
    const { totalCustomers, totalOpportunities, totalOpportunitiesValue, totalOpportunitiesValueThisMonth } = usePage().props;
  return (
    <div>
      <h1 className="mb-8 text-3xl font-bold">Dashboard</h1>
        <div className="mt-4">
            <div className="flex flex-wrap -mx-6">
                <CardData cardTitle="Total customers" cardStats={totalCustomers || 0} cardIcon={<FaBusinessTime />}/>
                <CardData cardTitle="Total opportunities" cardStats={totalOpportunities || 0} cardIcon={<FaMoneyBill />}/>
                <CardData cardTitle="Total opportunities value" cardStats={totalOpportunitiesValue || 0} cardIcon={<FaDollarSign />}/>
                <CardData cardTitle="Total opportunities this month" cardStats={totalOpportunitiesValueThisMonth || 0} cardIcon={<FaRegCalendarCheck />}/>
            </div>

        </div>


    </div>
  );
};


Dashboard.layout = page => <Layout title="Dashboard" children={page} />;

export default Dashboard;
