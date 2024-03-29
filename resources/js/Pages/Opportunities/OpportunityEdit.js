import React, {useEffect, useState} from 'react';
import Helmet from 'react-helmet';
import {Inertia} from '@inertiajs/inertia';
import {usePage} from '@inertiajs/inertia-react';
import Layout from '@/Shared/Layout';
import LoadingButton from '@/Shared/LoadingButton';
import TextInput from '@/Shared/FormElements/TextInput';
import SelectInput2 from "@/Shared/FormElements/SelectInput2";
import BreadCrumbs from "@/Shared/BreadCrumbs";

const OpportunityEdit = () => {
    let formattedDate = new Date().toISOString().slice(0, 10);

    const {accounts, salesStages, products, errors, opportunity} = usePage().props;
    const [sending, setSending] = useState(false);

    const [values, setValues] = useState({
        name: opportunity.name || '',
        account_id: opportunity.account_id || '',
        account_name: opportunity.account_name || '',
        sales_stage: opportunity.sales_stage || 1,
        amount: opportunity.amount || '',
        type: opportunity.type || '',
        referral_percentage: opportunity.referral_percentage || '',
        referral_amount: opportunity.referral_amount || '',
        referral_start_date: opportunity.referral_start_date || formattedDate,
        sale_start: opportunity.sale_start || '',
        product_id: opportunity.product_id || '',
        product_name: opportunity.product_name || ''
    });

    function handleChange(e) {
        const key = e.target.name;
        const value = e.target.value;
        setValues(currentValues => ({
            ...currentValues,
            [key]: value
        }));
    }

    const handleSelectChange = (key, e) => {
        setValues(currentValues => ({
            ...currentValues,
            [key]: e.value
        }));
    }

    function handleSubmit(e) {
        e.preventDefault();
        setSending(true);
        Inertia.put(route('opportunities.update', opportunity.id), values, {
            onFinish: () => setSending(false)
        });
    }

    useEffect(() => {
        let referralAmount = 0;
        if (values.amount !== '' && values.referral_percentage !== '') {
            referralAmount = (values.referral_percentage / 100) * values.amount;
        }

        setValues(currentValues => ({
            ...currentValues,
            referral_amount: referralAmount.toFixed(2),
        }));

    }, [values.referral_percentage, values.amount])

    return (
        <div>
            <Helmet title={`${values.name}`}/>
            <BreadCrumbs routeName={route('opportunities')} parent="Opportunities" child={values.name}/>

            <div className="max-w-3xl overflow-hidden bg-white rounded shadow">
                <div className="flex flex-wrap p-8 -mb-8 -mr-6">
                    <SelectInput2
                        className="w-full pb-8 pr-6 lg:w-1/2"
                        label="Account"
                        name="account_id"
                        options={accounts}
                        errors={errors.type}
                        //onChange={e => handleAccountChange("account_id", e)}
                        defaultValue={accounts.filter(account => account.value === values.account_id)}
                        closeMenuOnSelect={true}
                        isDisabled={true}
                    />

                    <SelectInput2
                        className="w-full pb-8 pr-6 lg:w-1/2"
                        label="Product"
                        name="product_id"
                        options={products}
                        errors={errors.product_id}
                        //onChange={e => handleProductChange("product_id", e)}
                        defaultValue={products.filter(product => product.value === values.product_id)}
                        closeMenuOnSelect={true}
                        isDisabled={true}
                    />

                    <TextInput
                        className="w-full pb-8 pr-6 lg:w-1/2"
                        label="Name"
                        name="name"
                        errors={errors.name}
                        value={values.name}
                        onChange={handleChange}
                        disabled={true}
                    />

                    <SelectInput2
                        className="w-full pb-8 pr-6 lg:w-1/2"
                        label="Sales stage"
                        name="sales_stage"
                        options={salesStages}
                        errors={errors.sales_stage}
                        onChange={e => handleSelectChange("sales_stage", e)}
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
                <div className="flex items-center px-8 py-4 bg-gray-100 border-t border-gray-200">
                    <LoadingButton
                        loading={sending}
                        type="submit"
                        className="ml-auto btn-indigo"
                        onClick={handleSubmit}
                    >
                        Update opportunity
                    </LoadingButton>
                </div>
            </div>
        </div>
    );
};

OpportunityEdit.layout = page => <Layout children={page}/>;

export default OpportunityEdit;
