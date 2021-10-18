import React, { useState } from 'react';
import { Inertia } from '@inertiajs/inertia';
import { InertiaLink, usePage } from '@inertiajs/inertia-react';
import Layout from '@/Shared/Layout';
import LoadingButton from '@/Shared/LoadingButton';
import TextInput from '@/Shared/FormElements/TextInput';
import ToggleInput from "@/Shared/FormElements/ToggleInput";
import BreadCrumbs from "@/Shared/BreadCrumbs";

const ProductCreate = () => {
    const { errors } = usePage().props;
    const [sending, setSending] = useState(false);
    const [values, setValues] = useState({
        name: '',
        amount: '',
        reseller_amount: '',
        active: 1,
    });

    const handleChange = (key, value) => {
        setValues(currentValues => ({
            ...currentValues,
            [key]: value
        }));
    }

    function handleSubmit(e) {
        e.preventDefault();
        setSending(true);
        Inertia.post(route('products.store'), values, {
            onFinish: () => setSending(false)
        });
    }

    return (
        <div>
            <BreadCrumbs routeName={route('products')} parent="Products" child="Create" />

            <div className="max-w-2xl overflow-hidden bg-white rounded shadow">
                <form onSubmit={handleSubmit}>
                    <div className="flex flex-wrap p-8 -mb-8 -mr-6">
                        <TextInput
                            className="w-full pb-8 pr-6"
                            label="Product Name"
                            name="name"
                            errors={errors.name}
                            value={values.name}
                            onChange={e => handleChange('name', e.target.value)}
                        />


                        <TextInput
                            className="w-full pb-8 pr-6"
                            label="Amount"
                            name="amount"
                            type="number"
                            errors={errors.amount}
                            value={values.amount}
                            onChange={e => handleChange('amount', e.target.value)}
                        />

                        <TextInput
                            className="w-full pb-8 pr-6"
                            label="Reseller price"
                            name="reseller_amount"
                            type="reseller_amount"
                            errors={errors.reseller_amount}
                            value={values.reseller_amount}
                            onChange={e => handleChange('reseller_amount', e.target.value)}
                        />

                        <ToggleInput
                            className="w-full pb-8 pr-6"
                            label="Active"
                            name="active"
                            errors={errors.active}
                            checked={values.active}
                            onChange={e => handleChange('active', e.target.checked)}
                        />

                    </div>
                    <div className="flex items-center justify-end px-8 py-4 bg-gray-100 border-t border-gray-200">
                        <LoadingButton
                            loading={sending}
                            type="submit"
                            className="btn-indigo"
                        >
                            Create product
                        </LoadingButton>
                    </div>
                </form>
            </div>
        </div>
    );
};

ProductCreate.layout = page => <Layout title="Create Product" children={page} />;

export default ProductCreate;
