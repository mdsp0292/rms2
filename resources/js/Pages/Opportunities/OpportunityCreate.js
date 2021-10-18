import React, {useEffect, useState} from 'react';
import { Inertia } from '@inertiajs/inertia';
import { InertiaLink, usePage } from '@inertiajs/inertia-react';
import Layout from '@/Shared/Layout';
import LoadingButton from '@/Shared/LoadingButton';
import TextInput from '@/Shared/FormElements/TextInput';
import SelectInput2 from "@/Shared/FormElements/SelectInput2";


const OpportunityCreate = () => {
    let formattedDate = new Date().toISOString().slice(0,10);

    const { accounts , salesStages, products, errors } = usePage().props;
    const [sending, setSending] = useState(false);
    const [values, setValues] = useState({
        name: '',
        account_id: '',
        account_name: '',
        sales_stage: 1,
        amount: '',
        type: '',
        referral_percentage: '',
        referral_amount: '',
        referral_start_date: formattedDate,
        sale_start: '',
        product_id: '',
        product_name: ''
    });

    function handleChange(e) {
        const key = e.target.name;
        const value = e.target.value;
        setValues(values => ({
            ...values,
            [key]: value
        }));
    }

    const handleSelectChange = (key,e) => {
        setValues(values => ({
            ...values,
            [key]: e.value
        }));
    }

    // const calculateReferralAmount = () => {
    //     let referralAmount = values.referral_amount;
    //     if(values.amount != '' && values.referral_percentage != ''){
    //         referralAmount = (values.referral_percentage/100)*values.amount;
    //     }
    //
    //     setValues(values => ({
    //         ...values,
    //         referral_amount: referralAmount,
    //     }));
    // }

    const handleAccountChange = (key,e) => {
        setValues(values => ({
            ...values,
            account_id: e.value,
            account_name: e.label,
            name: e.label + ' - ' +values.product_name
        }));
    }

    const handleProductChange = (key,e) => {
        setValues(values => ({
            ...values,
            product_id: e.value,
            product_name: e.label,
            amount: e.amount,
            name: values.account_name + ' - ' +e.label
        }));
    }

    function handleSubmit(e) {
        e.preventDefault();
        setSending(true);
        Inertia.post(route('opportunities.store'), values, {
            onFinish: () => setSending(false)
        });
    }

    useEffect(() => {
        let referralAmount = 0;
        if(values.amount !== '' && values.referral_percentage !== ''){
            referralAmount = (values.referral_percentage/100)*values.amount;
        }

        setValues(currentValues => ({
            ...currentValues,
            referral_amount: referralAmount.toFixed(2),
        }));

    },[values.referral_percentage, values.amount])

    return (
        <div>
            <h1 className="mb-8 text-3xl font-bold">
                <InertiaLink
                    href={route('opportunities')}
                    className="text-indigo-600 hover:text-indigo-700"
                >
                    Opportunities
                </InertiaLink>
                <span className="font-medium text-indigo-600"> /</span> Create
            </h1>
            <div className="max-w-3xl overflow-hidden bg-white rounded shadow">
                    <div className="flex flex-wrap p-8 -mb-8 -mr-6">
                        <SelectInput2
                            className="w-full pb-8 pr-6 lg:w-1/2"
                            label="Account"
                            name="account_id"
                            options={accounts}
                            errors={errors.type}
                            onChange={e => handleAccountChange("account_id",e)}
                            defaultValue={accounts.filter(account => account.value === values.account_id)}
                            closeMenuOnSelect={true}
                        />

                        <SelectInput2
                            className="w-full pb-8 pr-6 lg:w-1/2"
                            label="Product"
                            name="product_id"
                            options={products}
                            errors={errors.product_id}
                            onChange={e => handleProductChange("product_id",e)}
                            defaultValue={products.filter(product => product.value === values.product_id)}
                            closeMenuOnSelect={true}
                        />

                        <TextInput
                            className="w-full pb-8 pr-6 lg:w-1/2"
                            label="Name"
                            name="name"
                            errors={errors.name}
                            value={values.name}
                            onChange={handleChange}
                        />

                        <SelectInput2
                            className="w-full pb-8 pr-6 lg:w-1/2"
                            label="Sales stage"
                            name="sales_stage"
                            options={salesStages}
                            errors={errors.sales_stage}
                            onChange={e => handleSelectChange("sales_stage",e)}
                            defaultValue={salesStages.filter(salesStage => salesStage.value === values.sales_stage)}
                            closeMenuOnSelect={true}
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

                        <TextInput
                            className="w-full pb-8 pr-6 lg:w-1/2"
                            label="Referral percentage"
                            name="referral_percentage"
                            type="number"
                            errors={errors.referral_percentage}
                            value={values.referral_percentage}
                            onChange={handleChange}
                        />

                        <TextInput
                            className="w-full pb-8 pr-6 lg:w-1/2"
                            label="Referral amount"
                            name="referral_amount"
                            type="number"
                            errors={errors.referral_amount}
                            value={values.referral_amount}
                            onChange={handleChange}
                        />

                        {/*<div className="w-full pb-8 mt-6 pr-6 lg:w-1/2">*/}
                        {/*    <button*/}
                        {/*    className="px-3 py-3 rounded bg-red-500 text-white text-sm hover:bg-orange-500 focus:bg-orange-500"*/}
                        {/*        onClick={calculateReferralAmount}>*/}
                        {/*       Calculate Referral amount*/}
                        {/*    </button>*/}
                        {/*</div>*/}

                        <TextInput
                            className="w-full pb-8 pr-6 lg:w-1/2"
                            label="Referral start date"
                            name="referral_start_date"
                            type="date"
                            errors={errors.referral_start_date}
                            value={values.referral_start_date}
                            onChange={handleChange}
                        />
                        <TextInput
                            className="w-full pb-8 pr-6 lg:w-1/2"
                            label="Sale start"
                            name="sale_start"
                            type="date"
                            errors={errors.sale_start}
                            value={values.sale_start}
                            onChange={handleChange}
                        />

                    </div>
                    <div className="flex items-center justify-end px-8 py-4 bg-gray-100 border-t border-gray-200">
                        <LoadingButton
                            loading={sending}
                            type="submit"
                            className="btn-indigo"
                            onClick={handleSubmit}
                        >
                            Create Opportunity
                        </LoadingButton>
                    </div>
            </div>
        </div>
    );
};

OpportunityCreate.layout = page => <Layout title="Create Contact" children={page} />;

export default OpportunityCreate;
