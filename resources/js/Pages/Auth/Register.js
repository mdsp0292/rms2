import React, {useState} from 'react';
import Helmet from 'react-helmet';
import {Inertia} from '@inertiajs/inertia';
import {InertiaLink, usePage} from '@inertiajs/inertia-react';
import Logo from '@/Shared/Logo';
import LoadingButton from '@/Shared/LoadingButton';
import TextInput from '@/Shared/FormElements/TextInput';

export default () => {
    const {errors, email, requestUri} = usePage().props;
    const [sending, setSending] = useState(false);
    const [values, setValues] = useState({
        email: email || '',
        password: '',
        password_confirmation: '',
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
        Inertia.post(requestUri, values, {
            onFinish: () => {
                setSending(false);
            }
        });
    }

    return (
        <div className="p-6 bg-steelblue-800 min-h-screen flex justify-center items-center">
            <Helmet title="Login"/>
            <div className="w-full max-w-md">
                <form
                    onSubmit={handleSubmit}
                    className="mt-8 bg-white rounded-lg shadow-xl overflow-hidden"
                >
                    <div className="px-10 py-12">
                        <h1 className="text-3xl font-bold text-center"> RMS </h1>
                        <div className="mx-auto mt-6 w-24 border-b-2"/>
                        <TextInput
                            className="mt-10"
                            label="Email"
                            name="email"
                            type="email"
                            errors={errors.email}
                            value={values.email}
                            onChange={handleChange}
                            disabled={true}
                        />

                        <TextInput
                            className="mt-6"
                            label="Password"
                            name="password"
                            type="password"
                            errors={errors.password}
                            value={values.password}
                            onChange={handleChange}
                        />

                        <TextInput
                            className="mt-6"
                            label="Confirm Password"
                            name="password_confirmation"
                            type="password"
                            errors={errors.password_confirmation}
                            value={values.password_confirmation}
                            onChange={handleChange}
                        />

                    </div>
                    <div className="px-10 py-4 bg-gray-100 border-t border-gray-200 flex justify-between items-center">
                        <InertiaLink
                            type="button"
                            className="text-sm mr-4 text-gray-600 hover:text-gray-900 underline cursor-pointer"
                            href="/login"
                        >
                            Already registered?
                        </InertiaLink>

                        <LoadingButton
                            type="submit"
                            loading={sending}
                            className="btn-indigo"
                        >
                            Register
                        </LoadingButton>
                    </div>
                </form>
            </div>
        </div>
    );
};
