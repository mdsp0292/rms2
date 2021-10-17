import React, {useState} from 'react';
import Helmet from 'react-helmet';
import {Inertia} from '@inertiajs/inertia';
import {usePage} from '@inertiajs/inertia-react';
import Layout from '@/Shared/Layout';
import LoadingButton from '@/Shared/LoadingButton';
import TextInput from '@/Shared/FormElements/TextInput';
import ToggleInput from "@/Shared/FormElements/ToggleInput";
import BreadCrumbs from "@/Shared/BreadCrumbs";

const Edit = () => {
    const {product, errors} = usePage().props;
    const [sending, setSending] = useState(false);

    const [values, setValues] = useState({
        name: product.name || '',
        amount: product.amount || '',
        reseller_amount: product.reseller_amount || '',
        active: product.active || false,
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
        Inertia.put(route('products.update', product.id), values, {
            onFinish: () => setSending(false)
        });
    }

    // function destroy() {
    //     if (confirm('Are you sure you want to delete this product?')) {
    //         Inertia.delete(route('products.destroy', product.id));
    //     }
    // }


    return (
        <div>
            <Helmet title={`${values.name}`}/>
            <BreadCrumbs routeName={route('products')} parent="Products" child={values.name}/>

            <div className="max-w-xl overflow-hidden bg-white rounded shadow">
                <form onSubmit={handleSubmit}>
                    <div className="flex flex-wrap p-8 -mb-8 -mr-6">
                        <TextInput
                            className="w-full pb-8 pr-6"
                            label="Product Name"
                            name="name"
                            errors={errors.name}
                            value={values.name}
                            onChange={handleChange}
                        />


                        <TextInput
                            className="w-full pb-8 pr-6"
                            label="Amount"
                            name="amount"
                            type="number"
                            errors={errors.amount}
                            value={values.amount}
                            onChange={handleChange}
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
                    <div className="flex items-center px-8 py-4 bg-gray-100 border-t border-gray-200">
                        <LoadingButton
                            loading={sending}
                            type="submit"
                            className="ml-auto btn-indigo"
                        >
                            Update product
                        </LoadingButton>
                    </div>
                </form>
            </div>
        </div>
    );
};

Edit.layout = page => <Layout children={page}/>;

export default Edit;
