import React from 'react';
import {InertiaLink} from "@inertiajs/inertia-react";

export default function BreadCrumbs({routeName, parent, child}) {
    return <div>
        <h1 className="mb-8 font-bold text-md">
            <InertiaLink href={routeName} className="text-indigo-600 hover:text-indigo-700">
                {parent}
            </InertiaLink>
            <span className="text-indigo-600 font-medium"> /</span> {child}
        </h1>
    </div>
}
