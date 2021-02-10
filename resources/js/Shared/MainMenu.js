import React from 'react';
import MainMenuItem from '@/Shared/MainMenuItem';
import { FaHome, FaUsers, FaCalculator, FaBoxOpen } from "react-icons/fa";

export default ({ className }) => {
  return (
    <div className={className}>
      <MainMenuItem text="Dashboard" link="dashboard" icon={<FaHome />} />
      <MainMenuItem text="Accounts" link="accounts" icon={<FaUsers />} />
      <MainMenuItem text="Opportunities" link="opportunities" icon={<FaCalculator />} />
      <MainMenuItem text="Products" link="products" icon={<FaBoxOpen />} />
    </div>
  );
};
