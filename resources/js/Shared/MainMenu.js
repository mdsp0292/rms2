import React from 'react';
import {FaBoxOpen, FaCalculator, FaHome, FaUsers} from "react-icons/fa";
import {InertiaLink, usePage} from "@inertiajs/inertia-react";
import classNames from "classnames";


function MainMenuItem({ icon, link, text }) {
    const isActive = route().current(link + '*');

    const iconClasses = classNames('w-4 h-4 mr-2', {
        'text-white fill-current': isActive,
        'text-geyser-500 group-hover:text-white fill-current': !isActive
    });

    const textClasses = classNames({
        'text-geyser-500 text-sm font-semibold': isActive,
        'text-geyser-500 text-sm font-semibold group-hover:text-white': !isActive
    });

    return (
        <div className="mb-4">
            <InertiaLink href={route(link)} className="flex items-center group ">
                <span className={iconClasses}>{icon}</span>
                <div className={textClasses}>{text}</div>
            </InertiaLink>
        </div>
    );
}

export default function MainMenu({className}) {
    const {auth} = usePage().props;
    const isUserOwner = auth.user.owner || false;

    return (
        <div className={className}>
            <MainMenuItem text="Dashboard" link="dashboard" icon={<FaHome/>}/>
            <MainMenuItem text="Accounts" link="accounts" icon={<FaUsers/>}/>
            <MainMenuItem text="Opportunities" link="opportunities" icon={<FaCalculator/>}/>
            {isUserOwner && <MainMenuItem text="Products" link="products" icon={<FaBoxOpen/>}/>}
        </div>
    );
};
