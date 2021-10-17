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

const DashboardIndex = () => {
    const { stats} = usePage().props;

    const { total_customers,
        total_opportunities,
        total_opportunities_value,
        total_opportunities_value_this_month
    } = stats;

  return (
    <div>
      <h1 className="mb-8 text-3xl font-bold">Dashboard</h1>
        <div className="mt-4">
            <div className="flex flex-wrap -mx-6">
                <CardData
                    cardTitle="Total customers"
                    cardStats={total_customers || 0}
                    cardIcon={<FaBusinessTime />}
                />

                <CardData
                    cardTitle="Total opportunities"
                    cardStats={total_opportunities || 0}
                    cardIcon={<FaMoneyBill />}
                />

                <CardData
                    cardTitle="Total opportunities value"
                    cardStats={total_opportunities_value || 0}
                    cardIcon={<FaDollarSign />}
                />

                <CardData
                    cardTitle="Total opportunities this month"
                    cardStats={total_opportunities_value_this_month || 0}
                    cardIcon={<FaRegCalendarCheck />}
                />

            </div>
        </div>
    </div>
  );
};


DashboardIndex.layout = page => <Layout title="Dashboard" children={page} />;
export default DashboardIndex;
