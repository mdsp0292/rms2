import React, { useState } from 'react';
import { Inertia } from '@inertiajs/inertia';
import { InertiaLink, usePage } from '@inertiajs/inertia-react';
import Layout from '@/Shared/Layout';
import LoadingButton from '@/Shared/LoadingButton';
import TextInput from '@/Shared/TextInput';

const Create = () => {
    const { errors } = usePage().props;
    const [sending, setSending] = useState(false);
    const [values, setValues] = useState({
        name: '',
        amount: '',
    });

    function handleChange(e) {
        const key = e.target.name;
        const value = e.target.value;
        setValues(values => ({
            ...values,
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
            <h1 className="mb-8 text-3xl font-bold">
                <InertiaLink
                    href={route('products')}
                    className="text-indigo-600 hover:text-indigo-700"
                >
                    Products
                </InertiaLink>
                <span className="font-medium text-indigo-600"> /</span> Create
            </h1>
            <div className="max-w-3xl overflow-hidden bg-white rounded shadow">
                <form onSubmit={handleSubmit}>
                    <div className="flex flex-wrap p-8 -mb-8 -mr-6">
                        <TextInput
                            className="w-full pb-8 pr-6 lg:w-1/2"
                            label="Product Name"
                            name="name"
                            errors={errors.name}
                            value={values.name}
                            onChange={handleChange}
                        />


                        <TextInput
                            className="w-full pb-8 pr-6 lg:w-1/2"
                            label="Amount"
                            name="amount"
                            type="number"
                            errors={errors.amount}
                            value={values.amount}
                            onChange={handleChange}
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

Create.layout = page => <Layout title="Create Product" children={page} />;

export default Create;
