import React, {useState} from 'react';
import {Inertia} from '@inertiajs/inertia';
import {usePage} from '@inertiajs/inertia-react';
import Layout from '@/Shared/Layout';
import LoadingButton from '@/Shared/LoadingButton';
import TextInput from '@/Shared/FormElements/TextInput';
import SelectInput from '@/Shared/FormElements/SelectInput';
//import FileInput from '@/Shared/FileInput';
import {toFormData} from '@/utils';
import BreadCrumbs from "@/Shared/BreadCrumbs";

const UserCreate = () => {
    const {errors} = usePage().props;
    const [sending, setSending] = useState(false);

    const [values, setValues] = useState({
        first_name: '',
        last_name: '',
        email: '',
        //password: '',
        type: 3,
    });

    function handleChange(e) {
        const key = e.target.name;
        setValues(currentValues => ({
            ...currentValues,
            [key]: e.target.value
        }));
    }


    function handleSubmit(e) {
        e.preventDefault();
        setSending(true);

        const formData = toFormData(values);

        Inertia.post(route('users.store'), formData, {
            onFinish: () => setSending(false)
        });
    }

    return (
        <div>
            <BreadCrumbs routeName={route('users')} parent="Users" child="Create"/>

            <div className="max-w-3xl overflow-hidden bg-white rounded shadow">
                <form name="createForm" onSubmit={handleSubmit}>
                    <div className="flex flex-wrap p-8 -mb-8 -mr-6">
                        <TextInput
                            className="w-full pb-8 pr-6 lg:w-1/2"
                            label="First Name"
                            name="first_name"
                            errors={errors.first_name}
                            value={values.first_name}
                            onChange={handleChange}
                        />
                        <TextInput
                            className="w-full pb-8 pr-6 lg:w-1/2"
                            label="Last Name"
                            name="last_name"
                            errors={errors.last_name}
                            value={values.last_name}
                            onChange={handleChange}
                        />
                        <TextInput
                            className="w-full pb-8 pr-6 lg:w-1/2"
                            label="Email"
                            name="email"
                            type="email"
                            errors={errors.email}
                            value={values.email}
                            onChange={handleChange}
                        />

                        <SelectInput
                            className="w-full pb-8 pr-6 lg:w-1/2"
                            label="Type"
                            name="type"
                            errors={errors.type}
                            value={values.type}
                            onChange={handleChange}
                        >
                            <option value="1">Admin</option>
                            <option value="2">Reseller</option>
                            <option value="3">Referrer</option>
                        </SelectInput>

                    </div>
                    <div className="flex items-center justify-end px-8 py-4 bg-gray-100 border-t border-gray-200">
                        <LoadingButton
                            loading={sending}
                            type="submit"
                            className="btn-indigo"
                        >
                            Create User
                        </LoadingButton>
                    </div>
                </form>
            </div>
        </div>
    );
};

UserCreate.layout = page => <Layout title="Create User" children={page}/>;
export default UserCreate;
